@extends('layouts.admin')
@section('title', 'Prestasi')
@section('content')
<div class="bar"><h1>Prestasi</h1><a class="btn" href="{{ route('admin.achievements.create') }}">Tambah prestasi</a></div>
<div class="card">
<table class="resp">
    <thead><tr><th>Tahun</th><th>Prestasi</th><th>Tingkat</th><th></th></tr></thead><tbody>
    @forelse($items as $i)
    <tr>
        <td data-label="Tahun">{{ $i->year }}</td><td data-label="Prestasi">{{ $i->title }}</td><td data-label="Tingkat">{{ $i->level }}</td>
        <td class="act">
            <a class="btn sec sm" href="{{ route('admin.achievements.edit', $i) }}">Ubah</a>
            <form method="POST" action="{{ route('admin.achievements.destroy', $i) }}" data-confirm="Hapus prestasi ini?">@csrf @method('DELETE')<button class="btn del sm">Hapus</button></form>
        </td>
    </tr>
    @empty
    <tr><td colspan="4" class="muted">Belum ada prestasi.</td></tr>
    @endforelse
    </tbody>
</table>
<div class="pager"><span>@if($items->previousPageUrl())<a href="{{ $items->previousPageUrl() }}">← Sebelumnya</a>@endif</span><span>@if($items->nextPageUrl())<a href="{{ $items->nextPageUrl() }}">Berikutnya</a>@endif</span></div>
</div>
@endsection
