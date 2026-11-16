<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex">
<title>@yield('title', 'Admin') — {{ site('school_name') }}</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
@php
    $u = auth()->user();
    $nav = [];
    $nav[] = ['Utama', [['Ringkasan', 'admin.dashboard', 'admin.dashboard', $u->can('dashboard'), 0]]];
    $nav[] = ['Konten', [
        ['Berita & Pengumuman', 'admin.posts.index', 'admin.posts.*', $u->canAny(['posts.view', 'posts.write']), 0],
        ['Agenda', 'admin.agendas.index', 'admin.agendas.*', $u->can('agenda.manage'), 0],
        ['Prestasi', 'admin.achievements.index', 'admin.achievements.*', $u->can('content.manage'), 0],
        ['Media belajar', 'admin.media.index', 'admin.media.*', $u->can('content.manage'), 0],
        ['Galeri', 'admin.gallery.index', 'admin.gallery.*', $u->can('content.manage'), 0],
    ]];
    $nav[] = ['Sistem', [
        ['Pengaturan situs', 'admin.settings.edit', 'admin.settings.*', $u->can('settings.manage'), 0],
        ['Menu situs', 'admin.menu.index', 'admin.menu.*', $u->can('settings.manage'), 0],
        ['Pengguna', 'admin.users.index', 'admin.users.*', $u->can('users.manage'), 0],
        ['Log aktivitas', 'admin.audit.index', 'admin.audit.*', $u->can('audit.view'), 0],
    ]];
@endphp
<div class="shell">
    <div class="scrim" data-scrim></div>
    <aside class="sidebar" id="sidebar" aria-label="Menu admin">
        <div class="sb-head">
            <span class="sb-logo">RJ</span>
            <div><b>Panel Admin</b><small>{{ site('school_name') }}</small></div>
            <button class="sb-close" type="button" data-nav-close aria-label="Tutup menu">×</button>
        </div>
        <nav>
            @foreach($nav as $group)
                @if(collect($group[1])->contains(fn ($i) => $i[3]))
                    <div class="sb-label">{{ $group[0] }}</div>
                    @foreach($group[1] as $i)
                        @if($i[3])
                            <a href="{{ route($i[1]) }}" class="{{ request()->routeIs($i[2]) ? 'on' : '' }}">{{ $i[0] }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </nav>
        <div class="sb-foot">
            <div class="me"><span class="avatar">{{ $u->initials() }}</span><div><b>{{ $u->name }}</b><small>{{ $u->roleLabel() }}</small></div></div>
            <a href="{{ route('admin.account.edit') }}">Akun saya</a>
            <a href="{{ route('home') }}" target="_blank" rel="noopener">Lihat website ↗</a>
            <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Keluar</button></form>
        </div>
    </aside>

    <div class="main">
        <header class="topbar">
            <button class="burger" type="button" data-nav-open aria-label="Buka menu" aria-controls="sidebar">☰</button>
            <span class="tb-title">@yield('title', 'Admin')</span>
            <span class="chip"><span class="nm">{{ $u->name }}</span><span class="badge r-{{ $u->role }}">{{ $u->roleLabel() }}</span></span>
        </header>
        <main class="content">
            @if(session('ok'))<div class="flash" role="status">{{ session('ok') }}</div>@endif
            @if(session('error'))<div class="flash err" role="alert">{{ session('error') }}</div>@endif
            @if($errors->any())<div class="flash err" role="alert">Ada isian yang perlu diperbaiki. Periksa pesan berwarna merah di bawah.</div>@endif
            @yield('content')
        </main>
    </div>
</div>
<script src="{{ asset('js/admin.js') }}" defer></script>
</body>
</html>
