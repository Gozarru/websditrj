@extends('layouts.admin')
@section('title', 'Berita & Pengumuman')
@section('content')
@php $me = auth()->user(); @endphp
<div class="bar">
    <h1>Berita &amp; Pengumuman</h1>
    @if($me->can('posts.write'))
    <div style="display:flex;gap:8px;flex-wrap:wrap">
        <a class="btn" href="{{ route('admin.posts.create') }}">+ Berita</a>
        <a class="btn sec" href="{{ route('admin.posts.create', ['type' => 'pengumuman']) }}">+ Pengumuman</a>
    </div>
    @endif
</div>

<div class="tabs" role="navigation" aria-label="Filter status">
    <a href="{{ route('admin.posts.index', request()->except('status', 'page')) }}" class="{{ request('status') ? '' : 'on' }}">Semua<small>{{ $total }}</small></a>
    @foreach(\App\Models\Post::STATUSES as $k => $label)
        <a href="{{ route('admin.posts.index', ['status' => $k] + request()->except('status', 'page')) }}" class="{{ request('status') === $k ? 'on' : '' }}">{{ $label }}<small>{{ $counts[$k] ?? 0 }}</small></a>
    @endforeach
</div>

<form class="filters" method="GET" action="{{ route('admin.posts.index') }}">
    @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
    <div><label for="q">Cari judul</label><input id="q" type="search" name="q" value="{{ request('q') }}" placeholder="Ketik judul…"></div>
    <div><label for="type">Jenis</label>
        <select id="type" name="type"><option value="">Semua jenis</option>@foreach(\App\Models\Post::TYPES as $k => $v)<option value="{{ $k }}" @selected(request('type') === $k)>{{ $v }}</option>@endforeach</select>
    </div>
    <button class="btn sec go" type="submit">Terapkan</button>
</form>

<div class="card">
<table class="resp">
    <thead><tr><th></th><th>Judul</th><th>Penulis</th><th>Status</th><th>Diperbarui</th><th></th></tr></thead>
    <tbody>
    @forelse($items as $i)
    <tr>
        <td>@if($i->image)<img class="thumb" src="{{ upload_url($i->image) }}" alt="">@endif</td>
        <td data-label="Judul"><span class="tt"><a href="{{ route('admin.posts.show', $i) }}"><b>{{ $i->title }}</b></a><br><small class="muted">{{ $i->typeLabel() }}@if($i->status === 'scheduled' && $i->published_at) · tayang {{ $i->published_at->translatedFormat('j M Y H:i') }}@endif</small></span></td>
        <td data-label="Penulis">{{ $i->author?->name ?? '—' }}</td>
        <td data-label="Status"><span class="badge s-{{ $i->status }}">{{ $i->statusLabel() }}</span></td>
        <td data-label="Diperbarui">{{ $i->updated_at->translatedFormat('j M Y') }}</td>
        <td class="act">
            <a class="btn sec sm" href="{{ route('admin.posts.show', $i) }}">Buka</a>
            @if(\App\Support\PostWorkflow::canEdit($i, $me))<a class="btn sec sm" href="{{ route('admin.posts.edit', $i) }}">Ubah</a>@endif
            @if(\App\Support\PostWorkflow::canDelete($i, $me))
            <form method="POST" action="{{ route('admin.posts.destroy', $i) }}" data-confirm="Hapus tulisan ini?">@csrf @method('DELETE')<button class="btn del sm">Hapus</button></form>
            @endif
        </td>
    </tr>
    @empty
    <tr><td colspan="6" class="muted">Belum ada tulisan.</td></tr>
    @endforelse
    </tbody>
</table>
<div class="pager"><span>@if($items->previousPageUrl())<a href="{{ $items->previousPageUrl() }}">← Sebelumnya</a>@endif</span><span>@if($items->nextPageUrl())<a href="{{ $items->nextPageUrl() }}">Berikutnya →</a>@endif</span></div>
</div>
@endsection
