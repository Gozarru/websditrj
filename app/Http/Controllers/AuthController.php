<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [], ['email' => 'Email', 'password' => 'Kata sandi']);

        $credentials['is_active'] = true;

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $request->user()->forceFill(['last_login_at' => now()])->saveQuietly();
            ActivityLog::record('login', 'Masuk ke panel admin');

            return redirect()->intended(route('admin.dashboard'));
        }

        ActivityLog::record('login_failed', 'Percobaan masuk gagal untuk '.$request->input('email'), null, $request->input('email'));

        return back()->withErrors(['email' => 'Email atau kata sandi salah, atau akun dinonaktifkan.'])->onlyInput('email');
    }

    public function destroy(Request $request)
    {
        ActivityLog::record('logout', 'Keluar dari panel admin');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
