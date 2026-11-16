<section class="phero"><div class="wrap">
    <nav class="crumbs" aria-label="Breadcrumb">
        <a href="<?php echo e(route('home')); ?>">Beranda</a>
        <?php $__currentLoopData = $crumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <svg class="ic"><use href="#i-right"/></svg>
            <?php if($url): ?><a href="<?php echo e($url); ?>"><?php echo e($label); ?></a><?php else: ?><span aria-current="page"><?php echo e($label); ?></span><?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </nav>
    <p class="eyebrow"><?php echo e($eyebrow); ?></p>
    <h1><?php echo e($title); ?></h1>
    <?php if(!empty($subtitle)): ?><p class="sub"><?php echo e($subtitle); ?></p><?php endif; ?>
</div></section>
<?php /**PATH C:\Users\ajmal\Downloads\portal-sdit-raudhatul-jannah\resources\views/partials/pagehero.blade.php ENDPATH**/ ?>