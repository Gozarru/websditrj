@extends('layouts.site')
@section('title', 'Galeri Foto — '.site('school_name'))

@section('content')
@include('partials.pagehero', ['crumbs' => ['Galeri' => null, 'Galeri Foto' => null], 'eyebrow' => 'Galeri', 'title' => 'Galeri Foto', 'subtitle' => 'Momen kegiatan belajar, ibadah, dan prestasi di sekolah.'])
<section class="sec"><div class="wrap">
    @if($photos->isNotEmpty())
        @include('partials.gallery', ['photos' => $photos])
        <div class="pager">
            <span>@if($photos->previousPageUrl())<a class="more" href="{{ $photos->previousPageUrl() }}"><svg class="ic" style="transform:scaleX(-1)"><use href="#i-arrow"/></svg>Sebelumnya</a>@endif</span>
            <span>@if($photos->nextPageUrl())<a class="more" href="{{ $photos->nextPageUrl() }}">Berikutnya<svg class="ic ar"><use href="#i-arrow"/></svg></a>@endif</span>
        </div>
    @else
        <p class="empty">Belum ada foto.</p>
    @endif
</div></section>
@endsection
