<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex">
<title>Masuk admin — <?php echo e(site('school_name')); ?></title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo e(asset('css/admin.css')); ?>">
</head>
<body>
<div class="login">
    <div class="login-brand"><span class="sb-logo">RJ</span><div><h1>Masuk admin</h1><span class="muted"><?php echo e(site('school_name')); ?></span></div></div>
    <form class="card" method="POST" action="<?php echo e(route('login')); ?>">
        <?php echo csrf_field(); ?>
        <label for="email">Email</label>
        <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus autocomplete="username">
        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="errs"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <label for="password">Kata sandi</label>
        <input id="password" type="password" name="password" required autocomplete="current-password">
        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="errs"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <label class="chk"><input type="checkbox" name="remember" value="1"> Ingat saya di perangkat ini</label>
        <p><button class="btn" type="submit">Masuk</button></p>
    </form>
    <p><a href="<?php echo e(route('home')); ?>">Kembali ke website</a></p>
</div>
</body>
</html>
<?php /**PATH C:\Users\ajmal\Downloads\portal-sdit-raudhatul-jannah (1)\portal-sdit-raudhatul-jannah\resources\views/auth/login.blade.php ENDPATH**/ ?>