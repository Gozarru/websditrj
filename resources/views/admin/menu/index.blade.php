@extends('layouts.admin')
@section('title', 'Menu situs')
@section('content')
<div class="bar"><h1>Menu situs</h1><a class="btn" href="{{ route('admin.menu.create') }}">+ Menu</a></div>
<p class="muted" style="margin:-8px 0 16px">Menu di bagian atas website. Urutan di sini sama dengan urutan di website (kiri ke kanan). Menu yang punya submenu tampil sebagai dropdown.</p>

<div class="card">
<table class="resp">
    <thead><tr><th>Menu</th><th>Tujuan</th><th>Status</th><th></th></tr></thead>
    <tbody>
    @forelse($items as $top)
        @php $shownKids = $top->children->filter(fn ($c) => $c->is_visible && $c->href())->count(); @endphp
        @foreach(collect([$top])->concat($top->children) as $i)
        @php
            $isChild = (bool) $i->parent_id;
            $siblings = $isChild ? $top->children : $items;
            $note = null;
            if ($i->is_visible) {
                if ($isChild && ! $top->is_visible) $note = 'Tidak tampil: menu induknya disembunyikan';
                elseif ($i->link_type === 'page' && $i->page === 'spmb' && ! $i->href() && (! $isChild ? $shownKids === 0 : true)) $note = 'Tidak tampil: tautan SPMB di Pengaturan situs masih kosong';
                elseif (! $isChild && $shownKids === 0 && ! $i->href()) $note = 'Tidak tampil: belum ada submenu yang tampil';
                elseif ($isChild && ! $i->href()) $note = 'Tidak tampil: halaman tujuan tidak ditemukan';
            }
        @endphp
        <tr>
            <td data-label="Menu">
                <span class="tt" @if($isChild) style="display:inline-block;padding-left:26px" @endif>
                    @if($isChild)<span class="muted" aria-hidden="true">└ </span>@endif
                    @if($isChild){{ $i->label }}@else<b>{{ $i->label }}</b>@endif
                    @if(! $isChild && $top->children->count())<small class="muted"> · dropdown, {{ $top->children->count() }} submenu</small>@endif
                </span>
            </td>
            <td data-label="Tujuan">
                <span class="tt">
                @if(! $isChild && $top->children->count())
                    <span class="muted">Membuka dropdown</span>
                @elseif($i->href())
                    <a href="{{ $i->href() }}" target="_blank" rel="noopener" style="word-break:break-all">{{ $i->targetLabel() }}</a>@if($i->new_tab) <small class="muted">(tab baru)</small>@endif
                @else
                    <span class="muted">{{ $i->targetLabel() }}</span>
                @endif
                </span>
            </td>
            <td data-label="Status">
                <span class="tt">
                    <span class="badge {{ $i->is_visible ? 's-published' : 's-draft' }}">{{ $i->is_visible ? 'Tampil' : 'Disembunyikan' }}</span>
                    @if($note)<br><small class="muted">{{ $note }}</small>@endif
                </span>
            </td>
            <td class="act">
                <form method="POST" action="{{ route('admin.menu.move', [$i, 'up']) }}">@csrf<button class="btn sec sm" title="Geser ke atas" aria-label="Geser {{ $i->label }} ke atas" @disabled($siblings->first()->is($i))>↑</button></form>
                <form method="POST" action="{{ route('admin.menu.move', [$i, 'down']) }}">@csrf<button class="btn sec sm" title="Geser ke bawah" aria-label="Geser {{ $i->label }} ke bawah" @disabled($siblings->last()->is($i))>↓</button></form>
                <form method="POST" action="{{ route('admin.menu.toggle', $i) }}">@csrf<button class="btn sec sm">{{ $i->is_visible ? 'Sembunyikan' : 'Tampilkan' }}</button></form>
                @if(! $isChild)<a class="btn sec sm" href="{{ route('admin.menu.create', ['parent' => $i->id]) }}">+ Submenu</a>@endif
                <a class="btn sec sm" href="{{ route('admin.menu.edit', $i) }}">Ubah</a>
                <form method="POST" action="{{ route('admin.menu.destroy', $i) }}" data-confirm="{{ ! $isChild && $top->children->count() ? 'Hapus menu "'.$i->label.'" beserta '.$top->children->count().' submenunya?' : 'Hapus menu "'.$i->label.'"?' }}">@csrf @method('DELETE')<button class="btn del sm">Hapus</button></form>
            </td>
        </tr>
        @endforeach
    @empty
    <tr><td colspan="4" class="muted">Belum ada menu. Tekan “+ Menu” untuk menambah, atau kembalikan menu bawaan di bawah.</td></tr>
    @endforelse
    </tbody>
</table>
</div>

<div class="card">
    <h2>Catatan</h2>
    <p class="help" style="margin-bottom:12px">Tombol emas “{{ site('spmb_button') ?: 'Daftar Sekarang' }}” di ujung kanan diatur di <a href="{{ route('admin.settings.edit') }}">Pengaturan situs</a> bagian Beranda (teks tombol dan tautan pendaftaran). Jika tautan pendaftaran dikosongkan, tombol itu tidak ditampilkan.</p>
    <form method="POST" action="{{ route('admin.menu.reset') }}" data-confirm="Kembalikan menu ke susunan bawaan? Semua perubahan menu (tambahan, urutan, yang disembunyikan) akan hilang.">@csrf<button class="btn del sm">Kembalikan menu bawaan</button></form>
</div>
@endsection
