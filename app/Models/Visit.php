<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    public $timestamps = false;

    protected $fillable = ['visited_on', 'visitor_hash', 'hits'];

    protected function casts(): array
    {
        return ['visited_on' => 'date'];
    }
}
