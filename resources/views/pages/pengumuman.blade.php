@extends('layouts.site')
@section('title', 'Pengumuman — '.site('school_name'))

@section('content')
@include('partials.pagehero', ['crumbs' => ['Informasi' => null, 'Pengumuman' => null], 'eyebrow' => 'Informasi', 'title' => 'Pengumuman', 'subtitle' => 'Pengumuman resmi untuk orang tua dan peserta didik.'])
<section class="sec"><div class="wrap">
    <div class="alist">
        @forelse($posts as $p)
        <a class="card arow" href="{{ route('posts.show', $p->slug) }}">
            <span class="dbox"><b>{{ $p->published_at?->format('j') }}</b><small>{{ $p->published_at?->translatedFormat('M Y') }}</small></span>
            <span class="atxt"><h3>{{ $p->title }}</h3><p>{{ $p->summary() }}</p></span>
            <svg class="ic ne"><use href="#i-ne"/></svg>
        </a>
        @empty
        <p class="empty">Belum ada pengumuman.</p>
        @endforelse
    </div>
    <div class="pager">
        <span>@if($posts->previousPageUrl())<a class="more" href="{{ $posts->previousPageUrl() }}"><svg class="ic" style="transform:scaleX(-1)"><use href="#i-arrow"/></svg>Sebelumnya</a>@endif</span>
        <span>@if($posts->nextPageUrl())<a class="more" href="{{ $posts->nextPageUrl() }}">Berikutnya<svg class="ic"><use href="#i-arrow"/></svg></a>@endif</span>
    </div>
</div></section>
@endsection
