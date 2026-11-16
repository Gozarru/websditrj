<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/** Pengguna yang dinonaktifkan langsung dikeluarkan, termasuk bila sedang login. */
class EnsureUserActive
{
    public function handle(Request $request, Closure $next)
    {
        $u = $request->user();
        if ($u && ! $u->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors(['email' => 'Akun Anda dinonaktifkan. Hubungi Admin.']);
        }

        return $next($request);
    }
}
