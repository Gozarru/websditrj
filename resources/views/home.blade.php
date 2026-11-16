@extends('layouts.site')

@section('content')
@php
    $ht = trim(site('hero_title'));
    $hp = strrpos($ht, ' ');
    $htA = $hp !== false ? substr($ht, 0, $hp) : $ht;
    $htB = $hp !== false ? substr($ht, $hp + 1) : '';
    $featIcons = ['book', 'sparkle', 'users'];
@endphp

<section class="hero">
    <div class="hero-copy">
        <p class="eyebrow line">{{ site('hero_eyebrow') }}</p>
        <h1>{{ $htA }} @if($htB)<span>{{ $htB }}</span>@endif</h1>
        <p class="lead">{{ site('hero_text') }}</p>
        <div class="cta">
            <a class="btn primary" href="{{ route('profil', 'profil') }}">Profil Sekolah<svg class="ic ar"><use href="#i-arrow"/></svg></a>
            @if(site('spmb_url'))<a class="btn outline" href="{{ site('spmb_url') }}" target="_blank" rel="noopener">Informasi SPMB<svg class="ic ne"><use href="#i-ne"/></svg></a>@endif
        </div>
        <ul class="feats">
            @foreach(site_lines('hero_features') as $i => $f)
                <li><svg class="ic"><use href="#i-{{ $featIcons[$i % 3] }}"/></svg>{{ $f }}</li>
            @endforeach
        </ul>
    </div>

    <div class="slider" data-slider role="region" aria-roledescription="carousel" aria-label="Foto kegiatan sekolah">
        <div class="slides">
            @forelse($slides as $i => $s)
            <figure class="slide {{ $i === 0 ? 'on' : '' }}">
                <img src="{{ $s['image'] }}" alt="" @if($i > 0) loading="lazy" @endif>
                <figcaption>{{ $s['caption'] }}</figcaption>
            </figure>
            @empty
            <figure class="slide art on"><figcaption>{{ site('slide_1_caption') }}</figcaption></figure>
            @endforelse
        </div>
        @if(site('spmb_year'))
        <a class="badge-spmb" @if(site('spmb_url')) href="{{ site('spmb_url') }}" target="_blank" rel="noopener" @else href="#spmb" @endif>
            <small>SPMB</small><b>{{ site('spmb_year') }}</b>
        </a>
        @endif
        @if(count($slides) > 1)
        <div class="s-ctrl">
            <div class="dots" role="group" aria-label="Pilih foto">
                @foreach($slides as $i => $s)<button type="button" class="dot-b {{ $i === 0 ? 'on' : '' }}" data-go="{{ $i }}" aria-label="Foto {{ $i + 1 }}"></button>@endforeach
            </div>
            <div class="arrows">
                <button type="button" data-prev aria-label="Foto sebelumnya"><svg class="ic"><use href="#i-left"/></svg></button>
                <button type="button" data-next aria-label="Foto berikutnya"><svg class="ic"><use href="#i-right"/></svg></button>
            </div>
        </div>
        @endif
    </div>
</section>

<section id="profil" class="sec"><div class="wrap about">
    <div>
        <p class="eyebrow line">Profil sekolah</p>
        <h2>Belajar, beribadah, dan bertumbuh dalam satu lingkungan</h2>
        @if(site('about_text'))<p class="lead2">{!! nl2br(e(site('about_text'))) !!}</p>@endif
        @if(site('about_text2'))<p class="mut">{!! nl2br(e(site('about_text2'))) !!}</p>@endif
        <a class="more" href="{{ route('profil', 'sejarah') }}">Baca sejarah singkat<svg class="ic ar"><use href="#i-arrow"/></svg></a>
    </div>
    <div class="vals">
        @foreach(site_values() as $v)
            <div class="val"><b>{{ $v['title'] }}</b><span>{{ $v['desc'] }}</span></div>
        @endforeach
    </div>
</div></section>

@if($posts->isNotEmpty())
<section id="berita" class="sec alt"><div class="wrap">
    <div class="sh row"><div><p class="eyebrow line">Informasi</p><h2>Berita terbaru</h2><p>Kabar kegiatan dan pengumuman dari sekolah.</p></div><a class="more" href="{{ route('posts.index') }}">Semua berita<svg class="ic ar"><use href="#i-arrow"/></svg></a></div>
    <div class="grid g3">
        @foreach($posts as $p)
        <a class="card post" href="{{ route('posts.show', $p->slug) }}">
            <div class="pic" @if($p->image) style="background-image:url('{{ upload_url($p->image) }}')" @endif></div>
            <div class="in">
                <span class="date">{{ $p->published_at?->translatedFormat('j F Y') }}</span>
                <h3>{{ $p->title }}</h3>
                <p>{{ $p->summary() }}</p>
            </div>
        </a>
        @endforeach
    </div>
</div></section>
@endif

@if($announcements->isNotEmpty() || $agendas->isNotEmpty())
<section id="pengumuman" class="sec"><div class="wrap duo">
    <div>
        <div class="sh row"><div><p class="eyebrow line">Pengumuman</p><h2>Kabar penting</h2></div><a class="more" href="{{ route('pengumuman') }}">Semua<svg class="ic ar"><use href="#i-arrow"/></svg></a></div>
        <div class="alist">
            @forelse($announcements as $p)
            <a class="card arow" href="{{ route('posts.show', $p->slug) }}">
                <span class="dbox"><b>{{ $p->published_at?->format('j') }}</b><small>{{ $p->published_at?->translatedFormat('M Y') }}</small></span>
                <span class="atxt"><h3>{{ $p->title }}</h3></span>
                <svg class="ic ne"><use href="#i-ne"/></svg>
            </a>
            @empty
            <p class="empty">Belum ada pengumuman.</p>
            @endforelse
        </div>
    </div>
    <div>
        <div class="sh row"><div><p class="eyebrow line">Agenda</p><h2>Kegiatan mendatang</h2></div><a class="more" href="{{ route('agenda') }}">Semua<svg class="ic ar"><use href="#i-arrow"/></svg></a></div>
        <div class="alist">
            @forelse($agendas as $a)
                @include('partials.agenda-row', ['a' => $a])
            @empty
            <p class="empty">Belum ada agenda mendatang.</p>
            @endforelse
        </div>
    </div>
</div></section>
@endif

@if($achievements->isNotEmpty())
<section id="prestasi" class="sec"><div class="wrap">
    <div class="sh row"><div><p class="eyebrow line">Prestasi</p><h2>Capaian siswa dan sekolah</h2></div><a class="more" href="{{ route('prestasi') }}">Semua prestasi<svg class="ic ar"><use href="#i-arrow"/></svg></a></div>
    @include('partials.prestasi', ['achievements' => $achievements])
</div></section>
@endif

@if($media->isNotEmpty())
<section id="media" class="sec alt"><div class="wrap">
    <div class="sh row"><div><p class="eyebrow line">Media belajar</p><h2>Belajar di rumah, per kelas</h2><p>Materi pendamping belajar peserta didik.</p></div><a class="more" href="{{ route('media') }}">Buka halaman media<svg class="ic ar"><use href="#i-arrow"/></svg></a></div>
    @php $grades = collect(config('site.grades'))->filter(fn ($g) => $media->has($g))->values(); @endphp
    <div class="tabs" role="group" aria-label="Pilih kelas">
        @foreach($grades as $i => $g)<button type="button" data-tab="{{ $i }}" aria-pressed="{{ $i === 0 ? 'true' : 'false' }}">{{ $g }}</button>@endforeach
    </div>
    @foreach($grades as $i => $g)
    <div class="grid g3 panel" data-panel="{{ $i }}" @if($i !== 0) hidden @endif>
        @foreach($media[$g] as $m)
            @include('partials.media-card', ['m' => $m])
        @endforeach
    </div>
    @endforeach
</div></section>
@endif

@if($photos->isNotEmpty())
<section id="galeri" class="sec"><div class="wrap">
    <div class="sh row"><div><p class="eyebrow line">Galeri</p><h2>Galeri kegiatan</h2></div><a class="more" href="{{ route('galeri') }}">Semua foto<svg class="ic ar"><use href="#i-arrow"/></svg></a></div>
    @include('partials.gallery', ['photos' => $photos])
</div></section>
@endif

@if(site('spmb_url'))
<section id="spmb" class="sec"><div class="wrap"><div class="band">
    <div><h2>Pendaftaran murid baru</h2><p>Daftar, unggah berkas, dan pantau status pendaftaran dari satu dasbor wali.</p></div>
    <a class="btn gold" href="{{ site('spmb_url') }}" target="_blank" rel="noopener">{{ site('spmb_button') ?: 'Daftar Sekarang' }}<svg class="ic ne"><use href="#i-ne"/></svg></a>
</div></div></section>
@endif
@endsection
