<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex">
<title><?php echo $__env->yieldContent('title', 'Admin'); ?> — <?php echo e(site('school_name')); ?></title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo e(asset('css/admin.css')); ?>">
</head>
<body>
<?php
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
?>
<div class="shell">
    <div class="scrim" data-scrim></div>
    <aside class="sidebar" id="sidebar" aria-label="Menu admin">
        <div class="sb-head">
            <span class="sb-logo">RJ</span>
            <div><b>Panel Admin</b><small><?php echo e(site('school_name')); ?></small></div>
            <button class="sb-close" type="button" data-nav-close aria-label="Tutup menu">×</button>
        </div>
        <nav>
            <?php $__currentLoopData = $nav; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(collect($group[1])->contains(fn ($i) => $i[3])): ?>
                    <div class="sb-label"><?php echo e($group[0]); ?></div>
                    <?php $__currentLoopData = $group[1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($i[3]): ?>
                            <a href="<?php echo e(route($i[1])); ?>" class="<?php echo e(request()->routeIs($i[2]) ? 'on' : ''); ?>"><?php echo e($i[0]); ?></a>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </nav>
        <div class="sb-foot">
            <div class="me"><span class="avatar"><?php echo e($u->initials()); ?></span><div><b><?php echo e($u->name); ?></b><small><?php echo e($u->roleLabel()); ?></small></div></div>
            <a href="<?php echo e(route('admin.account.edit')); ?>">Akun saya</a>
            <a href="<?php echo e(route('home')); ?>" target="_blank" rel="noopener">Lihat website ↗</a>
            <form method="POST" action="<?php echo e(route('logout')); ?>"><?php echo csrf_field(); ?><button type="submit">Keluar</button></form>
        </div>
    </aside>

    <div class="main">
        <header class="topbar">
            <button class="burger" type="button" data-nav-open aria-label="Buka menu" aria-controls="sidebar">☰</button>
            <span class="tb-title"><?php echo $__env->yieldContent('title', 'Admin'); ?></span>
            <span class="chip"><span class="nm"><?php echo e($u->name); ?></span><span class="badge r-<?php echo e($u->role); ?>"><?php echo e($u->roleLabel()); ?></span></span>
        </header>
        <main class="content">
            <?php if(session('ok')): ?><div class="flash" role="status"><?php echo e(session('ok')); ?></div><?php endif; ?>
            <?php if(session('error')): ?><div class="flash err" role="alert"><?php echo e(session('error')); ?></div><?php endif; ?>
            <?php if($errors->any()): ?><div class="flash err" role="alert">Ada isian yang perlu diperbaiki. Periksa pesan berwarna merah di bawah.</div><?php endif; ?>
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
</div>
<script src="<?php echo e(asset('js/admin.js')); ?>" defer></script>
</body>
</html>
<?php /**PATH C:\Users\ajmal\Downloads\portal-sdit-raudhatul-jannah (1)\portal-sdit-raudhatul-jannah\resources\views/layouts/admin.blade.php ENDPATH**/ ?>