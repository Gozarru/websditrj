@extends('layouts.admin')
@section('title', $item->exists ? 'Ubah agenda' : 'Tambah agenda')
@section('content')
<h1>{{ $item->exists ? 'Ubah agenda' : 'Tambah agenda' }}</h1>
<form class="card" method="POST" action="{{ $item->exists ? route('admin.agendas.update', $item) : route('admin.agendas.store') }}">
    @csrf @if($item->exists) @method('PUT') @endif
    <label for="title">Nama agenda</label>
    <input id="title" type="text" name="title" value="{{ old('title', $item->title) }}" required>
    @error('title')<div class="errs">{{ $message }}</div>@enderror
    <div class="row2">
        <div><label for="starts_on">Tanggal mulai</label><input id="starts_on" type="date" name="starts_on" value="{{ old('starts_on', $item->starts_on?->format('Y-m-d')) }}" required>@error('starts_on')<div class="errs">{{ $message }}</div>@enderror</div>
        <div><label for="ends_on">Tanggal selesai <small>(opsional)</small></label><input id="ends_on" type="date" name="ends_on" value="{{ old('ends_on', $item->ends_on?->format('Y-m-d')) }}">@error('ends_on')<div class="errs">{{ $message }}</div>@enderror</div>
    </div>
    <div class="row2">
        <div><label for="time_text">Jam <small>(opsional, contoh: 07.30 – 09.00 WIB)</small></label><input id="time_text" type="text" name="time_text" value="{{ old('time_text', $item->time_text) }}">@error('time_text')<div class="errs">{{ $message }}</div>@enderror</div>
        <div><label for="location">Tempat <small>(opsional)</small></label><input id="location" type="text" name="location" value="{{ old('location', $item->location) }}">@error('location')<div class="errs">{{ $message }}</div>@enderror</div>
    </div>
    <label for="description">Keterangan <small>(opsional)</small></label>
    <textarea id="description" name="description">{{ old('description', $item->description) }}</textarea>
    @error('description')<div class="errs">{{ $message }}</div>@enderror
    <p><button class="btn" type="submit">Simpan</button> <a class="btn sec" href="{{ route('admin.agendas.index') }}">Batal</a></p>
</form>
@endsection
