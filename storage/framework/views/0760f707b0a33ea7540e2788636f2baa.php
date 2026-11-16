<?php $__env->startSection('title', 'Pengaturan situs'); ?>
<?php $__env->startSection('content'); ?>
<h1>Pengaturan situs</h1>
<form method="POST" enctype="multipart/form-data" action="<?php echo e(route('admin.settings.update')); ?>">
    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
    <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $fields): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="card">
        <b><?php echo e($group); ?></b>
        <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $k = $f['key']; $val = old($k, site($k)); ?>
            <label for="<?php echo e($k); ?>"><?php echo e($f['label']); ?></label>
            <?php if($f['type'] === 'textarea'): ?>
                <textarea id="<?php echo e($k); ?>" name="<?php echo e($k); ?>"><?php echo e($val); ?></textarea>
            <?php elseif($f['type'] === 'image'): ?>
                <input id="<?php echo e($k); ?>" type="file" name="<?php echo e($k); ?>" accept="image/jpeg,image/png,image/webp">
                <?php if(site($k)): ?>
                    <img class="prev" src="<?php echo e(upload_url(site($k))); ?>" alt="">
                    <label class="chk"><input type="checkbox" name="remove_<?php echo e($k); ?>" value="1"> Hapus gambar ini</label>
                <?php endif; ?>
            <?php else: ?>
                <input id="<?php echo e($k); ?>" type="<?php echo e($f['type'] === 'url' ? 'url' : 'text'); ?>" name="<?php echo e($k); ?>" value="<?php echo e($val); ?>">
            <?php endif; ?>
            <?php $__errorArgs = [$k];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="errs"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <p><button class="btn" type="submit">Simpan pengaturan</button></p>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ajmal\Downloads\portal-sdit-raudhatul-jannah (1)\portal-sdit-raudhatul-jannah\resources\views/admin/settings/edit.blade.php ENDPATH**/ ?>