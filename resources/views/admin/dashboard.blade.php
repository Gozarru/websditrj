@extends('layouts.admin')
@section('title', 'Ringkasan')
@section('content')
@php $max = max(1, collect($chart)->max('n')); @endphp
<div class="hello">
    <div><h1>Halo, {{ explode(' ', $user->name)[0] }}</h1><p class="muted" style="margin:0">Anda masuk sebagai <span class="badge r-{{ $user->role }}">{{ $user->roleLabel() }}</span></p></div>
    @if($user->can('posts.write'))
    <div style="display:flex;gap:8px;flex-wrap:wrap">
        <a class="btn" href="{{ route('admin.posts.create') }}">+ Berita</a>
        <a class="btn sec" href="{{ route('admin.posts.create', ['type' => 'pengumuman']) }}">+ Pengumuman</a>
    </div>
    @endif
</div>

<div class="stats">
    <div class="stat hl"><small>Pengunjung hari ini</small><b>{{ number_format($visits['today']) }}</b><span>{{ number_format($visits['week']) }} dalam 7 hari terakhir</span></div>
    <div class="stat"><small>Pengunjung 30 hari</small><b>{{ number_format($visits['month']) }}</b><span>{{ number_format($visits['views30']) }} halaman dibuka</span></div>
    <a class="stat" href="{{ route('admin.posts.index', ['type' => 'berita']) }}"><small>Artikel (berita)</small><b>{{ $content['berita']['live'] }}</b><span>tayang dari {{ $content['berita']['all'] }} tulisan</span></a>
    <a class="stat" href="{{ route('admin.posts.index', ['type' => 'pengumuman']) }}"><small>Pengumuman</small><b>{{ $content['pengumuman']['live'] }}</b><span>tayang dari {{ $content['pengumuman']['all'] }} tulisan</span></a>
    @if($user->can('agenda.manage'))
    <a class="stat" href="{{ route('admin.agendas.index') }}"><small>Agenda</small><b>{{ $content['agenda']['upcoming'] }}</b><span>mendatang dari {{ $content['agenda']['all'] }} agenda</span></a>
    @else
    <div class="stat"><small>Agenda</small><b>{{ $content['agenda']['upcoming'] }}</b><span>mendatang dari {{ $content['agenda']['all'] }} agenda</span></div>
    @endif
</div>

<div class="grid2">
    <div>
        <div class="card">
            <h2>Pengunjung 14 hari terakhir</h2>
            <div class="bars" role="img" aria-label="Grafik pengunjung harian">
                @foreach($chart as $c)
                <div class="c" title="{{ $c['label'] }}: {{ $c['n'] }} pengunjung">
                    <span class="v">{{ $c['n'] ?: '' }}</span>
                    <div class="b" style="height:{{ max(2, round($c['n'] / $max * 100)) }}%"></div>
                    <span class="l">{{ $c['short'] }}</span>
                </div>
                @endforeach
            </div>
            <p class="help">Pengunjung dihitung unik per hari (perangkat yang sama dihitung sekali sehari). Total sejak awal: {{ number_format($visits['total']) }} kunjungan harian.</p>
        </div>

        <div class="card">
            <h2>Alur publikasi</h2>
            <div class="pipe">
                @foreach(\App\Models\Post::STATUSES as $k => $label)
                    <a href="{{ route('admin.posts.index', ['status' => $k]) }}"><b>{{ $status[$k] ?? 0 }}</b><small>{{ $label }}</small></a>
                @endforeach
            </div>
        </div>
    </div>

    <div>
        <div class="card">
            <h2>Perlu tindakan Anda</h2>
            @if($queue->isNotEmpty())
            <ul class="list">
                @foreach($queue as $p)
                <li>
                    <span class="tt"><a href="{{ route('admin.posts.show', $p) }}">{{ $p->title }}</a><small>{{ $p->typeLabel() }} · {{ $p->author?->name ?? '—' }}</small></span>
                    <span class="badge s-{{ $p->status }}">{{ $p->statusLabel() }}</span>
                </li>
                @endforeach
            </ul>
            @else
            <p class="empty">Tidak ada tulisan yang menunggu tindakan Anda.</p>
            @endif
        </div>

        <div class="card">
            <h2>{{ $user->can('audit.view') ? 'Aktivitas terbaru' : 'Aktivitas saya' }}</h2>
            @if($logs->isNotEmpty())
            <ul class="log">
                @foreach($logs as $l)
                <li>{{ $l->description }}<small>{{ $l->user_name }} · {{ $l->created_at->diffForHumans() }}</small></li>
                @endforeach
            </ul>
            @if($user->can('audit.view'))<p style="margin:12px 0 0"><a href="{{ route('admin.audit.index') }}">Lihat semua aktivitas →</a></p>@endif
            @else
            <p class="empty">Belum ada aktivitas.</p>
            @endif
        </div>
    </div>
</div>
@endsection
