<?php $__env->startSection('title', $item->exists ? 'Ubah tulisan' : 'Tulisan baru'); ?>
<?php $__env->startSection('content'); ?>
<div class="bar"><h1><?php echo e($item->exists ? 'Ubah tulisan' : 'Tulisan baru'); ?></h1><?php if($item->exists): ?><a class="btn sec" href="<?php echo e(route('admin.posts.show', $item)); ?>">← Kembali</a><?php endif; ?></div>
<div class="<?php echo e($item->exists ? 'grid2' : ''); ?>">
<form class="card" method="POST" enctype="multipart/form-data" action="<?php echo e($item->exists ? route('admin.posts.update', $item) : route('admin.posts.store')); ?>">
    <?php echo csrf_field(); ?> <?php if($item->exists): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

    <label>Jenis</label>
    <div class="type-pick">
        <?php $__currentLoopData = \App\Models\Post::TYPES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <label><input type="radio" name="type" value="<?php echo e($k); ?>" <?php echo e(old('type', $item->type) === $k ? 'checked' : ''); ?>> <?php echo e($v); ?></label>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="errs"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

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

    <label for="excerpt">Ringkasan <small>(opsional, tampil di daftar)</small></label>
    <textarea id="excerpt" name="excerpt" style="min-height:70px"><?php echo e(old('excerpt', $item->excerpt)); ?></textarea>
    <?php $__errorArgs = ['excerpt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="errs"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

    <label for="body">Isi</label>
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
            <label for="published_at">Jadwal tayang <small>(opsional)</small></label>
            <input id="published_at" type="datetime-local" name="published_at" value="<?php echo e(old('published_at', $item->published_at?->format('Y-m-d\TH:i'))); ?>">
            <p class="help">Jika diisi tanggal &amp; jam mendatang, tulisan tayang otomatis pada waktu itu setelah disetujui dan diterbitkan.</p>
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

    <?php if($item->exists && in_array($item->status, ['checked', 'approved'])): ?>
        <div class="note" style="margin-top:16px">Tulisan ini sudah <?php echo e($item->status === 'approved' ? 'disetujui' : 'diperiksa'); ?>. Jika isinya diubah, tulisan kembali ke tahap pemeriksaan.</div>
    <?php endif; ?>

    <p style="display:flex;gap:8px;flex-wrap:wrap;margin-top:18px">
        <button class="btn" type="submit" data-multi>Simpan</button>
        <?php if(! $item->exists || $item->status === 'draft'): ?>
            <button class="btn gold" type="submit" name="submit_after" value="1">Simpan &amp; ajukan untuk diperiksa</button>
        <?php endif; ?>
        <a class="btn sec" href="<?php echo e($item->exists ? route('admin.posts.show', $item) : route('admin.posts.index')); ?>">Batal</a>
    </p>
</form>
<?php if($item->exists): ?><div><?php echo $__env->make('admin.posts._panel', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></div><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ajmal\Downloads\portal-sdit-raudhatul-jannah (1)\portal-sdit-raudhatul-jannah\resources\views/admin/posts/form.blade.php ENDPATH**/ ?>