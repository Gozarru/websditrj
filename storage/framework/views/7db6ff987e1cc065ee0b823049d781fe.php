<?php $__env->startSection('title', 'Prestasi'); ?>
<?php $__env->startSection('content'); ?>
<div class="bar"><h1>Prestasi</h1><a class="btn" href="<?php echo e(route('admin.achievements.create')); ?>">Tambah prestasi</a></div>
<div class="card">
<table>
    <tr><th>Tahun</th><th>Prestasi</th><th>Tingkat</th><th></th></tr>
    <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr>
        <td><?php echo e($i->year); ?></td><td><?php echo e($i->title); ?></td><td><?php echo e($i->level); ?></td>
        <td class="act">
            <a class="btn sec sm" href="<?php echo e(route('admin.achievements.edit', $i)); ?>">Ubah</a>
            <form method="POST" action="<?php echo e(route('admin.achievements.destroy', $i)); ?>" onsubmit="return confirm('Hapus prestasi ini?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="btn del sm">Hapus</button></form>
        </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr><td colspan="4" class="muted">Belum ada prestasi.</td></tr>
    <?php endif; ?>
</table>
<div class="pager"><span><?php if($items->previousPageUrl()): ?><a href="<?php echo e($items->previousPageUrl()); ?>">Sebelumnya</a><?php endif; ?></span><span><?php if($items->nextPageUrl()): ?><a href="<?php echo e($items->nextPageUrl()); ?>">Berikutnya</a><?php endif; ?></span></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ajmal\Downloads\portal-sdit-raudhatul-jannah\resources\views/admin/achievements/index.blade.php ENDPATH**/ ?>