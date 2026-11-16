<?php

namespace App\Models;

use App\Models\Concerns\Audited;
use Illuminate\Database\Eloquent\Model;

class LearningMedia extends Model
{
    use Audited;

    protected $table = 'learning_media';

    protected $fillable = ['title', 'grade', 'type', 'url', 'description'];

    public function auditName(): string
    {
        return 'Media belajar';
    }
}
