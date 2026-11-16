@extends('layouts.site')
@section('title', 'Berita Sekolah — '.site('school_name'))

@section('content')
@include('partials.pagehero', ['crumbs' => ['Informasi' => null, 'Berita Sekolah' => null], 'eyebrow' => 'Informasi', 'title' => 'Berita Sekolah', 'subtitle' => 'Informasi resmi sekolah yang diperbarui secara berkala oleh pengelola website.'])
<section class="sec"><div class="wrap">
    <div class="grid g3">
        @forelse($posts as $p)
        <a class="card post" href="{{ route('posts.show', $p->slug) }}">
            <div class="pic" @if($p->image) style="background-image:url('{{ upload_url($p->image) }}')" @endif></div>
            <div class="in">
                <span class="date">{{ $p->published_at?->translatedFormat('j F Y') }}</span>
                <h3>{{ $p->title }}</h3>
                <p>{{ $p->summary() }}</p>
            </div>
        </a>
        @empty
        <p class="empty">Belum ada berita.</p>
        @endforelse
    </div>
    <div class="pager">
        <span>@if($posts->previousPageUrl())<a class="more" href="{{ $posts->previousPageUrl() }}"><svg class="ic" style="transform:scaleX(-1)"><use href="#i-arrow"/></svg>Sebelumnya</a>@endif</span>
        <span>@if($posts->nextPageUrl())<a class="more" href="{{ $posts->nextPageUrl() }}">Berikutnya<svg class="ic ar"><use href="#i-arrow"/></svg></a>@endif</span>
    </div>
</div></section>
@endsection
