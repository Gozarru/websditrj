<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\MenuItem;
use App\Support\SiteMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class MenuController extends Controller
{
    public function index()
    {
        return view('admin.menu.index', [
            'items' => MenuItem::whereNull('parent_id')->with('children')->orderBy('position')->orderBy('id')->get(),
        ]);
    }

    public function create(Request $r)
    {
        $parent = MenuItem::whereNull('parent_id')->find($r->integer('parent'));

        return $this->form(new MenuItem(['parent_id' => $parent?->id]));
    }

    public function store(Request $r)
    {
        $data = $this->data($r);
        MenuItem::create($data + ['position' => $this->nextPosition($data['parent_id'])]);

        return redirect()->route('admin.menu.index')->with('ok', 'Menu ditambahkan.');
    }

    public function edit(MenuItem $menu)
    {
        return $this->form($menu);
    }

    public function update(Request $r, MenuItem $menu)
    {
        $data = $this->data($r, $menu);
        if ((int) $data['parent_id'] !== (int) $menu->parent_id) {
            $data['position'] = $this->nextPosition($data['parent_id']); // pindah kelompok: taruh paling akhir
        }
        $menu->update($data);

        return redirect()->route('admin.menu.index')->with('ok', 'Menu diperbarui.');
    }

    public function destroy(MenuItem $menu)
    {
        DB::transaction(function () use ($menu) {
            $menu->children->each->delete();
            $menu->delete();
        });

        return redirect()->route('admin.menu.index')->with('ok', 'Menu dihapus.');
    }

    /** Tampilkan / sembunyikan menu tanpa menghapusnya. */
    public function toggle(MenuItem $menu)
    {
        $menu->update(['is_visible' => ! $menu->is_visible]);

        return redirect()->route('admin.menu.index')
            ->with('ok', $menu->is_visible ? "Menu \"{$menu->label}\" ditampilkan." : "Menu \"{$menu->label}\" disembunyikan.");
    }

    /** Geser urutan menu satu langkah ke atas atau ke bawah di antara menu setingkat. */
    public function move(MenuItem $menu, string $dir)
    {
        $ids = MenuItem::where('parent_id', $menu->parent_id)->orderBy('position')->orderBy('id')->pluck('id')->all();
        $i = array_search($menu->id, $ids);
        $j = $dir === 'up' ? $i - 1 : $i + 1;

        if ($i !== false && isset($ids[$j])) {
            [$ids[$i], $ids[$j]] = [$ids[$j], $ids[$i]];
            DB::transaction(function () use ($ids) {
                foreach ($ids as $pos => $id) {
                    DB::table('menu_items')->where('id', $id)->update(['position' => $pos + 1]);
                }
            });
            ActivityLog::record('update', "Mengubah urutan Menu: {$menu->label}", $menu);
        }

        return redirect()->route('admin.menu.index');
    }

    /** Hapus semua menu lalu isi kembali dengan menu bawaan. */
    public function reset()
    {
        DB::transaction(function () {
            DB::table('menu_items')->delete();
            SiteMenu::seedDefaults();
        });
        ActivityLog::record('settings', 'Mengembalikan menu situs ke bawaan');

        return redirect()->route('admin.menu.index')->with('ok', 'Menu dikembalikan ke bawaan.');
    }

    private function form(MenuItem $item)
    {
        return view('admin.menu.form', [
            'item' => $item,
            'parents' => MenuItem::whereNull('parent_id')->when($item->exists, fn ($q) => $q->whereKeyNot($item->id))
                ->orderBy('position')->orderBy('id')->get(),
            'pageGroups' => SiteMenu::pageGroups(),
            'hasChildren' => $item->exists && $item->children()->exists(),
        ]);
    }

    private function nextPosition(?int $parentId): int
    {
        return (int) MenuItem::where('parent_id', $parentId)->max('position') + 1;
    }

    private function data(Request $r, ?MenuItem $item = null): array
    {
        $v = $r->validate([
            'label' => ['required', 'string', 'max:60'],
            'parent_id' => ['nullable', 'integer', Rule::exists('menu_items', 'id')->whereNull('parent_id')],
            'link_type' => ['required', Rule::in(['page', 'url', 'none'])],
            'page' => ['nullable', 'required_if:link_type,page', Rule::in(array_keys(SiteMenu::pages()))],
            'url' => ['nullable', 'required_if:link_type,url', 'string', 'max:255', 'regex:~^(https?://|/)\S*$~i'],
            'new_tab' => ['nullable', 'boolean'],
            'is_visible' => ['nullable', 'boolean'],
        ], [
            'page.required_if' => 'Pilih halaman tujuan.',
            'page.in' => 'Halaman tujuan tidak dikenal.',
            'url.required_if' => 'Isi alamat tujuan.',
            'url.regex' => 'Alamat harus diawali https:// (atau http://), atau / untuk alamat di dalam situs ini.',
            'parent_id.exists' => 'Menu induk tidak ditemukan.',
        ], ['label' => 'Nama menu', 'parent_id' => 'Letak menu', 'link_type' => 'Jenis tautan', 'page' => 'Halaman tujuan', 'url' => 'Alamat tujuan']);

        $parentId = isset($v['parent_id']) ? (int) $v['parent_id'] : null;

        if ($parentId !== null) {
            if ($item && $parentId === (int) $item->id) {
                throw ValidationException::withMessages(['parent_id' => 'Menu tidak bisa diletakkan di dalam dirinya sendiri.']);
            }
            if ($item && $item->children()->exists()) {
                throw ValidationException::withMessages(['parent_id' => 'Menu ini masih punya submenu. Pindahkan atau hapus submenunya dulu sebelum menjadikannya submenu.']);
            }
            if ($v['link_type'] === 'none') {
                throw ValidationException::withMessages(['link_type' => 'Submenu harus punya tautan (halaman situs atau alamat lain).']);
            }
        }

        return [
            'label' => trim($v['label']),
            'parent_id' => $parentId,
            'link_type' => $v['link_type'],
            'page' => $v['link_type'] === 'page' ? $v['page'] : null,
            'url' => $v['link_type'] === 'url' ? trim($v['url']) : null,
            'new_tab' => $v['link_type'] !== 'none' && $r->boolean('new_tab'),
            'is_visible' => $r->boolean('is_visible'),
        ];
    }
}
