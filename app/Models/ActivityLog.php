<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ActivityLog extends Model
{
    public const ACTIONS = [
        'login' => 'Masuk', 'logout' => 'Keluar', 'login_failed' => 'Gagal masuk',
        'create' => 'Tambah', 'update' => 'Ubah', 'delete' => 'Hapus',
        'submit' => 'Ajukan', 'check' => 'Periksa', 'approve' => 'Setujui', 'return' => 'Kembalikan',
        'publish' => 'Terbit', 'unpublish' => 'Tarik', 'settings' => 'Pengaturan',
    ];

    protected $fillable = ['user_id', 'user_name', 'role', 'action', 'description', 'subject_type', 'subject_id', 'ip'];

    public static function record(string $action, string $description, ?Model $subject = null, ?string $actor = null): void
    {
        try {
            $u = Auth::user();
            static::create([
                'user_id' => $u?->id,
                'user_name' => $actor ?? $u?->name ?? 'Sistem',
                'role' => $u?->role,
                'action' => $action,
                'description' => Str::limit($description, 500, '…'),
                'subject_type' => $subject ? class_basename($subject) : null,
                'subject_id' => $subject?->getKey(),
                'ip' => app()->runningInConsole() ? null : request()->ip(),
            ]);
        } catch (\Throwable $e) {
            report($e); // pencatatan log tidak boleh menggagalkan aksi pengguna
        }
    }

    public function actionLabel(): string
    {
        return self::ACTIONS[$this->action] ?? $this->action;
    }
}
