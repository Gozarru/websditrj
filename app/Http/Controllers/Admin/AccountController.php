<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function edit(Request $r)
    {
        return view('admin.account.edit', ['user' => $r->user()]);
    }

    public function update(Request $r)
    {
        $user = $r->user();
        $v = $r->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'current_password' => ['required_with:password', 'nullable', 'current_password'],
        ], [], ['name' => 'Nama', 'email' => 'Email', 'password' => 'Kata sandi baru', 'current_password' => 'Kata sandi saat ini']);

        $user->name = $v['name'];
        $user->email = $v['email'];
        if (! empty($v['password'])) {
            $user->password = $v['password'];
        }
        $user->save();

        return redirect()->route('admin.account.edit')->with('ok', 'Akun diperbarui.');
    }
}
