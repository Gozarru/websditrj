<div class="gal" data-gallery>
    <?php $__currentLoopData = $photos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ph): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <a href="<?php echo e(upload_url($ph->image)); ?>" data-lightbox data-caption="<?php echo e($ph->caption); ?>">
        <img src="<?php echo e(upload_url($ph->image)); ?>" alt="<?php echo e($ph->caption ?: 'Foto kegiatan sekolah'); ?>" loading="lazy">
        <?php if($ph->caption): ?><span><?php echo e($ph->caption); ?></span><?php endif; ?>
    </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php /**PATH C:\Users\ajmal\Downloads\portal-sdit-raudhatul-jannah\resources\views/partials/gallery.blade.php ENDPATH**/ ?>