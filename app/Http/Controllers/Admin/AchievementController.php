<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AchievementController extends Controller
{
    use ManagesImages;

    public function index()
    {
        return view('admin.achievements.index', ['items' => Achievement::orderByDesc('year')->orderByDesc('id')->paginate(20)]);
    }

    public function create()
    {
        return view('admin.achievements.form', ['item' => new Achievement(['year' => date('Y'), 'level' => 'Sekolah'])]);
    }

    public function store(Request $r)
    {
        $d = $this->data($r);
        $d['image'] = $this->saveImage($r, null, 'achievements');
        Achievement::create($d);

        return redirect()->route('admin.achievements.index')->with('ok', 'Prestasi disimpan.');
    }

    public function edit(Achievement $achievement)
    {
        return view('admin.achievements.form', ['item' => $achievement]);
    }

    public function update(Request $r, Achievement $achievement)
    {
        $d = $this->data($r);
        $d['image'] = $this->saveImage($r, $achievement->image, 'achievements');
        $achievement->update($d);

        return redirect()->route('admin.achievements.index')->with('ok', 'Prestasi diperbarui.');
    }

    public function destroy(Achievement $achievement)
    {
        $this->deleteImage($achievement->image);
        $achievement->delete();

        return redirect()->route('admin.achievements.index')->with('ok', 'Prestasi dihapus.');
    }

    private function data(Request $r): array
    {
        return $r->validate([
            'title' => ['required', 'string', 'max:200'],
            'year' => ['required', 'integer', 'between:1990,2100'],
            'level' => ['required', Rule::in(config('site.levels'))],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ], [], ['title' => 'Nama prestasi', 'year' => 'Tahun', 'level' => 'Tingkat', 'description' => 'Keterangan', 'image' => 'Foto']);
    }
}
