<?php $__env->startSection('title', $item->exists ? 'Ubah media' : 'Tambah media'); ?>
<?php $__env->startSection('content'); ?>
<h1><?php echo e($item->exists ? 'Ubah media belajar' : 'Tambah media belajar'); ?></h1>
<form class="card" method="POST" action="<?php echo e($item->exists ? route('admin.media.update', $item) : route('admin.media.store')); ?>">
    <?php echo csrf_field(); ?> <?php if($item->exists): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>
    <label for="title">Judul</label>
    <input id="title" type="text" name="title" value="<?php echo e(old('title', $item->title)); ?>" required>
    <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="errs"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

    <div class="row2">
        <div>
            <label for="grade">Kelas</label>
            <select id="grade" name="grade">
                <?php $__currentLoopData = config('site.grades'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($g); ?>" <?php echo e(old('grade', $item->grade) === $g ? 'selected' : ''); ?>><?php echo e($g); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['grade'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="errs"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
            <label for="type">Jenis</label>
            <select id="type" name="type">
                <?php $__currentLoopData = config('site.media_types'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($t); ?>" <?php echo e(old('type', $item->type) === $t ? 'selected' : ''); ?>><?php echo e($t); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="errs"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>

    <label for="url">Tautan materi <small>(YouTube, Google Drive, dan sebagainya)</small></label>
    <input id="url" type="url" name="url" value="<?php echo e(old('url', $item->url)); ?>" placeholder="https://" required>
    <?php $__errorArgs = ['url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="errs"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

    <label for="description">Keterangan <small>(opsional)</small></label>
    <textarea id="description" name="description" style="min-height:80px"><?php echo e(old('description', $item->description)); ?></textarea>
    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="errs"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

    <p><button class="btn" type="submit">Simpan</button> <a class="btn sec" href="<?php echo e(route('admin.media.index')); ?>">Batal</a></p>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ajmal\Downloads\portal-sdit-raudhatul-jannah\resources\views/admin/media/form.blade.php ENDPATH**/ ?>