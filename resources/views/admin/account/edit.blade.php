@extends('layouts.admin')
@section('title', 'Akun saya')
@section('content')
<h1>Akun saya</h1>
<p class="muted" style="margin-top:-8px">Peran: <span class="badge r-{{ $user->role }}">{{ $user->roleLabel() }}</span></p>
<form class="card" method="POST" action="{{ route('admin.account.update') }}">
    @csrf @method('PUT')
    <label for="name">Nama</label>
    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required>
    @error('name')<div class="errs">{{ $message }}</div>@enderror

    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required>
    @error('email')<div class="errs">{{ $message }}</div>@enderror

    <b style="display:block;margin-top:22px">Ganti kata sandi <small class="muted">(kosongkan jika tidak diganti)</small></b>
    <label for="current_password">Kata sandi saat ini</label>
    <input id="current_password" type="password" name="current_password" autocomplete="current-password">
    @error('current_password')<div class="errs">{{ $message }}</div>@enderror

    <label for="password">Kata sandi baru <small>(minimal 8 karakter)</small></label>
    <input id="password" type="password" name="password" autocomplete="new-password">
    @error('password')<div class="errs">{{ $message }}</div>@enderror

    <label for="password_confirmation">Ulangi kata sandi baru</label>
    <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password">

    <p><button class="btn" type="submit">Simpan</button></p>
</form>
@endsection
