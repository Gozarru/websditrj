<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        // Setiap hak akses di config/roles.php menjadi Gate: @can('posts.approve'), middleware 'can:users.manage', dst.
        foreach (array_keys(config('roles.permissions')) as $perm) {
            Gate::define($perm, fn (User $u) => $u->is_active && $u->hasPermission($perm));
        }
    }
}
