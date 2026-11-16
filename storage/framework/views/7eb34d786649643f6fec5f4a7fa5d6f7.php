<?php $__env->startSection('title', 'Berita & Pengumuman'); ?>
<?php $__env->startSection('content'); ?>
<?php $me = auth()->user(); ?>
<div class="bar">
    <h1>Berita &amp; Pengumuman</h1>
    <?php if($me->can('posts.write')): ?>
    <div style="display:flex;gap:8px;flex-wrap:wrap">
        <a class="btn" href="<?php echo e(route('admin.posts.create')); ?>">+ Berita</a>
        <a class="btn sec" href="<?php echo e(route('admin.posts.create', ['type' => 'pengumuman'])); ?>">+ Pengumuman</a>
    </div>
    <?php endif; ?>
</div>

<div class="tabs" role="navigation" aria-label="Filter status">
    <a href="<?php echo e(route('admin.posts.index', request()->except('status', 'page'))); ?>" class="<?php echo e(request('status') ? '' : 'on'); ?>">Semua<small><?php echo e($total); ?></small></a>
    <?php $__currentLoopData = \App\Models\Post::STATUSES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('admin.posts.index', ['status' => $k] + request()->except('status', 'page'))); ?>" class="<?php echo e(request('status') === $k ? 'on' : ''); ?>"><?php echo e($label); ?><small><?php echo e($counts[$k] ?? 0); ?></small></a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<form class="filters" method="GET" action="<?php echo e(route('admin.posts.index')); ?>">
    <?php if(request('status')): ?><input type="hidden" name="status" value="<?php echo e(request('status')); ?>"><?php endif; ?>
    <div><label for="q">Cari judul</label><input id="q" type="search" name="q" value="<?php echo e(request('q')); ?>" placeholder="Ketik judul…"></div>
    <div><label for="type">Jenis</label>
        <select id="type" name="type"><option value="">Semua jenis</option><?php $__currentLoopData = \App\Models\Post::TYPES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($k); ?>" <?php if(request('type') === $k): echo 'selected'; endif; ?>><?php echo e($v); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
    </div>
    <button class="btn sec go" type="submit">Terapkan</button>
</form>

<div class="card">
<table class="resp">
    <thead><tr><th></th><th>Judul</th><th>Penulis</th><th>Status</th><th>Diperbarui</th><th></th></tr></thead>
    <tbody>
    <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <tr>
        <td><?php if($i->image): ?><img class="thumb" src="<?php echo e(upload_url($i->image)); ?>" alt=""><?php endif; ?></td>
        <td data-label="Judul"><span class="tt"><a href="<?php echo e(route('admin.posts.show', $i)); ?>"><b><?php echo e($i->title); ?></b></a><br><small class="muted"><?php echo e($i->typeLabel()); ?><?php if($i->status === 'scheduled' && $i->published_at): ?> · tayang <?php echo e($i->published_at->translatedFormat('j M Y H:i')); ?><?php endif; ?></small></span></td>
        <td data-label="Penulis"><?php echo e($i->author?->name ?? '—'); ?></td>
        <td data-label="Status"><span class="badge s-<?php echo e($i->status); ?>"><?php echo e($i->statusLabel()); ?></span></td>
        <td data-label="Diperbarui"><?php echo e($i->updated_at->translatedFormat('j M Y')); ?></td>
        <td class="act">
            <a class="btn sec sm" href="<?php echo e(route('admin.posts.show', $i)); ?>">Buka</a>
            <?php if(\App\Support\PostWorkflow::canEdit($i, $me)): ?><a class="btn sec sm" href="<?php echo e(route('admin.posts.edit', $i)); ?>">Ubah</a><?php endif; ?>
            <?php if(\App\Support\PostWorkflow::canDelete($i, $me)): ?>
            <form method="POST" action="<?php echo e(route('admin.posts.destroy', $i)); ?>" data-confirm="Hapus tulisan ini?"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="btn del sm">Hapus</button></form>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr><td colspan="6" class="muted">Belum ada tulisan.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
<div class="pager"><span><?php if($items->previousPageUrl()): ?><a href="<?php echo e($items->previousPageUrl()); ?>">← Sebelumnya</a><?php endif; ?></span><span><?php if($items->nextPageUrl()): ?><a href="<?php echo e($items->nextPageUrl()); ?>">Berikutnya →</a><?php endif; ?></span></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ajmal\Downloads\portal-sdit-raudhatul-jannah (1)\portal-sdit-raudhatul-jannah\resources\views/admin/posts/index.blade.php ENDPATH**/ ?>