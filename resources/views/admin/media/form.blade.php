@extends('layouts.admin')
@section('title', $item->exists ? 'Ubah media' : 'Tambah media')
@section('content')
<h1>{{ $item->exists ? 'Ubah media belajar' : 'Tambah media belajar' }}</h1>
<form class="card" method="POST" action="{{ $item->exists ? route('admin.media.update', $item) : route('admin.media.store') }}">
    @csrf @if($item->exists) @method('PUT') @endif
    <label for="title">Judul</label>
    <input id="title" type="text" name="title" value="{{ old('title', $item->title) }}" required>
    @error('title')<div class="errs">{{ $message }}</div>@enderror

    <div class="row2">
        <div>
            <label for="grade">Kelas</label>
            <select id="grade" name="grade">
                @foreach(config('site.grades') as $g)<option value="{{ $g }}" {{ old('grade', $item->grade) === $g ? 'selected' : '' }}>{{ $g }}</option>@endforeach
            </select>
            @error('grade')<div class="errs">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="type">Jenis</label>
            <select id="type" name="type">
                @foreach(config('site.media_types') as $t)<option value="{{ $t }}" {{ old('type', $item->type) === $t ? 'selected' : '' }}>{{ $t }}</option>@endforeach
            </select>
            @error('type')<div class="errs">{{ $message }}</div>@enderror
        </div>
    </div>

    <label for="url">Tautan materi <small>(YouTube, Google Drive, dan sebagainya)</small></label>
    <input id="url" type="url" name="url" value="{{ old('url', $item->url) }}" placeholder="https://" required>
    @error('url')<div class="errs">{{ $message }}</div>@enderror

    <label for="description">Keterangan <small>(opsional)</small></label>
    <textarea id="description" name="description" style="min-height:80px">{{ old('description', $item->description) }}</textarea>
    @error('description')<div class="errs">{{ $message }}</div>@enderror

    <p><button class="btn" type="submit">Simpan</button> <a class="btn sec" href="{{ route('admin.media.index') }}">Batal</a></p>
</form>
@endsection
