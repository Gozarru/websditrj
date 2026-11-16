<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait ManagesImages
{
    /** Simpan unggahan baru, hapus foto lama bila diganti/dihapus. Mengembalikan path terbaru. */
    protected function saveImage(Request $r, ?string $old, string $dir, string $field = 'image'): ?string
    {
        if ($r->hasFile($field)) {
            $this->deleteImage($old);

            return $r->file($field)->store($dir, 'uploads');
        }

        if ($r->boolean('remove_'.$field)) {
            $this->deleteImage($old);

            return null;
        }

        return $old;
    }

    protected function deleteImage(?string $path): void
    {
        if ($path) {
            Storage::disk('uploads')->delete($path);
        }
    }
}
