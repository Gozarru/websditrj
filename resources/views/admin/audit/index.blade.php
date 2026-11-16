@extends('layouts.admin')
@section('title', 'Log aktivitas')
@section('content')
<h1>Log aktivitas</h1>
<form class="card filters" method="GET" action="{{ route('admin.audit.index') }}">
    <div><label for="user">Pengguna</label><select id="user" name="user"><option value="">Semua</option>@foreach($users as $n)<option value="{{ $n }}" @selected(request('user') === $n)>{{ $n }}</option>@endforeach</select></div>
    <div><label for="action">Aksi</label><select id="action" name="action"><option value="">Semua</option>@foreach(\App\Models\ActivityLog::ACTIONS as $k => $v)<option value="{{ $k }}" @selected(request('action') === $k)>{{ $v }}</option>@endforeach</select></div>
    <div><label for="from">Dari</label><input id="from" type="date" name="from" value="{{ request('from') }}"></div>
    <div><label for="to">Sampai</label><input id="to" type="date" name="to" value="{{ request('to') }}"></div>
    <div><label for="q">Kata kunci</label><input id="q" type="search" name="q" value="{{ request('q') }}"></div>
    <button class="btn go" type="submit">Terapkan</button>
</form>
<div class="card">
<table class="resp">
    <thead><tr><th>Waktu</th><th>Pengguna</th><th>Aksi</th><th>Keterangan</th><th>IP</th></tr></thead>
    <tbody>
    @forelse($items as $l)
    <tr>
        <td data-label="Waktu" style="white-space:nowrap">{{ $l->created_at->translatedFormat('j M Y H:i') }}</td>
        <td data-label="Pengguna"><span class="tt">{{ $l->user_name }}@if($l->role)<br><span class="badge r-{{ $l->role }}">{{ config('roles.roles.'.$l->role.'.label', $l->role) }}</span>@endif</span></td>
        <td data-label="Aksi"><span class="badge a-{{ $l->action }}">{{ $l->actionLabel() }}</span></td>
        <td data-label="Keterangan"><span class="tt">{{ $l->description }}</span></td>
        <td data-label="IP" class="muted">{{ $l->ip ?? '—' }}</td>
    </tr>
    @empty
    <tr><td colspan="5" class="muted">Tidak ada aktivitas yang cocok.</td></tr>
    @endforelse
    </tbody>
</table>
<div class="pager"><span>@if($items->previousPageUrl())<a href="{{ $items->previousPageUrl() }}">← Lebih baru</a>@endif</span><span>@if($items->nextPageUrl())<a href="{{ $items->nextPageUrl() }}">Lebih lama →</a>@endif</span></div>
</div>
<p class="help">Log bersifat catatan saja: tidak bisa diubah atau dihapus dari panel ini.</p>
@endsection
