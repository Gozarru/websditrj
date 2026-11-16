@extends('layouts.site')
@section('title', 'Agenda — '.site('school_name'))

@section('content')
@include('partials.pagehero', ['crumbs' => ['Informasi' => null, 'Agenda' => null], 'eyebrow' => 'Informasi', 'title' => 'Agenda Sekolah', 'subtitle' => 'Jadwal kegiatan sekolah yang akan datang.'])
<section class="sec"><div class="wrap">
    <div class="alist">
        @forelse($upcoming as $a)
            @include('partials.agenda-row', ['a' => $a])
        @empty
        <p class="empty">Belum ada agenda mendatang.</p>
        @endforelse
    </div>
    @if($past->isNotEmpty())
    <h2 class="subh">Agenda yang sudah berlalu</h2>
    <div class="alist past">
        @foreach($past as $a)
            @include('partials.agenda-row', ['a' => $a])
        @endforeach
    </div>
    @endif
</div></section>
@endsection
