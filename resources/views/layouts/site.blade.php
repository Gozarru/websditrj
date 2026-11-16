<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', site('school_name').' — Sekolah Dasar Islam Terpadu')</title>
<meta name="description" content="@yield('description', 'Website resmi '.site('school_name').'. Informasi profil sekolah, berita, prestasi, media belajar, galeri kegiatan, dan pendaftaran murid baru (SPMB).')">
<meta name="theme-color" content="#04503C">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/site.css') }}">
</head>
<body>
@include('partials.icons')
@php
    $socials = array_filter(['Instagram' => site('instagram'), 'YouTube' => site('youtube'), 'Facebook' => site('facebook')]);
    $bn = trim(site('school_name'));
    $bp = strrpos($bn, ' ');
    $brandA = $bp !== false ? substr($bn, 0, $bp) : $bn;
    $brandB = $bp !== false ? substr($bn, $bp + 1) : '';
@endphp

<div class="topbar"><div class="wrap">
    @php
        $tbText = trim((string) site('topbar_text'));
        $tbWidth = mb_strlen($tbText) * 8 + 90;               // perkiraan lebar satu teks + jarak (px)
        $tbRep = max(2, (int) ceil(1500 / max(80, $tbWidth))); // ulangi agar selalu lebih lebar dari layar
        $tbDur = max(20, (int) round($tbRep * $tbWidth / 70)); // kecepatan sekitar 70 px/detik
    @endphp
    <div class="tb-note">
        <i class="dot"></i>
        @if($tbText !== '')
        <span class="sr">{{ $tbText }}</span>
        <div class="tb-marquee" aria-hidden="true" style="--tb-dur: {{ $tbDur }}s">
            <div class="tb-track">
                <span class="tb-group">@for($i = 0; $i < $tbRep; $i++)<span class="tb-item">{{ $tbText }}</span>@endfor</span>
                <span class="tb-group">@for($i = 0; $i < $tbRep; $i++)<span class="tb-item">{{ $tbText }}</span>@endfor</span>
            </div>
        </div>
        @endif
    </div>
    <div class="tb-links">
        <a href="{{ route('kontak') }}">Hubungi Kami</a>
        <span class="sep"></span>
        @if($socials)
            @foreach($socials as $label => $url)<a class="soft" href="{{ $url }}" target="_blank" rel="noopener">{{ $label }}</a>@endforeach
        @else
            <span class="soft">Media sosial belum diatur</span>
        @endif
    </div>
</div></div>

<header class="site-header" id="top"><div class="wrap hdr">
    <a class="brand" href="{{ route('home') }}" aria-label="{{ site('school_name') }} — beranda">
        <span class="logo">@if(site('logo'))<img src="{{ upload_url(site('logo')) }}" alt="">@else<svg class="ic"><use href="#i-shield"/></svg>@endif</span>
        <span class="bt"><b>{{ $brandA }}</b>@if($brandB)<small>{{ $brandB }}</small>@endif</span>
    </a>
    <button class="burger" type="button" aria-expanded="false" aria-controls="menu" data-burger>
        <svg class="ic o"><use href="#i-menu"/></svg><svg class="ic x"><use href="#i-close"/></svg><span class="sr">Menu</span>
    </button>
    <nav class="nav" id="menu" aria-label="Menu utama">
        @foreach(site_menu() as $m)
            @if(isset($m['children']))
            <div class="dd {{ !empty($m['active']) ? 'on' : '' }}">
                <button class="nl" type="button" aria-expanded="false" aria-haspopup="true">{{ $m['label'] }}<svg class="ic chev"><use href="#i-chev"/></svg></button>
                <div class="dd-panel">
                    @foreach($m['children'] as $c)
                        <a href="{{ $c['url'] }}" @if(!empty($c['external'])) target="_blank" rel="noopener" @endif><span>{{ $c['label'] }}</span><svg class="ic ne"><use href="#i-ne"/></svg></a>
                    @endforeach
                </div>
            </div>
            @else
                <a class="nl {{ !empty($m['active']) ? 'on' : '' }}" href="{{ $m['url'] }}" @if(!empty($m['external'])) target="_blank" rel="noopener" @endif>{{ $m['label'] }}</a>
            @endif
        @endforeach
        @if(site('spmb_url'))
            <a class="btn gold nav-cta" href="{{ site('spmb_url') }}" target="_blank" rel="noopener">{{ site('spmb_button') ?: 'Daftar Sekarang' }}<svg class="ic ne"><use href="#i-ne"/></svg></a>
        @endif
    </nav>
</div></header>

<main>@yield('content')</main>

<footer><div class="wrap fgrid">
    <div class="fcol fbrand">
        <b>{{ site('school_name') }}</b>
        @if(site('foundation_name'))<p>{{ site('foundation_name') }}</p>@endif
        <p>Membangun generasi Qur’ani, berilmu, dan berakhlak mulia.</p>
    </div>
    <div class="fcol">
        <h4>Profil Sekolah</h4>
        <a href="{{ route('profil', 'sejarah') }}">Sejarah Singkat</a>
        <a href="{{ route('profil', 'visi-misi') }}">Visi, Misi &amp; Tujuan</a>
        <a href="{{ route('profil', 'peta-lokasi') }}">Peta Lokasi</a>
        <a href="{{ route('posts.index') }}">Berita Sekolah</a>
    </div>
    <div class="fcol">
        <h4>Kontak</h4>
        @if(site('address'))<p>{!! nl2br(e(site('address'))) !!}</p>@endif
        @if(site('phone'))<p>Telepon: <a href="tel:{{ preg_replace('/[^\d+]/', '', site('phone')) }}">{{ site('phone') }}</a></p>@endif
        @if(wa_link(site('whatsapp')))<p>WhatsApp: <a href="{{ wa_link(site('whatsapp')) }}" target="_blank" rel="noopener">{{ site('whatsapp') }}</a></p>@endif
        @if(site('email'))<p>Email: <a href="mailto:{{ site('email') }}">{{ site('email') }}</a></p>@endif
        @foreach($socials as $label => $url)<a href="{{ $url }}" target="_blank" rel="noopener">{{ $label }}</a>@endforeach
    </div>
</div>
<div class="wrap fbottom"><span>© {{ date('Y') }} {{ site('school_name') }}</span><a href="{{ route('login') }}">Masuk admin</a></div>
</footer>

<script src="{{ asset('js/site.js') }}" defer></script>
</body>
</html>
