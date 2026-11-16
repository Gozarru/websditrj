<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $__env->yieldContent('title', site('school_name').' — Sekolah Dasar Islam Terpadu'); ?></title>
<meta name="description" content="<?php echo $__env->yieldContent('description', 'Website resmi '.site('school_name').'. Informasi profil sekolah, berita, prestasi, media belajar, galeri kegiatan, dan pendaftaran murid baru (SPMB).'); ?>">
<meta name="theme-color" content="#04503C">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo e(asset('css/site.css')); ?>">
</head>
<body>
<?php echo $__env->make('partials.icons', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php
    $socials = array_filter(['Instagram' => site('instagram'), 'YouTube' => site('youtube'), 'Facebook' => site('facebook')]);
    $bn = trim(site('school_name'));
    $bp = strrpos($bn, ' ');
    $brandA = $bp !== false ? substr($bn, 0, $bp) : $bn;
    $brandB = $bp !== false ? substr($bn, $bp + 1) : '';
?>

<div class="topbar"><div class="wrap">
    <?php
        $tbText = trim((string) site('topbar_text'));
        $tbWidth = mb_strlen($tbText) * 8 + 90;               // perkiraan lebar satu teks + jarak (px)
        $tbRep = max(2, (int) ceil(1500 / max(80, $tbWidth))); // ulangi agar selalu lebih lebar dari layar
        $tbDur = max(20, (int) round($tbRep * $tbWidth / 70)); // kecepatan sekitar 70 px/detik
    ?>
    <div class="tb-note">
        <i class="dot"></i>
        <?php if($tbText !== ''): ?>
        <span class="sr"><?php echo e($tbText); ?></span>
        <div class="tb-marquee" aria-hidden="true" style="--tb-dur: <?php echo e($tbDur); ?>s">
            <div class="tb-track">
                <span class="tb-group"><?php for($i = 0; $i < $tbRep; $i++): ?><span class="tb-item"><?php echo e($tbText); ?></span><?php endfor; ?></span>
                <span class="tb-group"><?php for($i = 0; $i < $tbRep; $i++): ?><span class="tb-item"><?php echo e($tbText); ?></span><?php endfor; ?></span>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <div class="tb-links">
        <a href="<?php echo e(route('kontak')); ?>">Hubungi Kami</a>
        <span class="sep"></span>
        <?php if($socials): ?>
            <?php $__currentLoopData = $socials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><a class="soft" href="<?php echo e($url); ?>" target="_blank" rel="noopener"><?php echo e($label); ?></a><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <span class="soft">Media sosial belum diatur</span>
        <?php endif; ?>
    </div>
</div></div>

<header class="site-header" id="top"><div class="wrap hdr">
    <a class="brand" href="<?php echo e(route('home')); ?>" aria-label="<?php echo e(site('school_name')); ?> — beranda">
        <span class="logo"><?php if(site('logo')): ?><img src="<?php echo e(upload_url(site('logo'))); ?>" alt=""><?php else: ?><svg class="ic"><use href="#i-shield"/></svg><?php endif; ?></span>
        <span class="bt"><b><?php echo e($brandA); ?></b><?php if($brandB): ?><small><?php echo e($brandB); ?></small><?php endif; ?></span>
    </a>
    <button class="burger" type="button" aria-expanded="false" aria-controls="menu" data-burger>
        <svg class="ic o"><use href="#i-menu"/></svg><svg class="ic x"><use href="#i-close"/></svg><span class="sr">Menu</span>
    </button>
    <nav class="nav" id="menu" aria-label="Menu utama">
        <?php $__currentLoopData = site_menu(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(isset($m['children'])): ?>
            <div class="dd <?php echo e(!empty($m['active']) ? 'on' : ''); ?>">
                <button class="nl" type="button" aria-expanded="false" aria-haspopup="true"><?php echo e($m['label']); ?><svg class="ic chev"><use href="#i-chev"/></svg></button>
                <div class="dd-panel">
                    <?php $__currentLoopData = $m['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e($c['url']); ?>" <?php if(!empty($c['external'])): ?> target="_blank" rel="noopener" <?php endif; ?>><span><?php echo e($c['label']); ?></span><svg class="ic ne"><use href="#i-ne"/></svg></a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php else: ?>
                <a class="nl <?php echo e(!empty($m['active']) ? 'on' : ''); ?>" href="<?php echo e($m['url']); ?>" <?php if(!empty($m['external'])): ?> target="_blank" rel="noopener" <?php endif; ?>><?php echo e($m['label']); ?></a>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php if(site('spmb_url')): ?>
            <a class="btn gold nav-cta" href="<?php echo e(site('spmb_url')); ?>" target="_blank" rel="noopener"><?php echo e(site('spmb_button') ?: 'Daftar Sekarang'); ?><svg class="ic ne"><use href="#i-ne"/></svg></a>
        <?php endif; ?>
    </nav>
</div></header>

<main><?php echo $__env->yieldContent('content'); ?></main>

<footer><div class="wrap fgrid">
    <div class="fcol fbrand">
        <b><?php echo e(site('school_name')); ?></b>
        <?php if(site('foundation_name')): ?><p><?php echo e(site('foundation_name')); ?></p><?php endif; ?>
        <p>Membangun generasi Qur’ani, berilmu, dan berakhlak mulia.</p>
    </div>
    <div class="fcol">
        <h4>Profil Sekolah</h4>
        <a href="<?php echo e(route('profil', 'sejarah')); ?>">Sejarah Singkat</a>
        <a href="<?php echo e(route('profil', 'visi-misi')); ?>">Visi, Misi &amp; Tujuan</a>
        <a href="<?php echo e(route('profil', 'peta-lokasi')); ?>">Peta Lokasi</a>
        <a href="<?php echo e(route('posts.index')); ?>">Berita Sekolah</a>
    </div>
    <div class="fcol">
        <h4>Kontak</h4>
        <?php if(site('address')): ?><p><?php echo nl2br(e(site('address'))); ?></p><?php endif; ?>
        <?php if(site('phone')): ?><p>Telepon: <a href="tel:<?php echo e(preg_replace('/[^\d+]/', '', site('phone'))); ?>"><?php echo e(site('phone')); ?></a></p><?php endif; ?>
        <?php if(wa_link(site('whatsapp'))): ?><p>WhatsApp: <a href="<?php echo e(wa_link(site('whatsapp'))); ?>" target="_blank" rel="noopener"><?php echo e(site('whatsapp')); ?></a></p><?php endif; ?>
        <?php if(site('email')): ?><p>Email: <a href="mailto:<?php echo e(site('email')); ?>"><?php echo e(site('email')); ?></a></p><?php endif; ?>
        <?php $__currentLoopData = $socials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><a href="<?php echo e($url); ?>" target="_blank" rel="noopener"><?php echo e($label); ?></a><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<div class="wrap fbottom"><span>© <?php echo e(date('Y')); ?> <?php echo e(site('school_name')); ?></span><a href="<?php echo e(route('login')); ?>">Masuk admin</a></div>
</footer>

<script src="<?php echo e(asset('js/site.js')); ?>" defer></script>
</body>
</html>
<?php /**PATH C:\Users\ajmal\Downloads\portal-sdit-raudhatul-jannah (1)\portal-sdit-raudhatul-jannah\resources\views/layouts/site.blade.php ENDPATH**/ ?>