@extends('layouts.site')
@section('title', 'Media Belajar '.$current.' — '.site('school_name'))

@section('content')
@include('partials.pagehero', ['crumbs' => ['Media Belajar' => null, $current => null], 'eyebrow' => 'Media Belajar', 'title' => $current, 'subtitle' => 'Materi pendamping belajar di rumah untuk peserta didik.'])
<section class="sec"><div class="wrap side-layout">
    @php
        $menuItems = [];
        foreach ($grades as $g) { $menuItems[] = ['label' => $g, 'url' => route('media', grade_slug($g)), 'on' => $g === $current, 'count' => $counts[$g] ?? 0]; }
    @endphp
    @include('partials.side', ['label' => 'Pilih kelas', 'items' => $menuItems])
    <div>
        <div class="grid g2">
            @forelse($items as $m)
                @include('partials.media-card', ['m' => $m])
            @empty
                <p class="empty">Belum ada media belajar untuk {{ $current }}.</p>
            @endforelse
        </div>
    </div>
</div></section>
@endsection
