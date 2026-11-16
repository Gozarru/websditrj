<?php $__env->startSection('title', 'Akun saya'); ?>
<?php $__env->startSection('content'); ?>
<h1>Akun saya</h1>
<p class="muted" style="margin-top:-8px">Peran: <span class="badge r-<?php echo e($user->role); ?>"><?php echo e($user->roleLabel()); ?></span></p>
<form class="card" method="POST" action="<?php echo e(route('admin.account.update')); ?>">
    <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
    <label for="name">Nama</label>
    <input id="name" type="text" name="name" value="<?php echo e(old('name', $user->name)); ?>" required>
    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="errs"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

    <label for="email">Email</label>
    <input id="email" type="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required>
    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="errs"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

    <b style="display:block;margin-top:22px">Ganti kata sandi <small class="muted">(kosongkan jika tidak diganti)</small></b>
    <label for="current_password">Kata sandi saat ini</label>
    <input id="current_password" type="password" name="current_password" autocomplete="current-password">
    <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="errs"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

    <label for="password">Kata sandi baru <small>(minimal 8 karakter)</small></label>
    <input id="password" type="password" name="password" autocomplete="new-password">
    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="errs"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

    <label for="password_confirmation">Ulangi kata sandi baru</label>
    <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password">

    <p><button class="btn" type="submit">Simpan</button></p>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ajmal\Downloads\portal-sdit-raudhatul-jannah\resources\views/admin/account/edit.blade.php ENDPATH**/ ?>