<?php

use App\Support\Site;

if (! function_exists('site')) {
    function site(string $key)
    {
        return Site::get($key);
    }
}

if (! function_exists('upload_url')) {
    function upload_url(?string $path): ?string
    {
        return $path ? asset('uploads/'.ltrim($path, '/')) : null;
    }
}

if (! function_exists('site_values')) {
    /** Baris "Judul | Penjelasan" menjadi array [judul, penjelasan]. */
    function site_values(): array
    {
        $out = [];
        foreach (preg_split('/\R/', (string) site('values')) as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }
            [$title, $desc] = array_pad(array_map('trim', explode('|', $line, 2)), 2, '');
            $out[] = ['title' => $title, 'desc' => $desc];
        }

        return $out;
    }
}

if (! function_exists('wa_link')) {
    function wa_link(?string $number): ?string
    {
        $d = preg_replace('/\D+/', '', (string) $number);
        if ($d === '') {
            return null;
        }
        if (str_starts_with($d, '0')) {
            $d = '62'.substr($d, 1);
        }

        return 'https://wa.me/'.$d;
    }
}

if (! function_exists('grade_slug')) {
    function grade_slug(string $grade): string
    {
        return \Illuminate\Support\Str::slug($grade);
    }
}

if (! function_exists('rich_text')) {
    /** Teks admin → HTML aman: satu baris = satu paragraf, baris berawalan "- " = poin. */
    function rich_text(?string $text): string
    {
        $out = '';
        $items = [];
        $flush = function () use (&$out, &$items) {
            if ($items) {
                $out .= '<ul>'.implode('', $items).'</ul>';
                $items = [];
            }
        };
        foreach (preg_split('/\R/', trim((string) $text)) as $line) {
            $line = trim($line);
            if (str_starts_with($line, '- ')) {
                $items[] = '<li>'.e(trim(substr($line, 2))).'</li>';
                continue;
            }
            $flush();
            if ($line !== '') {
                $out .= '<p>'.e($line).'</p>';
            }
        }
        $flush();

        return $out;
    }
}

if (! function_exists('site_lines')) {
    /** Teks beberapa baris → array baris tak kosong. */
    function site_lines(string $key): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\R/', (string) site($key)))));
    }
}

if (! function_exists('site_menu')) {
    /** Menu utama website. Susunannya diatur admin di Admin → Menu situs (tabel menu_items). */
    function site_menu(): array
    {
        return \App\Support\SiteMenu::build();
    }
}
