<?php

namespace App\Models;

use App\Models\Concerns\Audited;
use App\Support\SiteMenu;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use Audited;

    protected $fillable = ['parent_id', 'label', 'link_type', 'page', 'url', 'new_tab', 'is_visible', 'position'];

    protected $attributes = ['link_type' => 'page', 'new_tab' => false, 'is_visible' => true];

    protected function casts(): array
    {
        return ['new_tab' => 'boolean', 'is_visible' => 'boolean', 'position' => 'integer'];
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('position')->orderBy('id');
    }

    public function auditName(): string
    {
        return 'Menu';
    }

    public function auditTitle(): string
    {
        return (string) $this->label;
    }

    /** Alamat tujuan menu ini; null bila tidak punya tautan. */
    public function href(): ?string
    {
        return SiteMenu::link($this->only(['link_type', 'page', 'url', 'new_tab']))['url'] ?? null;
    }

    /** Keterangan tujuan untuk daftar di admin. */
    public function targetLabel(): string
    {
        return match ($this->link_type) {
            'page' => SiteMenu::pages()[$this->page] ?? 'Halaman tidak ditemukan',
            'url' => (string) $this->url,
            default => 'Tanpa tautan (judul dropdown)',
        };
    }
}
