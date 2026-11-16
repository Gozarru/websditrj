@extends('layouts.admin')
@section('title', $item->exists ? 'Ubah prestasi' : 'Tambah prestasi')
@section('content')
<h1>{{ $item->exists ? 'Ubah prestasi' : 'Tambah prestasi' }}</h1>
<form class="card" method="POST" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.achievements.update', $item) : route('admin.achievements.store') }}">
    @csrf @if($item->exists) @method('PUT') @endif
    <label for="title">Nama prestasi</label>
    <input id="title" type="text" name="title" value="{{ old('title', $item->title) }}" required>
    @error('title')<div class="errs">{{ $message }}</div>@enderror

    <div class="row2">
        <div>
            <label for="year">Tahun</label>
            <input id="year" type="number" name="year" value="{{ old('year', $item->year) }}" required>
            @error('year')<div class="errs">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="level">Tingkat</label>
            <select id="level" name="level">
                @foreach(config('site.levels') as $l)<option value="{{ $l }}" {{ old('level', $item->level) === $l ? 'selected' : '' }}>{{ $l }}</option>@endforeach
            </select>
            @error('level')<div class="errs">{{ $message }}</div>@enderror
        </div>
    </div>

    <label for="description">Keterangan <small>(opsional, mis. nama siswa atau cabang lomba)</small></label>
    <textarea id="description" name="description" style="min-height:80px">{{ old('description', $item->description) }}</textarea>
    @error('description')<div class="errs">{{ $message }}</div>@enderror

    <label for="image">Foto <small>(opsional)</small></label>
    <input id="image" type="file" name="image" accept="image/jpeg,image/png,image/webp">
    @error('image')<div class="errs">{{ $message }}</div>@enderror
    @if($item->image)
        <img class="prev" src="{{ upload_url($item->image) }}" alt="">
        <label class="chk"><input type="checkbox" name="remove_image" value="1"> Hapus foto ini</label>
    @endif

    <p><button class="btn" type="submit">Simpan</button> <a class="btn sec" href="{{ route('admin.achievements.index') }}">Batal</a></p>
</form>
@endsection
