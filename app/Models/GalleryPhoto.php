<?php

namespace App\Models;

use App\Models\Concerns\Audited;
use Illuminate\Database\Eloquent\Model;

class GalleryPhoto extends Model
{
    use Audited;

    protected $fillable = ['image', 'caption'];

    public function auditName(): string
    {
        return 'Foto galeri';
    }

    public function auditTitle(): string
    {
        return $this->caption ?: ('#'.$this->getKey());
    }
}
