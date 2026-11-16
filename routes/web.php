<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil/{slug}', [PageController::class, 'profil'])->name('profil');
Route::get('/informasi/berita', [PostController::class, 'index'])->name('posts.index');
Route::get('/informasi/berita/{post:slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/informasi/pengumuman', [PageController::class, 'pengumuman'])->name('pengumuman');
Route::get('/informasi/agenda', [PageController::class, 'agenda'])->name('agenda');
Route::get('/informasi/prestasi', [PageController::class, 'prestasi'])->name('prestasi');
Route::get('/media-belajar/{grade?}', [PageController::class, 'media'])->name('media');
Route::get('/galeri/foto', [PageController::class, 'galeri'])->name('galeri');
Route::get('/kontak', [PageController::class, 'kontak'])->name('kontak');

// Alamat lama
Route::redirect('/berita', '/informasi/berita', 301);
Route::get('/berita/{slug}', fn (string $slug) => redirect()->route('posts.show', $slug, 301));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->middleware('throttle:6,1');
});
Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');

Route::prefix('admin')->name('admin.')->middleware(['auth', \App\Http\Middleware\EnsureUserActive::class])->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard')->middleware('can:dashboard');

    // Berita & pengumuman: hak akses diperiksa di dalam controller (per tahap alur publikasi)
    Route::resource('posts', Admin\PostController::class);
    Route::post('posts/{post}/{action}', [Admin\PostController::class, 'transition'])
        ->where('action', 'submit|check|approve|return|publish|unpublish')->name('posts.transition');

    Route::middleware('can:agenda.manage')->group(function () {
        Route::resource('agendas', Admin\AgendaController::class)->except('show');
    });

    Route::middleware('can:content.manage')->group(function () {
        Route::resource('achievements', Admin\AchievementController::class)->except('show');
        Route::resource('media', Admin\LearningMediaController::class)->except('show')->parameters(['media' => 'medium']);
        Route::get('gallery', [Admin\GalleryController::class, 'index'])->name('gallery.index');
        Route::post('gallery', [Admin\GalleryController::class, 'store'])->name('gallery.store');
        Route::put('gallery/{photo}', [Admin\GalleryController::class, 'update'])->name('gallery.update');
        Route::delete('gallery/{photo}', [Admin\GalleryController::class, 'destroy'])->name('gallery.destroy');
    });

    Route::middleware('can:settings.manage')->group(function () {
        Route::get('settings', [Admin\SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [Admin\SettingController::class, 'update'])->name('settings.update');

        // Menu utama website (tambah, ubah, hapus, sembunyikan, urutkan)
        Route::post('menu/reset', [Admin\MenuController::class, 'reset'])->name('menu.reset');
        Route::post('menu/{menu}/toggle', [Admin\MenuController::class, 'toggle'])->name('menu.toggle');
        Route::post('menu/{menu}/move/{dir}', [Admin\MenuController::class, 'move'])->where('dir', 'up|down')->name('menu.move');
        Route::resource('menu', Admin\MenuController::class)->except('show')->parameters(['menu' => 'menu']);
    });

    Route::middleware('can:users.manage')->group(function () {
        Route::resource('users', Admin\UserController::class)->except('show');
    });

    Route::get('audit', [Admin\AuditController::class, 'index'])->name('audit.index')->middleware('can:audit.view');

    Route::get('account', [Admin\AccountController::class, 'edit'])->name('account.edit');
    Route::put('account', [Admin\AccountController::class, 'update'])->name('account.update');
});
