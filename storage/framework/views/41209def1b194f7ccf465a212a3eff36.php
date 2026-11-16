<?php $__env->startSection('title', $title.' — '.site('school_name')); ?>
<?php $__env->startSection('description', $intro); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('partials.pagehero', ['crumbs' => ['Profil Sekolah' => null, $title => null], 'eyebrow' => 'Profil Sekolah', 'title' => $title, 'subtitle' => $intro], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<section class="sec"><div class="wrap side-layout">
    <?php
        $menuItems = [];
        foreach ($pages as $s => $p) { $menuItems[] = ['label' => $p[0], 'url' => route('profil', $s), 'on' => $s === $slug]; }
    ?>
    <?php echo $__env->make('partials.side', ['label' => 'Menu profil', 'items' => $menuItems], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="prose">
        <?php echo rich_text($body); ?>

        <?php if($slug === 'peta-lokasi' && site('address')): ?>
            <div class="map"><iframe title="Peta lokasi sekolah" src="https://www.google.com/maps?q=<?php echo e(urlencode(site('school_name').' '.site('address'))); ?>&amp;output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe></div>
            <p><a class="more" target="_blank" rel="noopener" href="https://www.google.com/maps/search/?api=1&amp;query=<?php echo e(urlencode(site('school_name').' '.site('address'))); ?>">Buka di Google Maps<svg class="ic ne"><use href="#i-ne"/></svg></a></p>
        <?php endif; ?>
    </div>
</div></section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ajmal\Downloads\portal-sdit-raudhatul-jannah (1)\portal-sdit-raudhatul-jannah\resources\views/pages/profil.blade.php ENDPATH**/ ?>