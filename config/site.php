<?php

// Halaman di menu "Profil Sekolah": slug => [judul, kalimat pengantar, isi bawaan].
// Isinya bisa diubah admin di Pengaturan situs > Halaman profil.
$profil = [
    'sejarah' => ['Sejarah Singkat', 'Informasi resmi SDIT Raudhatul Jannah Cilegon pada bagian sejarah singkat.',
        "SDIT Raudhatul Jannah Cilegon berawal dari ikhtiar keluarga besar yayasan untuk menghadirkan pendidikan dasar yang memadukan ilmu umum dengan nilai-nilai Islam.\nSekolah ini berdiri pada tahun 1997 di bawah naungan Yayasan Raudhatul Jannah Cilegon, beralamat di Pondok Cilegon Indah Blok D70, Cibeber, Cilegon."],
    'visi-misi' => ['Visi, Misi & Tujuan', 'Arah dan cita-cita pendidikan di SDIT Raudhatul Jannah Cilegon.',
        "Visi: Membangun generasi Qur’ani, berilmu, dan berakhlak mulia.\nMisi:\n- Menyelenggarakan pembelajaran yang memadukan kurikulum nasional dengan pembinaan Al-Qur’an.\n- Membiasakan adab dan ibadah dalam kegiatan sekolah sehari-hari.\n- Bekerja sama dengan orang tua dalam mendampingi tumbuh kembang anak."],
    'profil' => ['Profil Sekolah', 'Gambaran umum SDIT Raudhatul Jannah Cilegon.',
        "SDIT Raudhatul Jannah Cilegon adalah sekolah dasar Islam terpadu di bawah Yayasan Raudhatul Jannah Cilegon.\nKami memadukan kurikulum nasional dengan pembinaan Al-Qur’an, karakter, dan literasi digital."],
    'sambutan' => ['Sambutan Kepala Sekolah', 'Pesan dari kepala sekolah untuk orang tua dan peserta didik.',
        'Sambutan kepala sekolah sedang disiapkan oleh pengelola website.'],
    'struktur' => ['Struktur Organisasi', 'Susunan pengelola dan pelaksana kegiatan sekolah.',
        'Struktur organisasi sedang disiapkan oleh pengelola website.'],
    'guru' => ['Guru & Tenaga Kependidikan', 'Pendidik dan tenaga kependidikan yang mendampingi peserta didik.',
        'Data guru dan tenaga kependidikan sedang disiapkan oleh pengelola website.'],
    'sarana' => ['Sarana & Prasarana', 'Fasilitas yang mendukung kegiatan belajar dan ibadah.',
        'Informasi sarana dan prasarana sedang disiapkan oleh pengelola website.'],
    'pengembangan-diri' => ['Pengembangan Diri', 'Program pembiasaan dan pembinaan karakter peserta didik.',
        'Informasi program pengembangan diri sedang disiapkan oleh pengelola website.'],
    'ekstrakurikuler' => ['Ekstrakurikuler', 'Kegiatan pilihan untuk mengembangkan minat dan bakat.',
        'Daftar kegiatan ekstrakurikuler sedang disiapkan oleh pengelola website.'],
    'peta-lokasi' => ['Peta Lokasi', 'Lokasi sekolah dan cara menjangkaunya.',
        'SDIT Raudhatul Jannah Cilegon berlokasi di Pondok Cilegon Indah Blok D70, Cibeber, Cilegon, Banten.'],
];

$fields = [
    'school_name' => ['group' => 'Identitas', 'label' => 'Nama sekolah', 'type' => 'text', 'default' => 'SDIT Raudhatul Jannah Cilegon'],
    'foundation_name' => ['group' => 'Identitas', 'label' => 'Nama yayasan', 'type' => 'text', 'default' => 'Yayasan Raudhatul Jannah'],
    'logo' => ['group' => 'Identitas', 'label' => 'Logo sekolah (kosongkan untuk memakai lambang bawaan)', 'type' => 'image', 'default' => null],

    'topbar_text' => ['group' => 'Beranda', 'label' => 'Teks pengumuman di bilah atas', 'type' => 'text', 'default' => 'Pendaftaran murid baru tahun ajaran 2026/2027 — informasi lengkap di halaman SPMB'],
    'hero_eyebrow' => ['group' => 'Beranda', 'label' => 'Teks kecil di atas judul', 'type' => 'text', 'default' => 'Sekolah Dasar Islam Terpadu · Cilegon'],
    'hero_title' => ['group' => 'Beranda', 'label' => 'Judul utama (kata terakhir berwarna emas)', 'type' => 'text', 'default' => 'SDIT Raudhatul Jannah Cilegon'],
    'hero_text' => ['group' => 'Beranda', 'label' => 'Kalimat pengantar', 'type' => 'textarea', 'default' => 'Lembaga pendidikan dasar Islam terpadu yang memadukan kurikulum nasional dengan pembinaan Al-Qur’an, karakter, dan literasi digital.'],
    'hero_features' => ['group' => 'Beranda', 'label' => 'Tiga keunggulan di bawah tombol (satu per baris)', 'type' => 'textarea', 'default' => "Tahfizh Al-Qur’an\nPembinaan Adab\nGuru Pendamping"],
    'spmb_year' => ['group' => 'Beranda', 'label' => 'Tahun ajaran SPMB (lencana di foto)', 'type' => 'text', 'default' => '2026/2027'],
    'spmb_url' => ['group' => 'Beranda', 'label' => 'Tautan pendaftaran (SPMB)', 'type' => 'url', 'default' => 'https://spmb.raudhatuljannah.or.id'],
    'spmb_button' => ['group' => 'Beranda', 'label' => 'Teks tombol pendaftaran', 'type' => 'text', 'default' => 'Daftar Sekarang'],

    'about_text' => ['group' => 'Profil ringkas', 'label' => 'Profil sekolah, paragraf 1 (di beranda)', 'type' => 'textarea', 'default' => 'SDIT Raudhatul Jannah Cilegon berada di bawah Yayasan Raudhatul Jannah. Kami memadukan kurikulum nasional dengan pembiasaan ibadah, hafalan Al-Qur’an, dan pembentukan akhlak sehari-hari.'],
    'about_text2' => ['group' => 'Profil ringkas', 'label' => 'Profil sekolah, paragraf 2 (di beranda)', 'type' => 'textarea', 'default' => 'Guru dan orang tua bekerja sebagai satu tim, dan perkembangan setiap anak dikomunikasikan secara rutin.'],
    'values' => ['group' => 'Profil ringkas', 'label' => 'Nilai sekolah (satu per baris, format: Judul | Penjelasan)', 'type' => 'textarea', 'default' => "Qur’ani | Tahfidz dan tahsin menjadi bagian dari hari belajar.\nBerilmu | Pembelajaran aktif, aman, dan menyenangkan.\nBerakhlak mulia | Adab dibiasakan di kelas, masjid, dan rumah."],

    'address' => ['group' => 'Kontak', 'label' => 'Alamat', 'type' => 'textarea', 'default' => 'Pondok Cilegon Indah Blok D70, Cibeber, Cilegon, Banten 42415'],
    'phone' => ['group' => 'Kontak', 'label' => 'Telepon', 'type' => 'text', 'default' => '(0254) 399729'],
    'whatsapp' => ['group' => 'Kontak', 'label' => 'WhatsApp (contoh: 0812xxxxxxx)', 'type' => 'text', 'default' => null],
    'email' => ['group' => 'Kontak', 'label' => 'Email sekolah', 'type' => 'text', 'default' => null],
    'instagram' => ['group' => 'Kontak', 'label' => 'Tautan Instagram', 'type' => 'url', 'default' => null],
    'youtube' => ['group' => 'Kontak', 'label' => 'Tautan YouTube', 'type' => 'url', 'default' => null],
    'facebook' => ['group' => 'Kontak', 'label' => 'Tautan Facebook', 'type' => 'url', 'default' => null],
];

// Foto slider beranda (maksimal 4). Jika kosong, beranda memakai foto terbaru dari Galeri.
$slideCaptions = ['Lingkungan belajar yang menumbuhkan', 'Belajar dengan adab dan keceriaan', 'Tumbuh bersama Al-Qur’an', 'Berprestasi dan berakhlak mulia'];
foreach ($slideCaptions as $i => $cap) {
    $n = $i + 1;
    $fields["slide_{$n}_image"] = ['group' => 'Slider beranda', 'label' => "Foto slider $n", 'type' => 'image', 'default' => null];
    $fields["slide_{$n}_caption"] = ['group' => 'Slider beranda', 'label' => "Keterangan foto slider $n", 'type' => 'text', 'default' => $cap];
}

// Isi halaman profil (satu paragraf per baris; awali baris dengan "- " untuk poin).
foreach ($profil as $slug => [$title, , $default]) {
    $fields['profil_'.str_replace('-', '_', $slug)] = [
        'group' => 'Halaman profil',
        'label' => "$title (satu paragraf per baris; awali \"- \" untuk poin)",
        'type' => 'textarea',
        'default' => $default,
    ];
}

return [
    'admin' => [
        'name' => env('ADMIN_NAME', 'Admin Sekolah'),
        'email' => env('ADMIN_EMAIL'),
        'password' => env('ADMIN_PASSWORD'),
    ],

    'grades' => ['Kelas 1', 'Kelas 2', 'Kelas 3', 'Kelas 4', 'Kelas 5', 'Kelas 6', 'Umum'],
    'levels' => ['Sekolah', 'Kecamatan', 'Kota', 'Provinsi', 'Nasional', 'Internasional'],
    'media_types' => ['Video', 'Dokumen', 'Tautan'],

    'profil_pages' => $profil,
    'slide_captions' => $slideCaptions,

    // Pengaturan yang bisa diubah admin. 'default' dipakai sebelum admin menyimpan nilai.
    'fields' => $fields,
];
