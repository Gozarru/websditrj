<?php

namespace App\Models;

use App\Models\Concerns\Audited;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Post extends Model
{
    use Audited;

    public const TYPES = ['berita' => 'Berita', 'pengumuman' => 'Pengumuman'];

    public const STATUSES = [
        'draft' => 'Draf',
        'submitted' => 'Menunggu diperiksa',
        'checked' => 'Menunggu persetujuan',
        'approved' => 'Disetujui',
        'scheduled' => 'Terjadwal',
        'published' => 'Tayang',
    ];

    protected $fillable = [
        'type', 'status', 'author_id', 'title', 'slug', 'excerpt', 'body', 'image', 'published_at',
        'submitted_at', 'checked_by', 'checked_at', 'approved_by', 'approved_at', 'published_by', 'review_note',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime', 'submitted_at' => 'datetime',
            'checked_at' => 'datetime', 'approved_at' => 'datetime',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function checker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'published_by');
    }

    /** Yang tampil di website: berstatus tayang, atau terjadwal yang waktunya sudah tiba. */
    public function scopePublished(Builder $q): Builder
    {
        return $q->where(function ($w) {
            $w->where(fn ($x) => $x->where('status', 'published')
                ->where(fn ($y) => $y->whereNull('published_at')->orWhere('published_at', '<=', now())))
                ->orWhere(fn ($x) => $x->where('status', 'scheduled')->where('published_at', '<=', now()));
        });
    }

    public function scopeOfType(Builder $q, string $type): Builder
    {
        return $q->where('type', $type);
    }

    /** Editor hanya melihat tulisannya sendiri; peran lain melihat semuanya. */
    public function scopeVisibleTo(Builder $q, User $u): Builder
    {
        if ($u->hasPermission('posts.view') || $u->hasPermission('posts.manage')) {
            return $q;
        }

        return $q->where('author_id', $u->id);
    }

    /** Ubah tulisan terjadwal yang waktunya sudah tiba menjadi tayang. Dipanggil scheduler dan dasbor. */
    public static function promoteDue(): int
    {
        $n = 0;
        foreach (static::where('status', 'scheduled')->where('published_at', '<=', now())->get() as $p) {
            static::withoutEvents(function () use ($p) {
                $p->status = 'published';
                $p->save();
            });
            ActivityLog::record('publish', "Terbit otomatis sesuai jadwal — {$p->typeLabel()}: {$p->title}", $p);
            $n++;
        }

        return $n;
    }

    public function typeLabel(): string
    {
        return self::TYPES[$this->type] ?? 'Berita';
    }

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    public function summary(): string
    {
        return $this->excerpt ?: Str::limit(strip_tags($this->body), 140);
    }

    public function auditName(): string
    {
        return $this->typeLabel();
    }
}
