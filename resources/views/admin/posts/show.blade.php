@extends('layouts.admin')
@section('title', $post->title)
@section('content')
<div class="bar">
    <h1>{{ $post->title }}</h1>
    <div style="display:flex;gap:8px;flex-wrap:wrap">
        <a class="btn sec" href="{{ route('admin.posts.index') }}">← Daftar</a>
        @if($canEdit)<a class="btn" href="{{ route('admin.posts.edit', $post) }}">Ubah</a>@endif
        @if(in_array($post->status, ['published']))<a class="btn sec" href="{{ route('posts.show', $post->slug) }}" target="_blank" rel="noopener">Lihat di website ↗</a>@endif
    </div>
</div>
<div class="grid2">
    <div class="card preview">
        <p class="muted" style="margin-top:0">{{ $post->typeLabel() }}</p>
        @if($post->image)<img class="cover" src="{{ upload_url($post->image) }}" alt="">@endif
        @if($post->excerpt)<p><b>{{ $post->excerpt }}</b></p>@endif
        <div>{!! nl2br(e($post->body)) !!}</div>
    </div>
    <div>@include('admin.posts._panel')</div>
</div>
@endsection
