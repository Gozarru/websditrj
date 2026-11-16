<?php $__env->startSection('title', 'Berita Sekolah — '.site('school_name')); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('partials.pagehero', ['crumbs' => ['Informasi' => null, 'Berita Sekolah' => null], 'eyebrow' => 'Informasi', 'title' => 'Berita Sekolah', 'subtitle' => 'Informasi resmi sekolah yang diperbarui secara berkala oleh pengelola website.'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<section class="sec"><div class="wrap">
    <div class="grid g3">
        <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <a class="card post" href="<?php echo e(route('posts.show', $p->slug)); ?>">
            <div class="pic" <?php if($p->image): ?> style="background-image:url('<?php echo e(upload_url($p->image)); ?>')" <?php endif; ?>></div>
            <div class="in">
                <span class="date"><?php echo e($p->published_at?->translatedFormat('j F Y')); ?></span>
                <h3><?php echo e($p->title); ?></h3>
                <p><?php echo e($p->summary()); ?></p>
            </div>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="empty">Belum ada berita.</p>
        <?php endif; ?>
    </div>
    <div class="pager">
        <span><?php if($posts->previousPageUrl()): ?><a class="more" href="<?php echo e($posts->previousPageUrl()); ?>"><svg class="ic" style="transform:scaleX(-1)"><use href="#i-arrow"/></svg>Sebelumnya</a><?php endif; ?></span>
        <span><?php if($posts->nextPageUrl()): ?><a class="more" href="<?php echo e($posts->nextPageUrl()); ?>">Berikutnya<svg class="ic ar"><use href="#i-arrow"/></svg></a><?php endif; ?></span>
    </div>
</div></section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ajmal\Downloads\portal-sdit-raudhatul-jannah\resources\views/posts/index.blade.php ENDPATH**/ ?>