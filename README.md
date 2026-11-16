# Website SDIT Raudhatul Jannah Cilegon

Website sekolah (Laravel 12) dengan panel admin. Admin bisa mengelola berita, prestasi,
media belajar, galeri foto, serta teks, logo, dan kontak sekolah tanpa mengubah kode.

## Kebutuhan
- PHP 8.2 atau lebih baru (ekstensi: mbstring, openssl, pdo_sqlite atau pdo_mysql, fileinfo, gd)
- Composer

## Pasang di komputer / server dengan terminal
```bash
composer install --no-dev --optimize-autoloader
cp .env.example .env
# edit .env: APP_URL, dan ADMIN_EMAIL + ADMIN_PASSWORD (wajib diisi)
php artisan key:generate
php artisan migrate --force
php artisan db:seed          # membuat akun admin dari .env
php artisan serve            # coba di http://127.0.0.1:8000
```
Setelah seed, hapus ADMIN_PASSWORD dari `.env` bila mau, lalu ganti kata sandi di menu **Akun saya**.

Login admin: `/login` (tautan "Masuk admin" ada di footer).
Lupa kata sandi: `php artisan admin:reset email@sekolah.sch.id KataSandiBaru123`

## Pakai MySQL (opsional)
Di `.env` ganti `DB_CONNECTION=mysql` dan isi DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD,
lalu jalankan `php artisan migrate --force` dan `php artisan db:seed`.

## Hosting cPanel (folder public terpisah)
1. Unggah semua folder proyek ke satu folder di luar web root, misalnya `/home/akun/portal`.
2. Isi folder `public/` dipindah ke `public_html` (atau folder domain).
3. Di `public_html/index.php` ubah path dan beri tahu Laravel lokasi folder public:
```php
require __DIR__.'/../portal/vendor/autoload.php';
$app = require_once __DIR__.'/../portal/bootstrap/app.php';
$app->usePublicPath(__DIR__);
$app->handleRequest(Request::capture());
```
4. Pastikan folder `storage`, `bootstrap/cache`, dan `public_html/uploads` bisa ditulis (permission 775).

## Foto unggahan
Foto disimpan di `public/uploads` (tanpa symlink). Format JPG, PNG, WEBP, maksimal 5 MB per foto.
Atur `upload_max_filesize` minimal 6M dan `post_max_size` minimal 30M di PHP bila ingin unggah banyak foto sekaligus.

## Struktur singkat
- `config/site.php`: daftar pengaturan situs dan teks bawaan
- `app/Http/Controllers/Admin`: pengelolaan konten
- `resources/views`: tampilan publik (`home`, `posts`) dan admin (`admin/*`)
- `public/css/site.css`, `public/css/admin.css`: gaya tampilan

## Tampilan beranda (mengikuti portal referensi)
- Foto slider beranda: **Pengaturan situs > Slider beranda** (maksimal 4 foto + keterangan). Jika kosong, dipakai foto terbaru dari Galeri.
- Isi halaman **Profil Sekolah** (sejarah, visi misi, dst.): **Pengaturan situs > Halaman profil**. Satu baris = satu paragraf, awali baris dengan `- ` untuk poin.
- Alamat baru: `/profil/{halaman}`, `/informasi/berita`, `/informasi/prestasi`, `/media-belajar/{kelas}`, `/galeri/foto`, `/kontak`. Alamat lama `/berita` otomatis dialihkan.
- Gaya: `public/css/site.css`; animasi dan slider: `public/js/site.js`.

## Panel admin multi-pengguna
Jalankan sekali setelah memperbarui kode: `php artisan migrate` (akun admin yang sudah ada otomatis menjadi **Admin**; berita lama tetap tayang).

**Peran** (atur di Admin → Pengguna; hak akses di `config/roles.php`):
- **Admin**: semua fitur, termasuk pengguna, pengaturan, dan log aktivitas.
- **Kepala Sekolah**: menyetujui dan menerbitkan, melihat dasbor dan log aktivitas.
- **Operator**: memeriksa tulisan, menerbitkan, mengelola agenda, prestasi, media belajar, galeri, dan pengaturan situs.
- **Editor**: menulis berita/pengumuman dan mengajukannya.

**Alur publikasi**: Editor membuat (Draf) → mengajukan → Operator memeriksa → Kepala Sekolah menyetujui → Operator/Kepala Sekolah menerbitkan atau menjadwalkan. Pemeriksa/penyetuju tidak bisa menilai tulisannya sendiri (kecuali Admin). Tulisan bisa dikembalikan ke penulis dengan catatan.

**Penjadwalan**: isi tanggal dan jam saat menerbitkan. Tulisan tampil di website tepat pada waktunya. Agar statusnya otomatis berubah menjadi "Tayang" di admin, aktifkan scheduler Laravel (di hosting: cron setiap menit):
`* * * * * cd /path/ke/project && php artisan schedule:run >> /dev/null 2>&1`
(untuk uji manual: `php artisan posts:publish-due`).

**Log aktivitas**: semua login, perubahan data, dan langkah alur publikasi tercatat (Admin → Log aktivitas; hanya Admin dan Kepala Sekolah).
**Statistik pengunjung**: dihitung unik per hari tanpa menyimpan IP mentah; bot diabaikan; mulai tercatat setelah migrasi.

## Menu situs (bisa diatur dari admin)
Jalankan sekali setelah memperbarui kode: `php artisan migrate` (menu yang sekarang tampil otomatis menjadi isi awal, jadi tampilan website tidak berubah).

Buka **Admin → Menu situs** (Admin dan Operator, hak akses `settings.manage`):
- **Tambah**: tombol **+ Menu** untuk menu utama, atau **+ Submenu** di baris sebuah menu untuk mengisi dropdown-nya.
- **Tujuan**: pilih halaman situs dari daftar, isi alamat lain (`https://...` atau `/alamat-di-situs`), atau "tanpa tautan" untuk judul dropdown.
- **Sembunyikan / Tampilkan**: menu hilang dari website tetapi datanya tetap ada.
- **Hapus**: menghapus menu beserta submenunya.
- **↑ ↓**: mengatur urutan. **Kembalikan menu bawaan** mengembalikan susunan awal.

Menu utama yang punya submenu tampil sebagai dropdown; dropdown tanpa submenu yang tampil otomatis tidak ditampilkan.
Tombol emas "Daftar Sekarang" tetap diatur di **Pengaturan situs → Beranda** (teks dan tautan pendaftaran; kosongkan tautan untuk menyembunyikannya).
