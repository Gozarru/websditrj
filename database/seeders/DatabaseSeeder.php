<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('site.admin.email');
        $password = config('site.admin.password');

        if (! $email || ! $password) {
            $this->command->error('Isi ADMIN_EMAIL dan ADMIN_PASSWORD di file .env, lalu jalankan lagi: php artisan db:seed');

            return;
        }

        User::updateOrCreate(
            ['email' => $email],
            ['name' => config('site.admin.name'), 'password' => $password, 'role' => 'admin', 'is_active' => true]
        );

        $this->command->info("Akun admin siap: {$email}");
    }
}
