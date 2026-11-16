<?php

namespace App\Models\Concerns;

use App\Models\ActivityLog;

/** Mencatat tambah/ubah/hapus data ke log aktivitas secara otomatis. */
trait Audited
{
    public static function bootAudited(): void
    {
        static::created(fn ($m) => ActivityLog::record('create', "Menambah {$m->auditName()}: {$m->auditTitle()}", $m));

        static::updated(function ($m) {
            $changed = array_diff(array_keys($m->getChanges()), ['updated_at', 'remember_token', 'last_login_at']);
            if ($changed) {
                ActivityLog::record('update', "Mengubah {$m->auditName()}: {$m->auditTitle()} (".implode(', ', $changed).')', $m);
            }
        });

        static::deleted(fn ($m) => ActivityLog::record('delete', "Menghapus {$m->auditName()}: {$m->auditTitle()}", $m));
    }

    public function auditName(): string
    {
        return class_basename($this);
    }

    public function auditTitle(): string
    {
        return (string) ($this->title ?? $this->getKey());
    }
}
