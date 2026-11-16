<?php

namespace App\Models;

use App\Models\Concerns\Audited;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Audited, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'is_active'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function hasPermission(string $perm): bool
    {
        $perms = config("roles.roles.{$this->role}.perms", []);

        return in_array('*', $perms, true) || in_array($perm, $perms, true);
    }

    public function roleLabel(): string
    {
        return config("roles.roles.{$this->role}.label", ucfirst((string) $this->role));
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function initials(): string
    {
        $parts = preg_split('/\s+/', trim($this->name));

        return mb_strtoupper(mb_substr($parts[0] ?? '?', 0, 1).(isset($parts[1]) ? mb_substr($parts[1], 0, 1) : ''));
    }

    public function auditName(): string
    {
        return 'Pengguna';
    }

    public function auditTitle(): string
    {
        return $this->name.' ('.$this->roleLabel().')';
    }
}
