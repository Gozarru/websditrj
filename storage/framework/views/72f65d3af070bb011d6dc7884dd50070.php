<?php $__env->startSection('title', 'Media Belajar '.$current.' — '.site('school_name')); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('partials.pagehero', ['crumbs' => ['Media Belajar' => null, $current => null], 'eyebrow' => 'Media Belajar', 'title' => $current, 'subtitle' => 'Materi pendamping belajar di rumah untuk peserta didik.'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<section class="sec"><div class="wrap side-layout">
    <?php
        $menuItems = [];
        foreach ($grades as $g) { $menuItems[] = ['label' => $g, 'url' => route('media', grade_slug($g)), 'on' => $g === $current, 'count' => $counts[$g] ?? 0]; }
    ?>
    <?php echo $__env->make('partials.side', ['label' => 'Pilih kelas', 'items' => $menuItems], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div>
        <div class="grid g2">
            <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php echo $__env->make('partials.media-card', ['m' => $m], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="empty">Belum ada media belajar untuk <?php echo e($current); ?>.</p>
            <?php endif; ?>
        </div>
    </div>
</div></section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ajmal\Downloads\portal-sdit-raudhatul-jannah\resources\views/pages/media.blade.php ENDPATH**/ ?>