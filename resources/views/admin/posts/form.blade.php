@extends('layouts.admin')
@section('title', $item->exists ? 'Ubah tulisan' : 'Tulisan baru')
@section('content')
<div class="bar"><h1>{{ $item->exists ? 'Ubah tulisan' : 'Tulisan baru' }}</h1>@if($item->exists)<a class="btn sec" href="{{ route('admin.posts.show', $item) }}">← Kembali</a>@endif</div>
<div class="{{ $item->exists ? 'grid2' : '' }}">
<form class="card" method="POST" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.posts.update', $item) : route('admin.posts.store') }}">
    @csrf @if($item->exists) @method('PUT') @endif

    <label>Jenis</label>
    <div class="type-pick">
        @foreach(\App\Models\Post::TYPES as $k => $v)
            <label><input type="radio" name="type" value="{{ $k }}" {{ old('type', $item->type) === $k ? 'checked' : '' }}> {{ $v }}</label>
        @endforeach
    </div>
    @error('type')<div class="errs">{{ $message }}</div>@enderror

    <label for="title">Judul</label>
    <input id="title" type="text" name="title" value="{{ old('title', $item->title) }}" required>
    @error('title')<div class="errs">{{ $message }}</div>@enderror

    <label for="excerpt">Ringkasan <small>(opsional, tampil di daftar)</small></label>
    <textarea id="excerpt" name="excerpt" style="min-height:70px">{{ old('excerpt', $item->excerpt) }}</textarea>
    @error('excerpt')<div class="errs">{{ $message }}</div>@enderror

    <label for="body">Isi</label>
    <textarea id="body" name="body" style="min-height:240px" required>{{ old('body', $item->body) }}</textarea>
    @error('body')<div class="errs">{{ $message }}</div>@enderror

    <div class="row2">
        <div>
            <label for="published_at">Jadwal tayang <small>(opsional)</small></label>
            <input id="published_at" type="datetime-local" name="published_at" value="{{ old('published_at', $item->published_at?->format('Y-m-d\TH:i')) }}">
            <p class="help">Jika diisi tanggal &amp; jam mendatang, tulisan tayang otomatis pada waktu itu setelah disetujui dan diterbitkan.</p>
            @error('published_at')<div class="errs">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="image">Foto <small>(JPG, PNG, WEBP, maks 5 MB)</small></label>
            <input id="image" type="file" name="image" accept="image/jpeg,image/png,image/webp">
            @error('image')<div class="errs">{{ $message }}</div>@enderror
        </div>
    </div>
    @if($item->image)
        <img class="prev" src="{{ upload_url($item->image) }}" alt="">
        <label class="chk"><input type="checkbox" name="remove_image" value="1"> Hapus foto ini</label>
    @endif

    @if($item->exists && in_array($item->status, ['checked', 'approved']))
        <div class="note" style="margin-top:16px">Tulisan ini sudah {{ $item->status === 'approved' ? 'disetujui' : 'diperiksa' }}. Jika isinya diubah, tulisan kembali ke tahap pemeriksaan.</div>
    @endif

    <p style="display:flex;gap:8px;flex-wrap:wrap;margin-top:18px">
        <button class="btn" type="submit" data-multi>Simpan</button>
        @if(! $item->exists || $item->status === 'draft')
            <button class="btn gold" type="submit" name="submit_after" value="1">Simpan &amp; ajukan untuk diperiksa</button>
        @endif
        <a class="btn sec" href="{{ $item->exists ? route('admin.posts.show', $item) : route('admin.posts.index') }}">Batal</a>
    </p>
</form>
@if($item->exists)<div>@include('admin.posts._panel')</div>@endif
</div>
@endsection
