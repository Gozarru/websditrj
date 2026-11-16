@extends('layouts.admin')
@section('title', 'Agenda')
@section('content')
<div class="bar"><h1>Agenda</h1><a class="btn" href="{{ route('admin.agendas.create') }}">+ Agenda</a></div>
<div class="card">
<table class="resp">
    <thead><tr><th>Tanggal</th><th>Agenda</th><th>Tempat</th><th></th></tr></thead>
    <tbody>
    @forelse($items as $i)
    <tr>
        <td data-label="Tanggal">{{ $i->dateLabel() }}</td>
        <td data-label="Agenda"><span class="tt"><b>{{ $i->title }}</b>@if($i->time_text)<br><small class="muted">{{ $i->time_text }}</small>@endif</span></td>
        <td data-label="Tempat">{{ $i->location ?: '—' }}</td>
        <td class="act">
            <a class="btn sec sm" href="{{ route('admin.agendas.edit', $i) }}">Ubah</a>
            <form method="POST" action="{{ route('admin.agendas.destroy', $i) }}" data-confirm="Hapus agenda ini?">@csrf @method('DELETE')<button class="btn del sm">Hapus</button></form>
        </td>
    </tr>
    @empty
    <tr><td colspan="4" class="muted">Belum ada agenda.</td></tr>
    @endforelse
    </tbody>
</table>
<div class="pager"><span>@if($items->previousPageUrl())<a href="{{ $items->previousPageUrl() }}">← Sebelumnya</a>@endif</span><span>@if($items->nextPageUrl())<a href="{{ $items->nextPageUrl() }}">Berikutnya →</a>@endif</span></div>
</div>
@endsection
