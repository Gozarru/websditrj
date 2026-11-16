@extends('layouts.admin')
@section('title', $item->exists ? 'Ubah menu' : 'Tambah menu')
@section('content')
@php
    $type = old('link_type', $item->link_type ?: 'page');
    $parentId = old('parent_id', $item->parent_id);
@endphp
<h1>{{ $item->exists ? 'Ubah menu' : 'Tambah menu' }}</h1>
<form class="card" method="POST" action="{{ $item->exists ? route('admin.menu.update', $item) : route('admin.menu.store') }}">
    @csrf @if($item->exists) @method('PUT') @endif

    <div class="row2">
        <div>
            <label for="label">Nama menu <small>(yang tampil di website)</small></label>
            <input id="label" type="text" name="label" value="{{ old('label', $item->label) }}" maxlength="60" required>
            @error('label')<div class="errs">{{ $message }}</div>@enderror
        </div>
        <div>
            <label for="parent_id">Letak menu</label>
            @if($hasChildren)
                <select id="parent_id" disabled><option>Menu utama (baris atas)</option></select>
                <p class="help">Menu ini punya submenu, jadi tetap menjadi menu utama.</p>
            @else
                <select id="parent_id" name="parent_id">
                    <option value="">Menu utama (baris atas)</option>
                    @foreach($parents as $p)
                        <option value="{{ $p->id }}" @selected((string) $parentId === (string) $p->id)>Submenu di dalam “{{ $p->label }}”</option>
                    @endforeach
                </select>
            @endif
            @error('parent_id')<div class="errs">{{ $message }}</div>@enderror
        </div>
    </div>

    <label>Jenis tautan</label>
    <div class="type-pick">
        <label><input type="radio" name="link_type" value="page" @checked($type === 'page')> Halaman di situs ini</label>
        <label><input type="radio" name="link_type" value="url" @checked($type === 'url')> Alamat lain (URL)</label>
        <label><input type="radio" name="link_type" value="none" @checked($type === 'none')> Tanpa tautan (judul dropdown)</label>
    </div>
    @error('link_type')<div class="errs">{{ $message }}</div>@enderror
    @if($hasChildren)<p class="help">Karena menu ini punya submenu, di website ia tampil sebagai dropdown dan tautannya sendiri tidak dipakai.</p>@endif

    <div data-link="page">
        <label for="page">Halaman tujuan</label>
        <select id="page" name="page">
            <option value="">— Pilih halaman —</option>
            @foreach($pageGroups as $group => $pages)
                <optgroup label="{{ $group }}">
                    @foreach($pages as $key => $name)
                        <option value="{{ $key }}" @selected(old('page', $item->page) === $key)>{{ $name }}</option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
        @error('page')<div class="errs">{{ $message }}</div>@enderror
    </div>

    <div data-link="url">
        <label for="url">Alamat tujuan <small>(contoh: https://spmb.raudhatuljannah.or.id atau /informasi/berita)</small></label>
        <input id="url" type="text" name="url" value="{{ old('url', $item->url) }}" maxlength="255" inputmode="url" autocomplete="off">
        @error('url')<div class="errs">{{ $message }}</div>@enderror
    </div>

    <div data-link="none">
        <p class="help">Menu tanpa tautan hanya berfungsi sebagai judul dropdown. Setelah disimpan, tambahkan isinya lewat tombol “+ Submenu”. Selama belum ada submenu yang tampil, menu ini tidak muncul di website.</p>
    </div>

    <div data-link="page url">
        <input type="hidden" name="new_tab" value="0">
        <label class="chk"><input type="checkbox" name="new_tab" value="1" @checked(old('new_tab', $item->new_tab ? '1' : '0'))> Buka di tab baru</label>
    </div>

    <input type="hidden" name="is_visible" value="0">
    <label class="chk"><input type="checkbox" name="is_visible" value="1" @checked(old('is_visible', $item->is_visible ? '1' : '0'))> Tampilkan di website</label>
    <p class="help">Hilangkan centang untuk menyembunyikan menu tanpa menghapusnya.</p>

    <p><button class="btn" type="submit">Simpan</button> <a class="btn sec" href="{{ route('admin.menu.index') }}">Batal</a></p>
</form>

<script>
(function () {
    var radios = document.querySelectorAll('input[name="link_type"]');
    var blocks = document.querySelectorAll('[data-link]');
    function sync() {
        var cur = (document.querySelector('input[name="link_type"]:checked') || {}).value || 'page';
        blocks.forEach(function (b) {
            b.hidden = b.getAttribute('data-link').split(' ').indexOf(cur) === -1;
        });
    }
    radios.forEach(function (r) { r.addEventListener('change', sync); });
    sync();
})();
</script>
@endsection
