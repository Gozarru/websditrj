<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Closure;
use Illuminate\Http\Request;

/** Menghitung pengunjung unik per hari (tanpa menyimpan IP mentah). */
class TrackVisit
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        try {
            if ($this->shouldTrack($request, $response)) {
                $hash = sha1($request->ip().'|'.$request->userAgent().'|'.now()->toDateString().'|'.config('app.key'));
                $day = now()->toDateString();
                $updated = Visit::where('visited_on', $day)->where('visitor_hash', $hash)->increment('hits');
                if (! $updated) {
                    Visit::insertOrIgnore(['visited_on' => $day, 'visitor_hash' => $hash, 'hits' => 1]);
                }
            }
        } catch (\Throwable $e) {
            // Statistik tidak boleh mengganggu website (misalnya sebelum migrasi dijalankan).
        }

        return $response;
    }

    private function shouldTrack(Request $r, $response): bool
    {
        if (! $r->isMethod('GET') || $r->ajax() || ! $response->isSuccessful() || $r->user()) {
            return false;
        }
        if ($r->is('admin*', 'login', 'logout', 'up', 'storage/*', 'uploads/*')) {
            return false;
        }
        $ua = (string) $r->userAgent();

        return $ua !== '' && ! preg_match('/bot|crawl|spider|slurp|facebookexternalhit|preview|monitor|curl|wget|python|headless/i', $ua);
    }
}
