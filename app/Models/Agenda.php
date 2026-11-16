<?php

namespace App\Models;

use App\Models\Concerns\Audited;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use Audited;

    protected $fillable = ['title', 'starts_on', 'ends_on', 'time_text', 'location', 'description', 'created_by'];

    protected function casts(): array
    {
        return ['starts_on' => 'date', 'ends_on' => 'date'];
    }

    /** Agenda yang belum lewat (berakhir hari ini atau setelahnya). */
    public function scopeUpcoming($q)
    {
        return $q->whereRaw('COALESCE(ends_on, starts_on) >= ?', [today()->toDateString()])->orderBy('starts_on');
    }

    public function auditName(): string
    {
        return 'Agenda';
    }

    public function dateLabel(): string
    {
        $s = $this->starts_on;
        if ($this->ends_on && ! $this->ends_on->isSameDay($s)) {
            return $s->translatedFormat('j M').' – '.$this->ends_on->translatedFormat('j M Y');
        }

        return $s->translatedFormat('j F Y');
    }
}
