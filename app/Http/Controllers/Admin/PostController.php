<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Post;
use App\Support\PostWorkflow;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    use ManagesImages;

    public function index(Request $r)
    {
        $u = $r->user();
        abort_unless($u->canAny(['posts.view', 'posts.write']), 403);
        Post::promoteDue();

        $base = Post::visibleTo($u);
        $counts = (clone $base)->selectRaw('status, count(*) as n')->groupBy('status')->pluck('n', 'status');

        $q = (clone $base)->with('author');
        if (array_key_exists($r->query('status'), Post::STATUSES)) {
            $q->where('status', $r->query('status'));
        }
        if (array_key_exists($r->query('type'), Post::TYPES)) {
            $q->where('type', $r->query('type'));
        }
        if ($s = trim((string) $r->query('q'))) {
            $q->where('title', 'like', '%'.$s.'%');
        }

        return view('admin.posts.index', [
            'items' => $q->latest('updated_at')->latest('id')->paginate(15)->withQueryString(),
            'counts' => $counts,
            'total' => $counts->sum(),
        ]);
    }

    public function create(Request $r)
    {
        abort_unless($r->user()->can('posts.write'), 403);
        $type = array_key_exists($r->query('type'), Post::TYPES) ? $r->query('type') : 'berita';

        return view('admin.posts.form', ['item' => new Post(['type' => $type, 'status' => 'draft'])]);
    }

    public function store(Request $r)
    {
        abort_unless($r->user()->can('posts.write'), 403);
        $d = $this->data($r);
        $d['slug'] = $this->uniqueSlug($d['title']);
        $d['image'] = $this->saveImage($r, null, 'posts');
        $d['status'] = 'draft';
        $d['author_id'] = $r->user()->id;
        $post = Post::create($d);

        return $this->afterSave($r, $post, "{$post->typeLabel()} disimpan sebagai draf.");
    }

    public function show(Request $r, Post $post)
    {
        $this->authorizeView($r, $post);

        return view('admin.posts.show', $this->panelData($r, $post));
    }

    public function edit(Request $r, Post $post)
    {
        abort_unless(PostWorkflow::canEdit($post, $r->user()), 403, 'Tulisan ini tidak bisa diubah pada tahap sekarang.');

        return view('admin.posts.form', ['item' => $post] + $this->panelData($r, $post));
    }

    public function update(Request $r, Post $post)
    {
        abort_unless(PostWorkflow::canEdit($post, $r->user()), 403);
        $d = $this->data($r);
        $d['image'] = $this->saveImage($r, $post->image, 'posts');

        // Tulisan yang sudah diperiksa/disetujui lalu diubah harus diperiksa ulang.
        $reset = in_array($post->status, ['checked', 'approved'], true);
        if ($reset) {
            $d['status'] = 'submitted';
        }
        $post->update($d);

        return $this->afterSave($r, $post, $reset
            ? 'Perubahan disimpan. Karena isinya berubah, tulisan perlu diperiksa ulang.'
            : "{$post->typeLabel()} diperbarui.");
    }

    public function destroy(Request $r, Post $post)
    {
        abort_unless(PostWorkflow::canDelete($post, $r->user()), 403);
        $this->deleteImage($post->image);
        $post->delete();

        return redirect()->route('admin.posts.index')->with('ok', 'Tulisan dihapus.');
    }

    public function transition(Request $r, Post $post, string $action)
    {
        $this->authorizeView($r, $post);
        try {
            $msg = PostWorkflow::apply($post, $action, $r->user(), $r->input('note'), $r->input('publish_at'));
        } catch (\DomainException $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Carbon\Exceptions\InvalidFormatException $e) {
            return back()->with('error', 'Format tanggal/jam tayang tidak valid.');
        }

        return redirect()->route('admin.posts.show', $post)->with('ok', $msg);
    }

    private function afterSave(Request $r, Post $post, string $msg)
    {
        if ($r->boolean('submit_after') && in_array('submit', PostWorkflow::allowed($post->fresh(), $r->user()), true)) {
            $msg = PostWorkflow::apply($post->fresh(), 'submit', $r->user());
        }

        return redirect()->route('admin.posts.show', $post)->with('ok', $msg);
    }

    private function authorizeView(Request $r, Post $post): void
    {
        abort_unless(Post::visibleTo($r->user())->whereKey($post->id)->exists() && $r->user()->canAny(['posts.view', 'posts.write']), 403);
    }

    private function panelData(Request $r, Post $post): array
    {
        return [
            'post' => $post->load(['author', 'checker', 'approver', 'publisher']),
            'actions' => PostWorkflow::allowed($post, $r->user()),
            'canEdit' => PostWorkflow::canEdit($post, $r->user()),
            'history' => ActivityLog::where('subject_type', 'Post')->where('subject_id', $post->id)->latest()->latest('id')->take(30)->get(),
        ];
    }

    private function data(Request $r): array
    {
        $v = $r->validate([
            'type' => ['required', 'in:'.implode(',', array_keys(Post::TYPES))],
            'title' => ['required', 'string', 'max:200'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'published_at' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ], [], ['type' => 'Jenis', 'title' => 'Judul', 'excerpt' => 'Ringkasan', 'body' => 'Isi', 'published_at' => 'Jadwal tayang', 'image' => 'Foto']);

        return [
            'type' => $v['type'],
            'title' => $v['title'],
            'excerpt' => $v['excerpt'] ?? null,
            'body' => $v['body'],
            'published_at' => $v['published_at'] ?? null,
        ];
    }

    private function uniqueSlug(string $title): string
    {
        $base = Str::slug($title) ?: 'tulisan';
        $slug = $base;
        $i = 2;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
