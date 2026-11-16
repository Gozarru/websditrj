@extends('layouts.admin')
@section('title', 'Pengaturan situs')
@section('content')
<h1>Pengaturan situs</h1>
<form method="POST" enctype="multipart/form-data" action="{{ route('admin.settings.update') }}">
    @csrf @method('PUT')
    @foreach($groups as $group => $fields)
    <div class="card">
        <b>{{ $group }}</b>
        @foreach($fields as $f)
            @php $k = $f['key']; $val = old($k, site($k)); @endphp
            <label for="{{ $k }}">{{ $f['label'] }}</label>
            @if($f['type'] === 'textarea')
                <textarea id="{{ $k }}" name="{{ $k }}">{{ $val }}</textarea>
            @elseif($f['type'] === 'image')
                <input id="{{ $k }}" type="file" name="{{ $k }}" accept="image/jpeg,image/png,image/webp">
                @if(site($k))
                    <img class="prev" src="{{ upload_url(site($k)) }}" alt="">
                    <label class="chk"><input type="checkbox" name="remove_{{ $k }}" value="1"> Hapus gambar ini</label>
                @endif
            @else
                <input id="{{ $k }}" type="{{ $f['type'] === 'url' ? 'url' : 'text' }}" name="{{ $k }}" value="{{ $val }}">
            @endif
            @error($k)<div class="errs">{{ $message }}</div>@enderror
        @endforeach
    </div>
    @endforeach
    <p><button class="btn" type="submit">Simpan pengaturan</button></p>
</form>
@endsection
