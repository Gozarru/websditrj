<?php

namespace App\Models;

use App\Models\Concerns\Audited;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use Audited;

    protected $fillable = ['title', 'year', 'level', 'description', 'image'];

    public function auditName(): string
    {
        return 'Prestasi';
    }
}
