<?php $__env->startSection('title', 'Galeri'); ?>
<?php $__env->startSection('content'); ?>
<h1>Galeri</h1>
<form class="card" method="POST" enctype="multipart/form-data" action="<?php echo e(route('admin.gallery.store')); ?>">
    <?php echo csrf_field(); ?>
    <b>Tambah foto</b>
    <label for="photos">Pilih foto <small>(bisa banyak sekaligus, maks 20 foto, 5 MB per foto)</small></label>
    <input id="photos" type="file" name="photos[]" accept="image/jpeg,image/png,image/webp" multiple required>
    <?php $__errorArgs = ['photos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="errs"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    <?php $__errorArgs = ['photos.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="errs"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    <label for="caption">Keterangan <small>(opsional, dipakai untuk semua foto yang dipilih)</small></label>
    <input id="caption" type="text" name="caption" value="<?php echo e(old('caption')); ?>">
    <p><button class="btn" type="submit">Unggah</button></p>
</form>

<div class="gal">
    <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="it">
        <img src="<?php echo e(upload_url($i->image)); ?>" alt="<?php echo e($i->caption); ?>" loading="lazy">
        <form method="POST" action="<?php echo e(route('admin.gallery.update', $i)); ?>"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <input type="text" name="caption" value="<?php echo e($i->caption); ?>" placeholder="Keterangan" aria-label="Keterangan foto">
            <button class="btn sec sm">Simpan</button>
        </form>
        <form method="POST" action="<?php echo e(route('admin.gallery.destroy', $i)); ?>" data-confirm="Hapus foto ini?"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="btn del sm">Hapus foto</button></form>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p class="muted">Belum ada foto.</p>
    <?php endif; ?>
</div>
<div class="pager"><span><?php if($items->previousPageUrl()): ?><a href="<?php echo e($items->previousPageUrl()); ?>">Sebelumnya</a><?php endif; ?></span><span><?php if($items->nextPageUrl()): ?><a href="<?php echo e($items->nextPageUrl()); ?>">Berikutnya</a><?php endif; ?></span></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ajmal\Downloads\portal-sdit-raudhatul-jannah\resources\views/admin/gallery/index.blade.php ENDPATH**/ ?>