<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index', ['items' => User::orderBy('name')->get()]);
    }

    public function create()
    {
        return view('admin.users.form', ['item' => new User(['role' => 'editor', 'is_active' => true])]);
    }

    public function store(Request $r)
    {
        $v = $this->validated($r, null);
        User::create($v);

        return redirect()->route('admin.users.index')->with('ok', 'Pengguna ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.users.form', ['item' => $user]);
    }

    public function update(Request $r, User $user)
    {
        $v = $this->validated($r, $user);
        if ($err = $this->guardLastAdmin($user, $v['role'], $v['is_active'])) {
            return back()->withInput()->with('error', $err);
        }
        if (empty($v['password'])) {
            unset($v['password']);
        }
        $user->update($v);

        return redirect()->route('admin.users.index')->with('ok', 'Pengguna diperbarui.');
    }

    public function destroy(Request $r, User $user)
    {
        if ($user->id === $r->user()->id) {
            return back()->with('error', 'Anda tidak bisa menghapus akun yang sedang dipakai.');
        }
        if ($err = $this->guardLastAdmin($user, 'none', false)) {
            return back()->with('error', $err);
        }
        $user->delete();

        return redirect()->route('admin.users.index')->with('ok', 'Pengguna dihapus. Riwayat aktivitasnya tetap tersimpan.');
    }

    /** Pastikan selalu ada minimal satu Admin aktif. */
    private function guardLastAdmin(User $user, string $newRole, bool $newActive): ?string
    {
        if ($user->role === 'admin' && ($newRole !== 'admin' || ! $newActive)) {
            $others = User::where('role', 'admin')->where('is_active', true)->where('id', '!=', $user->id)->count();
            if ($others === 0) {
                return 'Harus ada minimal satu Admin aktif. Jadikan pengguna lain Admin terlebih dahulu.';
            }
        }

        return null;
    }

    private function validated(Request $r, ?User $user): array
    {
        $v = $r->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($user?->id)],
            'role' => ['required', Rule::in(array_keys(config('roles.roles')))],
            'password' => [$user ? 'nullable' : 'required', 'string', 'min:8'],
        ], [], ['name' => 'Nama', 'email' => 'Email', 'role' => 'Peran', 'password' => 'Kata sandi']);
        $v['is_active'] = $r->boolean('is_active');

        return $v;
    }
}
