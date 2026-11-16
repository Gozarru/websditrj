@extends('layouts.admin')
@section('title', 'Pengguna')
@section('content')
<div class="bar"><h1>Pengguna</h1><a class="btn" href="{{ route('admin.users.create') }}">+ Pengguna</a></div>
<div class="card">
<table class="resp">
    <thead><tr><th>Nama</th><th>Peran</th><th>Status</th><th>Terakhir masuk</th><th></th></tr></thead>
    <tbody>
    @foreach($items as $i)
    <tr>
        <td data-label="Nama"><span class="tt"><b>{{ $i->name }}</b><br><small class="muted">{{ $i->email }}</small></span></td>
        <td data-label="Peran"><span class="badge r-{{ $i->role }}">{{ $i->roleLabel() }}</span></td>
        <td data-label="Status">@if($i->is_active)<span class="badge s-published">Aktif</span>@else<span class="badge s-draft">Nonaktif</span>@endif</td>
        <td data-label="Terakhir masuk">{{ $i->last_login_at?->diffForHumans() ?? 'Belum pernah' }}</td>
        <td class="act">
            <a class="btn sec sm" href="{{ route('admin.users.edit', $i) }}">Ubah</a>
            @if($i->id !== auth()->id())
            <form method="POST" action="{{ route('admin.users.destroy', $i) }}" data-confirm="Hapus pengguna {{ $i->name }}? Riwayat aktivitasnya tetap tersimpan.">@csrf @method('DELETE')<button class="btn del sm">Hapus</button></form>
            @endif
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
</div>

<div class="card">
    <h2>Hak akses tiap peran</h2>
    @php $roles = config('roles.roles'); @endphp
    <div class="tw"><table class="matrix">
        <thead><tr><th>Hak akses</th>@foreach($roles as $r)<th>{{ $r['label'] }}</th>@endforeach</tr></thead>
        <tbody>
        @foreach(config('roles.permissions') as $perm => $label)
        <tr><td>{{ $label }}</td>@foreach($roles as $r)<td>@if(in_array('*', $r['perms']) || in_array($perm, $r['perms']))<span class="yes" aria-label="Ya">✓</span>@else<span class="no" aria-label="Tidak">–</span>@endif</td>@endforeach</tr>
        @endforeach
        </tbody>
    </table></div>
    <p class="help">Alur tulisan: Editor menulis → Operator memeriksa → Kepala Sekolah menyetujui → Operator/Kepala Sekolah menerbitkan atau menjadwalkan. Admin dapat menjalankan semua tahap.</p>
</div>
@endsection
