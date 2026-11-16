<aside class="side">
    <p class="side-label"><?php echo e($label); ?></p>
    <nav aria-label="<?php echo e($label); ?>">
        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e($it['url']); ?>" class="<?php echo e($it['on'] ? 'on' : ''); ?>" <?php if($it['on']): ?> aria-current="page" <?php endif; ?>>
                <span><?php echo e($it['label']); ?></span>
                <?php if(isset($it['count'])): ?><small><?php echo e($it['count']); ?></small><?php endif; ?>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </nav>
</aside>
<?php /**PATH C:\Users\ajmal\Downloads\portal-sdit-raudhatul-jannah\resources\views/partials/side.blade.php ENDPATH**/ ?>