<?php $__env->startSection('title', $item->exists ? 'Ubah berita' : 'Tambah berita'); ?>
<?php $__env->startSection('content'); ?>
<h1><?php echo e($item->exists ? 'Ubah berita' : 'Tambah berita'); ?></h1>
<form class="card" method="POST" enctype="multipart/form-data" action="<?php echo e($item->exists ? route('admin.posts.update', $item) : route('admin.posts.store')); ?>">
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

    <label for="excerpt">Ringkasan <small>(opsional, tampil di daftar berita)</small></label>
    <textarea id="excerpt" name="excerpt" style="min-height:70px"><?php echo e(old('excerpt', $item->excerpt)); ?></textarea>
    <?php $__errorArgs = ['excerpt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="errs"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

    <label for="body">Isi berita</label>
    <textarea id="body" name="body" style="min-height:240px" required><?php echo e(old('body', $item->body)); ?></textarea>
    <?php $__errorArgs = ['body'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="errs"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

    <div class="row2">
        <div>
            <label for="published_at">Tanggal terbit</label>
            <input id="published_at" type="date" name="published_at" value="<?php echo e(old('published_at', $item->published_at?->format('Y-m-d'))); ?>">
            <?php $__errorArgs = ['published_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="errs"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
            <label for="image">Foto <small>(JPG, PNG, WEBP, maks 5 MB)</small></label>
            <input id="image" type="file" name="image" accept="image/jpeg,image/png,image/webp">
            <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="errs"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>
    <?php if($item->image): ?>
        <img class="prev" src="<?php echo e(upload_url($item->image)); ?>" alt="">
        <label class="chk"><input type="checkbox" name="remove_image" value="1"> Hapus foto ini</label>
    <?php endif; ?>

    <input type="hidden" name="is_published" value="0">
    <label class="chk"><input type="checkbox" name="is_published" value="1" <?php echo e(old('is_published', $item->is_published ? '1' : null) ? 'checked' : ''); ?>> Tayangkan di website</label>

    <p><button class="btn" type="submit">Simpan</button> <a class="btn sec" href="<?php echo e(route('admin.posts.index')); ?>">Batal</a></p>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ajmal\Downloads\portal-sdit-raudhatul-jannah\resources\views/admin/posts/form.blade.php ENDPATH**/ ?>