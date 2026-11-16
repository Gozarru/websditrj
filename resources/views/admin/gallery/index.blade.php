@extends('layouts.admin')
@section('title', 'Galeri')
@section('content')
<h1>Galeri</h1>
<form class="card" method="POST" enctype="multipart/form-data" action="{{ route('admin.gallery.store') }}">
    @csrf
    <b>Tambah foto</b>
    <label for="photos">Pilih foto <small>(bisa banyak sekaligus, maks 20 foto, 5 MB per foto)</small></label>
    <input id="photos" type="file" name="photos[]" accept="image/jpeg,image/png,image/webp" multiple required>
    @error('photos')<div class="errs">{{ $message }}</div>@enderror
    @error('photos.*')<div class="errs">{{ $message }}</div>@enderror
    <label for="caption">Keterangan <small>(opsional, dipakai untuk semua foto yang dipilih)</small></label>
    <input id="caption" type="text" name="caption" value="{{ old('caption') }}">
    <p><button class="btn" type="submit">Unggah</button></p>
</form>

<div class="gal">
    @forelse($items as $i)
    <div class="it">
        <img src="{{ upload_url($i->image) }}" alt="{{ $i->caption }}" loading="lazy">
        <form method="POST" action="{{ route('admin.gallery.update', $i) }}">@csrf @method('PUT')
            <input type="text" name="caption" value="{{ $i->caption }}" placeholder="Keterangan" aria-label="Keterangan foto">
            <button class="btn sec sm">Simpan</button>
        </form>
        <form method="POST" action="{{ route('admin.gallery.destroy', $i) }}" data-confirm="Hapus foto ini?">@csrf @method('DELETE')<button class="btn del sm">Hapus foto</button></form>
    </div>
    @empty
    <p class="muted">Belum ada foto.</p>
    @endforelse
</div>
<div class="pager"><span>@if($items->previousPageUrl())<a href="{{ $items->previousPageUrl() }}">Sebelumnya</a>@endif</span><span>@if($items->nextPageUrl())<a href="{{ $items->nextPageUrl() }}">Berikutnya</a>@endif</span></div>
@endsection
