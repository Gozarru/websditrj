@extends('layouts.site')
@section('title', $title.' — '.site('school_name'))
@section('description', $intro)

@section('content')
@include('partials.pagehero', ['crumbs' => ['Profil Sekolah' => null, $title => null], 'eyebrow' => 'Profil Sekolah', 'title' => $title, 'subtitle' => $intro])
<section class="sec"><div class="wrap side-layout">
    @php
        $menuItems = [];
        foreach ($pages as $s => $p) { $menuItems[] = ['label' => $p[0], 'url' => route('profil', $s), 'on' => $s === $slug]; }
    @endphp
    @include('partials.side', ['label' => 'Menu profil', 'items' => $menuItems])
    <div class="prose">
        {!! rich_text($body) !!}
        @if($slug === 'peta-lokasi' && site('address'))
            <div class="map"><iframe title="Peta lokasi sekolah" src="https://www.google.com/maps?q={{ urlencode(site('school_name').' '.site('address')) }}&amp;output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe></div>
            <p><a class="more" target="_blank" rel="noopener" href="https://www.google.com/maps/search/?api=1&amp;query={{ urlencode(site('school_name').' '.site('address')) }}">Buka di Google Maps<svg class="ic ne"><use href="#i-ne"/></svg></a></p>
        @endif
    </div>
</div></section>
@endsection
