<?php

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Buat akun admin baru atau atur ulang kata sandi admin yang lupa.
Artisan::command('admin:reset {email} {password}', function (string $email, string $password) {
    if (strlen($password) < 8) {
        $this->error('Kata sandi minimal 8 karakter.');

        return 1;
    }

    $user = User::firstOrNew(['email' => $email]);
    $user->name = $user->name ?: 'Admin Sekolah';
    $user->role = 'admin';
    $user->is_active = true;
    $user->password = $password;
    $user->save();

    $this->info("Akun {$email} siap dipakai login.");
})->purpose('Buat atau atur ulang akun admin');

// Terbitkan berita/pengumuman terjadwal yang waktunya sudah tiba.
Artisan::command('posts:publish-due', function () {
    $n = \App\Models\Post::promoteDue();
    $this->info("$n tulisan diterbitkan.");
})->purpose('Terbitkan tulisan terjadwal');

Schedule::command('posts:publish-due')->everyMinute();
