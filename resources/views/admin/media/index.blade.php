@extends('layouts.admin')
@section('title', 'Media belajar')
@section('content')
<div class="bar"><h1>Media belajar</h1><a class="btn" href="{{ route('admin.media.create') }}">Tambah media</a></div>
<div class="card">
<table class="resp">
    <thead><tr><th>Kelas</th><th>Judul</th><th>Jenis</th><th></th></tr></thead><tbody>
    @forelse($items as $i)
    <tr>
        <td data-label="Kelas">{{ $i->grade }}</td><td data-label="Judul">{{ $i->title }}</td><td data-label="Jenis">{{ $i->type }}</td>
        <td class="act">
            <a class="btn sec sm" href="{{ route('admin.media.edit', $i) }}">Ubah</a>
            <form method="POST" action="{{ route('admin.media.destroy', $i) }}" data-confirm="Hapus media ini?">@csrf @method('DELETE')<button class="btn del sm">Hapus</button></form>
        </td>
    </tr>
    @empty
    <tr><td colspan="4" class="muted">Belum ada media belajar.</td></tr>
    @endforelse
    </tbody>
</table>
<div class="pager"><span>@if($items->previousPageUrl())<a href="{{ $items->previousPageUrl() }}">← Sebelumnya</a>@endif</span><span>@if($items->nextPageUrl())<a href="{{ $items->nextPageUrl() }}">Berikutnya</a>@endif</span></div>
</div>
@endsection
