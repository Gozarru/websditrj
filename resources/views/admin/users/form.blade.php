@extends('layouts.admin')
@section('title', $item->exists ? 'Ubah pengguna' : 'Tambah pengguna')
@section('content')
<h1>{{ $item->exists ? 'Ubah pengguna' : 'Tambah pengguna' }}</h1>
<form class="card" method="POST" action="{{ $item->exists ? route('admin.users.update', $item) : route('admin.users.store') }}">
    @csrf @if($item->exists) @method('PUT') @endif
    <div class="row2">
        <div><label for="name">Nama</label><input id="name" type="text" name="name" value="{{ old('name', $item->name) }}" required>@error('name')<div class="errs">{{ $message }}</div>@enderror</div>
        <div><label for="email">Email <small>(dipakai untuk masuk)</small></label><input id="email" type="email" name="email" value="{{ old('email', $item->email) }}" required autocomplete="off">@error('email')<div class="errs">{{ $message }}</div>@enderror</div>
    </div>

    <label>Peran</label>
    <div class="role-pick">
        @foreach(config('roles.roles') as $key => $r)
        <label><input type="radio" name="role" value="{{ $key }}" {{ old('role', $item->role) === $key ? 'checked' : '' }}><span><b>{{ $r['label'] }}</b><span>{{ $r['desc'] }}</span></span></label>
        @endforeach
    </div>
    @error('role')<div class="errs">{{ $message }}</div>@enderror

    <label for="password">Kata sandi {{ $item->exists ? 'baru' : '' }} <small>{{ $item->exists ? '(kosongkan jika tidak diganti)' : '(minimal 8 karakter)' }}</small></label>
    <input id="password" type="password" name="password" autocomplete="new-password" {{ $item->exists ? '' : 'required' }}>
    @error('password')<div class="errs">{{ $message }}</div>@enderror

    <input type="hidden" name="is_active" value="0">
    <label class="chk"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $item->is_active ? '1' : '0') ? 'checked' : '' }}> Akun aktif (bisa masuk)</label>

    <p><button class="btn" type="submit">Simpan</button> <a class="btn sec" href="{{ route('admin.users.index') }}">Batal</a></p>
</form>
@endsection
