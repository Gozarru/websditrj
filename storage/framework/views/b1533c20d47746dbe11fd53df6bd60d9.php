<?php $__env->startSection('title', 'Agenda'); ?>
<?php $__env->startSection('content'); ?>
<div class="bar"><h1>Agenda</h1><a class="btn" href="<?php echo e(route('admin.agendas.create')); ?>">+ Agenda</a></div>
<div class="card">
<table class="resp">
    <thead><tr><th>Tanggal</th><th>Agenda</th><th>Tempat</th><th></th></tr></thead>
    <tbody>
    <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr>
        <td data-label="Tanggal"><?php echo e($i->dateLabel()); ?></td>
        <td data-label="Agenda"><span class="tt"><b><?php echo e($i->title); ?></b><?php if($i->time_text): ?><br><small class="muted"><?php echo e($i->time_text); ?></small><?php endif; ?></span></td>
        <td data-label="Tempat"><?php echo e($i->location ?: '—'); ?></td>
        <td class="act">
            <a class="btn sec sm" href="<?php echo e(route('admin.agendas.edit', $i)); ?>">Ubah</a>
            <form method="POST" action="<?php echo e(route('admin.agendas.destroy', $i)); ?>" data-confirm="Hapus agenda ini?"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="btn del sm">Hapus</button></form>
        </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr><td colspan="4" class="muted">Belum ada agenda.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
<div class="pager"><span><?php if($items->previousPageUrl()): ?><a href="<?php echo e($items->previousPageUrl()); ?>">← Sebelumnya</a><?php endif; ?></span><span><?php if($items->nextPageUrl()): ?><a href="<?php echo e($items->nextPageUrl()); ?>">Berikutnya →</a><?php endif; ?></span></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ajmal\Downloads\portal-sdit-raudhatul-jannah (1)\portal-sdit-raudhatul-jannah\resources\views/admin/agendas/index.blade.php ENDPATH**/ ?>