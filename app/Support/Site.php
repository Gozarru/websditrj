<?php

namespace App\Support;

use App\Models\Setting;

class Site
{
    private static ?array $pairs = null;

    public static function get(string $key)
    {
        if (self::$pairs === null) {
            try {
                self::$pairs = Setting::pluck('value', 'name')->all();
            } catch (\Throwable $e) {
                self::$pairs = [];
            }
        }

        return array_key_exists($key, self::$pairs)
            ? self::$pairs[$key]
            : config("site.fields.$key.default");
    }

    public static function forget(): void
    {
        self::$pairs = null;
    }
}
