<?php

namespace App\Support;

use App\Models\MenuItem;
use Illuminate\Support\Facades\DB;

/** Menu utama website: daftar halaman yang bisa ditautkan, menu bawaan, dan penyusunan menu untuk tampilan. */
class SiteMenu
{
    /** Halaman situs yang bisa dipilih admin sebagai tujuan menu: kelompok => [kunci => nama]. */
    public static function pageGroups(): array
    {
        $profil = [];
        foreach (config('site.profil_pages') as $slug => $p) {
            $profil["profil:$slug"] = $p[0];
        }
        $media = ['media' => 'Media Belajar (halaman utama)'];
        foreach (config('site.grades') as $g) {
            $media['media:'.grade_slug($g)] = "Media Belajar $g";
        }

        return [
            'Umum' => [
                'home' => 'Beranda',
                'kontak' => 'Kontak',
                'spmb' => 'Pendaftaran SPMB (tautan dari Pengaturan situs)',
            ],
            'Profil Sekolah' => $profil,
            'Informasi' => [
                'berita' => 'Berita Sekolah',
                'pengumuman' => 'Pengumuman',
                'agenda' => 'Agenda',
                'prestasi' => 'Prestasi Siswa',
            ],
            'Media Belajar' => $media,
            'Galeri' => ['galeri' => 'Galeri Foto'],
        ];
    }

    /** Semua halaman dalam satu daftar: kunci => nama. */
    public static function pages(): array
    {
        $out = [];
        foreach (self::pageGroups() as $pages) {
            $out += $pages;
        }

        return $out;
    }

    /** Alamat sebuah halaman situs; null bila halamannya tidak ada (atau tautan SPMB belum diisi). */
    public static function pageUrl(?string $key): ?string
    {
        if (! $key) {
            return null;
        }
        [$name, $arg] = array_pad(explode(':', $key, 2), 2, null);

        switch ($name) {
            case 'home':
                return route('home');
            case 'kontak':
                return route('kontak');
            case 'spmb':
                return site('spmb_url') ?: null;
            case 'profil':
                return $arg !== null && array_key_exists($arg, config('site.profil_pages')) ? route('profil', $arg) : null;
            case 'berita':
                return route('posts.index');
            case 'pengumuman':
                return route('pengumuman');
            case 'agenda':
                return route('agenda');
            case 'prestasi':
                return route('prestasi');
            case 'media':
                return $arg !== null ? route('media', $arg) : route('media');
            case 'galeri':
                return route('galeri');
        }

        return null;
    }

    /** Menu bawaan (dipakai saat pertama dipasang dan saat admin menekan "Kembalikan menu bawaan"). */
    public static function defaults(): array
    {
        $page = fn (string $label, string $key) => self::node($label, 'page', $key);

        $profil = [];
        foreach (config('site.profil_pages') as $slug => $p) {
            $profil[] = $page($p[0], "profil:$slug");
        }
        $media = [];
        foreach (config('site.grades') as $g) {
            $media[] = $page($g, 'media:'.grade_slug($g));
        }

        return [
            $page('Beranda', 'home'),
            self::node('Profil Sekolah', 'none', null, $profil),
            self::node('Informasi', 'none', null, [
                $page('Berita Sekolah', 'berita'),
                $page('Pengumuman', 'pengumuman'),
                $page('Agenda', 'agenda'),
                $page('Prestasi Siswa', 'prestasi'),
            ]),
            self::node('Media Belajar', 'none', null, $media),
            $page('SPMB', 'spmb'),
            self::node('Galeri', 'none', null, [
                $page('Galeri Foto', 'galeri'),
                $page('Kegiatan Sekolah', 'berita'),
                $page('Dokumentasi Prestasi', 'prestasi'),
            ]),
            $page('Kontak', 'kontak'),
        ];
    }

    /** Mengisi tabel menu_items dengan menu bawaan (tabel harus kosong). */
    public static function seedDefaults(): void
    {
        $now = now();
        $row = fn (array $n, ?int $parent, int $pos) => [
            'parent_id' => $parent,
            'label' => $n['label'],
            'link_type' => $n['link_type'],
            'page' => $n['page'],
            'url' => null,
            'new_tab' => false,
            'is_visible' => true,
            'position' => $pos,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        foreach (self::defaults() as $i => $n) {
            $id = (int) DB::table('menu_items')->insertGetId($row($n, null, $i + 1));
            foreach ($n['children'] as $j => $c) {
                DB::table('menu_items')->insert($row($c, $id, $j + 1));
            }
        }
    }

    /**
     * Menu untuk tampilan website: [label, url, external, active] atau [label, active, children => [...]].
     * Menu yang disembunyikan, dropdown tanpa isi, dan tautan yang tujuannya kosong tidak ikut.
     */
    public static function build(): array
    {
        $menu = [];
        foreach (self::tree() as $n) {
            if (! $n['is_visible']) {
                continue;
            }
            $children = [];
            foreach ($n['children'] as $c) {
                $link = $c['is_visible'] ? self::link($c) : null;
                if ($link) {
                    $children[] = ['label' => $c['label']] + $link;
                }
            }
            if ($children) {
                $menu[] = ['label' => $n['label'], 'active' => false, 'children' => $children];
            } elseif ($link = self::link($n)) {
                $menu[] = ['label' => $n['label'], 'active' => false] + $link;
            }
        }

        $active = self::activeIndex($menu);
        if ($active !== null) {
            $menu[$active]['active'] = true;
        }

        return $menu;
    }

    /** Tautan sebuah butir menu: [url, external] atau null bila tidak punya tujuan. */
    public static function link(array $n): ?array
    {
        if ($n['link_type'] === 'page') {
            $url = self::pageUrl($n['page']);

            return $url ? ['url' => $url, 'external' => $n['new_tab'] || $n['page'] === 'spmb'] : null;
        }
        if ($n['link_type'] === 'url' && trim((string) $n['url']) !== '') {
            $url = trim($n['url']);

            return ['url' => str_starts_with($url, '/') ? url($url) : $url, 'external' => (bool) $n['new_tab']];
        }

        return null;
    }

    /** Susunan menu dari basis data; memakai menu bawaan bila tabel belum ada (migrasi belum dijalankan). */
    private static function tree(): array
    {
        try {
            $rows = MenuItem::orderBy('position')->orderBy('id')->get();
        } catch (\Throwable $e) {
            return self::defaults();
        }

        $byParent = $rows->groupBy(fn ($r) => (int) $r->parent_id);
        $toNode = fn (MenuItem $r, array $children = []) => [
            'label' => $r->label,
            'link_type' => $r->link_type,
            'page' => $r->page,
            'url' => $r->url,
            'new_tab' => (bool) $r->new_tab,
            'is_visible' => (bool) $r->is_visible,
            'children' => $children,
        ];

        $out = [];
        foreach ($byParent->get(0, []) as $r) {
            $children = [];
            foreach ($byParent->get($r->id, []) as $c) {
                $children[] = $toNode($c);
            }
            $out[] = $toNode($r, $children);
        }

        return $out;
    }

    private static function node(string $label, string $type, ?string $page, array $children = []): array
    {
        return [
            'label' => $label, 'link_type' => $type, 'page' => $page, 'url' => null,
            'new_tab' => false, 'is_visible' => true, 'children' => $children,
        ];
    }

    /** Menu mana yang sedang dibuka pengunjung (hanya satu yang ditandai). */
    private static function activeIndex(array $menu): ?int
    {
        $root = rtrim(url('/'), '/');
        $cur = self::rel(request()->url(), $root);
        if ($cur === null) {
            return null;
        }

        // Alamat (relatif terhadap situs) yang dimiliki tiap menu utama.
        $paths = [];
        foreach ($menu as $i => $m) {
            $urls = isset($m['children']) ? array_column($m['children'], 'url') : [$m['url']];
            $paths[$i] = array_values(array_filter(
                array_map(fn ($u) => self::rel($u, $root), $urls),
                fn ($p) => $p !== null
            ));
        }

        // 1) Alamat sama persis, atau halaman di bawahnya (mis. detail berita di bawah Berita Sekolah).
        foreach ($paths as $i => $list) {
            foreach ($list as $p) {
                if ($p === $cur || ($p !== '' && str_starts_with($cur, $p.'/'))) {
                    return $i;
                }
            }
        }

        // 2) Satu bagian yang sama (mis. /media-belajar tanpa kelas tetap menandai Media Belajar).
        $section = explode('/', $cur)[0];
        if ($section !== '') {
            foreach ($paths as $i => $list) {
                foreach ($list as $p) {
                    if (explode('/', $p)[0] === $section) {
                        return $i;
                    }
                }
            }
        }

        return null;
    }

    /** Bagian alamat setelah alamat situs, tanpa garis miring di tepi; null bila alamatnya di luar situs. */
    private static function rel(string $url, string $root): ?string
    {
        $url = preg_replace('/[?#].*$/', '', $url);
        if ($url !== $root && ! str_starts_with($url, $root.'/')) {
            return null;
        }

        return trim(substr($url, strlen($root)), '/');
    }
}
