<?php

// Hak akses per peran. '*' = semua hak akses.
return [
    'roles' => [
        'admin' => [
            'label' => 'Admin',
            'desc' => 'Mengelola seluruh sistem: pengguna, pengaturan, konten, dan log aktivitas.',
            'perms' => ['*'],
        ],
        'kepala_sekolah' => [
            'label' => 'Kepala Sekolah',
            'desc' => 'Menyetujui dan menerbitkan berita/pengumuman, memantau dasbor dan log aktivitas.',
            'perms' => ['dashboard', 'posts.view', 'posts.approve', 'posts.publish', 'audit.view'],
        ],
        'operator' => [
            'label' => 'Operator',
            'desc' => 'Memeriksa tulisan, menerbitkan, serta mengelola agenda, prestasi, media belajar, galeri, dan pengaturan situs.',
            'perms' => ['dashboard', 'posts.view', 'posts.write', 'posts.manage', 'posts.check', 'posts.publish', 'agenda.manage', 'content.manage', 'settings.manage'],
        ],
        'editor' => [
            'label' => 'Editor',
            'desc' => 'Menulis berita dan pengumuman, lalu mengajukannya untuk diperiksa.',
            'perms' => ['dashboard', 'posts.write'],
        ],
    ],

    // Daftar hak akses (untuk Gate dan tabel peran di halaman Pengguna).
    'permissions' => [
        'dashboard' => 'Melihat dasbor',
        'posts.write' => 'Menulis berita/pengumuman dan mengajukannya',
        'posts.view' => 'Melihat semua berita/pengumuman',
        'posts.manage' => 'Mengubah dan menghapus tulisan siapa pun',
        'posts.check' => 'Memeriksa tulisan',
        'posts.approve' => 'Menyetujui tulisan',
        'posts.publish' => 'Menerbitkan dan menjadwalkan',
        'agenda.manage' => 'Mengelola agenda',
        'content.manage' => 'Mengelola prestasi, media belajar, galeri',
        'settings.manage' => 'Mengubah pengaturan situs',
        'users.manage' => 'Mengelola pengguna',
        'audit.view' => 'Melihat log aktivitas',
    ],
];
