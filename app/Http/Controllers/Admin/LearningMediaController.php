<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LearningMedia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LearningMediaController extends Controller
{
    public function index()
    {
        return view('admin.media.index', ['items' => LearningMedia::orderBy('grade')->orderBy('title')->paginate(30)]);
    }

    public function create()
    {
        return view('admin.media.form', ['item' => new LearningMedia(['grade' => 'Kelas 1', 'type' => 'Tautan'])]);
    }

    public function store(Request $r)
    {
        LearningMedia::create($this->data($r));

        return redirect()->route('admin.media.index')->with('ok', 'Media belajar disimpan.');
    }

    public function edit(LearningMedia $medium)
    {
        return view('admin.media.form', ['item' => $medium]);
    }

    public function update(Request $r, LearningMedia $medium)
    {
        $medium->update($this->data($r));

        return redirect()->route('admin.media.index')->with('ok', 'Media belajar diperbarui.');
    }

    public function destroy(LearningMedia $medium)
    {
        $medium->delete();

        return redirect()->route('admin.media.index')->with('ok', 'Media belajar dihapus.');
    }

    private function data(Request $r): array
    {
        return $r->validate([
            'title' => ['required', 'string', 'max:200'],
            'grade' => ['required', Rule::in(config('site.grades'))],
            'type' => ['required', Rule::in(config('site.media_types'))],
            'url' => ['required', 'url', 'max:500'],
            'description' => ['nullable', 'string', 'max:500'],
        ], [], ['title' => 'Judul', 'grade' => 'Kelas', 'type' => 'Jenis', 'url' => 'Tautan', 'description' => 'Keterangan']);
    }
}
