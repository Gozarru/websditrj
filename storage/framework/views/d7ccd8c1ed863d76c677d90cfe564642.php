<?php $__env->startSection('content'); ?>
<?php
    $ht = trim(site('hero_title'));
    $hp = strrpos($ht, ' ');
    $htA = $hp !== false ? substr($ht, 0, $hp) : $ht;
    $htB = $hp !== false ? substr($ht, $hp + 1) : '';
    $featIcons = ['book', 'sparkle', 'users'];
?>

<section class="hero">
    <div class="hero-copy">
        <p class="eyebrow line"><?php echo e(site('hero_eyebrow')); ?></p>
        <h1><?php echo e($htA); ?> <?php if($htB): ?><span><?php echo e($htB); ?></span><?php endif; ?></h1>
        <p class="lead"><?php echo e(site('hero_text')); ?></p>
        <div class="cta">
            <a class="btn primary" href="<?php echo e(route('profil', 'profil')); ?>">Profil Sekolah<svg class="ic ar"><use href="#i-arrow"/></svg></a>
            <?php if(site('spmb_url')): ?><a class="btn outline" href="<?php echo e(site('spmb_url')); ?>" target="_blank" rel="noopener">Informasi SPMB<svg class="ic ne"><use href="#i-ne"/></svg></a><?php endif; ?>
        </div>
        <ul class="feats">
            <?php $__currentLoopData = site_lines('hero_features'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><svg class="ic"><use href="#i-<?php echo e($featIcons[$i % 3]); ?>"/></svg><?php echo e($f); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>

    <div class="slider" data-slider role="region" aria-roledescription="carousel" aria-label="Foto kegiatan sekolah">
        <div class="slides">
            <?php $__empty_1 = true; $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <figure class="slide <?php echo e($i === 0 ? 'on' : ''); ?>">
                <img src="<?php echo e($s['image']); ?>" alt="" <?php if($i > 0): ?> loading="lazy" <?php endif; ?>>
                <figcaption><?php echo e($s['caption']); ?></figcaption>
            </figure>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <figure class="slide art on"><figcaption><?php echo e(site('slide_1_caption')); ?></figcaption></figure>
            <?php endif; ?>
        </div>
        <?php if(site('spmb_year')): ?>
        <a class="badge-spmb" <?php if(site('spmb_url')): ?> href="<?php echo e(site('spmb_url')); ?>" target="_blank" rel="noopener" <?php else: ?> href="#spmb" <?php endif; ?>>
            <small>SPMB</small><b><?php echo e(site('spmb_year')); ?></b>
        </a>
        <?php endif; ?>
        <?php if(count($slides) > 1): ?>
        <div class="s-ctrl">
            <div class="dots" role="group" aria-label="Pilih foto">
                <?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><button type="button" class="dot-b <?php echo e($i === 0 ? 'on' : ''); ?>" data-go="<?php echo e($i); ?>" aria-label="Foto <?php echo e($i + 1); ?>"></button><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="arrows">
                <button type="button" data-prev aria-label="Foto sebelumnya"><svg class="ic"><use href="#i-left"/></svg></button>
                <button type="button" data-next aria-label="Foto berikutnya"><svg class="ic"><use href="#i-right"/></svg></button>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<section id="profil" class="sec"><div class="wrap about">
    <div>
        <p class="eyebrow line">Profil sekolah</p>
        <h2>Belajar, beribadah, dan bertumbuh dalam satu lingkungan</h2>
        <?php if(site('about_text')): ?><p class="lead2"><?php echo nl2br(e(site('about_text'))); ?></p><?php endif; ?>
        <?php if(site('about_text2')): ?><p class="mut"><?php echo nl2br(e(site('about_text2'))); ?></p><?php endif; ?>
        <a class="more" href="<?php echo e(route('profil', 'sejarah')); ?>">Baca sejarah singkat<svg class="ic ar"><use href="#i-arrow"/></svg></a>
    </div>
    <div class="vals">
        <?php $__currentLoopData = site_values(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="val"><b><?php echo e($v['title']); ?></b><span><?php echo e($v['desc']); ?></span></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div></section>

<?php if($posts->isNotEmpty()): ?>
<section id="berita" class="sec alt"><div class="wrap">
    <div class="sh row"><div><p class="eyebrow line">Informasi</p><h2>Berita terbaru</h2><p>Kabar kegiatan dan pengumuman dari sekolah.</p></div><a class="more" href="<?php echo e(route('posts.index')); ?>">Semua berita<svg class="ic ar"><use href="#i-arrow"/></svg></a></div>
    <div class="grid g3">
        <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a class="card post" href="<?php echo e(route('posts.show', $p->slug)); ?>">
            <div class="pic" <?php if($p->image): ?> style="background-image:url('<?php echo e(upload_url($p->image)); ?>')" <?php endif; ?>></div>
            <div class="in">
                <span class="date"><?php echo e($p->published_at?->translatedFormat('j F Y')); ?></span>
                <h3><?php echo e($p->title); ?></h3>
                <p><?php echo e($p->summary()); ?></p>
            </div>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div></section>
<?php endif; ?>

<?php if($announcements->isNotEmpty() || $agendas->isNotEmpty()): ?>
<section id="pengumuman" class="sec"><div class="wrap duo">
    <div>
        <div class="sh row"><div><p class="eyebrow line">Pengumuman</p><h2>Kabar penting</h2></div><a class="more" href="<?php echo e(route('pengumuman')); ?>">Semua<svg class="ic ar"><use href="#i-arrow"/></svg></a></div>
        <div class="alist">
            <?php $__empty_1 = true; $__currentLoopData = $announcements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <a class="card arow" href="<?php echo e(route('posts.show', $p->slug)); ?>">
                <span class="dbox"><b><?php echo e($p->published_at?->format('j')); ?></b><small><?php echo e($p->published_at?->translatedFormat('M Y')); ?></small></span>
                <span class="atxt"><h3><?php echo e($p->title); ?></h3></span>
                <svg class="ic ne"><use href="#i-ne"/></svg>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="empty">Belum ada pengumuman.</p>
            <?php endif; ?>
        </div>
    </div>
    <div>
        <div class="sh row"><div><p class="eyebrow line">Agenda</p><h2>Kegiatan mendatang</h2></div><a class="more" href="<?php echo e(route('agenda')); ?>">Semua<svg class="ic ar"><use href="#i-arrow"/></svg></a></div>
        <div class="alist">
            <?php $__empty_1 = true; $__currentLoopData = $agendas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php echo $__env->make('partials.agenda-row', ['a' => $a], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="empty">Belum ada agenda mendatang.</p>
            <?php endif; ?>
        </div>
    </div>
</div></section>
<?php endif; ?>

<?php if($achievements->isNotEmpty()): ?>
<section id="prestasi" class="sec"><div class="wrap">
    <div class="sh row"><div><p class="eyebrow line">Prestasi</p><h2>Capaian siswa dan sekolah</h2></div><a class="more" href="<?php echo e(route('prestasi')); ?>">Semua prestasi<svg class="ic ar"><use href="#i-arrow"/></svg></a></div>
    <?php echo $__env->make('partials.prestasi', ['achievements' => $achievements], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div></section>
<?php endif; ?>

<?php if($media->isNotEmpty()): ?>
<section id="media" class="sec alt"><div class="wrap">
    <div class="sh row"><div><p class="eyebrow line">Media belajar</p><h2>Belajar di rumah, per kelas</h2><p>Materi pendamping belajar peserta didik.</p></div><a class="more" href="<?php echo e(route('media')); ?>">Buka halaman media<svg class="ic ar"><use href="#i-arrow"/></svg></a></div>
    <?php $grades = collect(config('site.grades'))->filter(fn ($g) => $media->has($g))->values(); ?>
    <div class="tabs" role="group" aria-label="Pilih kelas">
        <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><button type="button" data-tab="<?php echo e($i); ?>" aria-pressed="<?php echo e($i === 0 ? 'true' : 'false'); ?>"><?php echo e($g); ?></button><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="grid g3 panel" data-panel="<?php echo e($i); ?>" <?php if($i !== 0): ?> hidden <?php endif; ?>>
        <?php $__currentLoopData = $media[$g]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('partials.media-card', ['m' => $m], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div></section>
<?php endif; ?>

<?php if($photos->isNotEmpty()): ?>
<section id="galeri" class="sec"><div class="wrap">
    <div class="sh row"><div><p class="eyebrow line">Galeri</p><h2>Galeri kegiatan</h2></div><a class="more" href="<?php echo e(route('galeri')); ?>">Semua foto<svg class="ic ar"><use href="#i-arrow"/></svg></a></div>
    <?php echo $__env->make('partials.gallery', ['photos' => $photos], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div></section>
<?php endif; ?>

<?php if(site('spmb_url')): ?>
<section id="spmb" class="sec"><div class="wrap"><div class="band">
    <div><h2>Pendaftaran murid baru</h2><p>Daftar, unggah berkas, dan pantau status pendaftaran dari satu dasbor wali.</p></div>
    <a class="btn gold" href="<?php echo e(site('spmb_url')); ?>" target="_blank" rel="noopener"><?php echo e(site('spmb_button') ?: 'Daftar Sekarang'); ?><svg class="ic ne"><use href="#i-ne"/></svg></a>
</div></div></section>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ajmal\Downloads\portal-sdit-raudhatul-jannah\resources\views/home.blade.php ENDPATH**/ ?>