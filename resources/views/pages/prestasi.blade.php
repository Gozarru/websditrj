@extends('layouts.site')
@section('title', 'Prestasi Siswa — '.site('school_name'))

@section('content')
@include('partials.pagehero', ['crumbs' => ['Informasi' => null, 'Prestasi Siswa' => null], 'eyebrow' => 'Informasi', 'title' => 'Prestasi Siswa', 'subtitle' => 'Dokumentasi capaian peserta didik dan sekolah.'])
<section class="sec"><div class="wrap">
    @if($achievements->isNotEmpty())
        @include('partials.prestasi', ['achievements' => $achievements])
    @else
        <p class="empty">Belum ada data prestasi.</p>
    @endif
</div></section>
@endsection
