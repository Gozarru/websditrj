<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryPhoto;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    use ManagesImages;

    public function index()
    {
        return view('admin.gallery.index', ['items' => GalleryPhoto::latest()->latest('id')->paginate(24)]);
    }

    public function store(Request $r)
    {
        $v = $r->validate([
            'photos' => ['required', 'array', 'max:20'],
            'photos.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'caption' => ['nullable', 'string', 'max:200'],
        ], [], ['photos' => 'Foto', 'photos.*' => 'Foto', 'caption' => 'Keterangan']);

        foreach ($r->file('photos') as $file) {
            GalleryPhoto::create([
                'image' => $file->store('gallery', 'uploads'),
                'caption' => $v['caption'] ?? null,
            ]);
        }

        return redirect()->route('admin.gallery.index')->with('ok', count($r->file('photos')).' foto ditambahkan.');
    }

    public function update(Request $r, GalleryPhoto $photo)
    {
        $v = $r->validate(['caption' => ['nullable', 'string', 'max:200']], [], ['caption' => 'Keterangan']);
        $photo->update(['caption' => $v['caption'] ?? null]);

        return redirect()->back()->with('ok', 'Keterangan foto disimpan.');
    }

    public function destroy(GalleryPhoto $photo)
    {
        $this->deleteImage($photo->image);
        $photo->delete();

        return redirect()->back()->with('ok', 'Foto dihapus.');
    }
}
