@extends('layouts.site')
@section('title', $post->title.' — '.site('school_name'))
@section('description', $post->summary())

@section('content')
@include('partials.pagehero', ['crumbs' => ['Informasi' => null, ($post->type === 'pengumuman' ? 'Pengumuman' : 'Berita Sekolah') => route($post->type === 'pengumuman' ? 'pengumuman' : 'posts.index'), \Illuminate\Support\Str::limit($post->title, 40) => null], 'eyebrow' => $post->published_at?->translatedFormat('j F Y') ?? 'Berita', 'title' => $post->title])
<section class="sec"><div class="wrap article">
    @if($post->image)<img class="cover" src="{{ upload_url($post->image) }}" alt="">@endif
    <div class="body">{!! nl2br(e($post->body)) !!}</div>
    <p style="margin-top:32px"><a class="more" href="{{ route($post->type === 'pengumuman' ? 'pengumuman' : 'posts.index') }}"><svg class="ic" style="transform:scaleX(-1)"><use href="#i-arrow"/></svg>Kembali ke daftar</a></p>
</div></section>
@endsection
