<?php $__env->startSection('title', $item->exists ? 'Ubah menu' : 'Tambah menu'); ?>
<?php $__env->startSection('content'); ?>
<?php
    $type = old('link_type', $item->link_type ?: 'page');
    $parentId = old('parent_id', $item->parent_id);
?>
<h1><?php echo e($item->exists ? 'Ubah menu' : 'Tambah menu'); ?></h1>
<form class="card" method="POST" action="<?php echo e($item->exists ? route('admin.menu.update', $item) : route('admin.menu.store')); ?>">
    <?php echo csrf_field(); ?> <?php if($item->exists): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

    <div class="row2">
        <div>
            <label for="label">Nama menu <small>(yang tampil di website)</small></label>
            <input id="label" type="text" name="label" value="<?php echo e(old('label', $item->label)); ?>" maxlength="60" required>
            <?php $__errorArgs = ['label'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="errs"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div>
            <label for="parent_id">Letak menu</label>
            <?php if($hasChildren): ?>
                <select id="parent_id" disabled><option>Menu utama (baris atas)</option></select>
                <p class="help">Menu ini punya submenu, jadi tetap menjadi menu utama.</p>
            <?php else: ?>
                <select id="parent_id" name="parent_id">
                    <option value="">Menu utama (baris atas)</option>
                    <?php $__currentLoopData = $parents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($p->id); ?>" <?php if((string) $parentId === (string) $p->id): echo 'selected'; endif; ?>>Submenu di dalam “<?php echo e($p->label); ?>”</option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            <?php endif; ?>
            <?php $__errorArgs = ['parent_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="errs"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    </div>

    <label>Jenis tautan</label>
    <div class="type-pick">
        <label><input type="radio" name="link_type" value="page" <?php if($type === 'page'): echo 'checked'; endif; ?>> Halaman di situs ini</label>
        <label><input type="radio" name="link_type" value="url" <?php if($type === 'url'): echo 'checked'; endif; ?>> Alamat lain (URL)</label>
        <label><input type="radio" name="link_type" value="none" <?php if($type === 'none'): echo 'checked'; endif; ?>> Tanpa tautan (judul dropdown)</label>
    </div>
    <?php $__errorArgs = ['link_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="errs"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    <?php if($hasChildren): ?><p class="help">Karena menu ini punya submenu, di website ia tampil sebagai dropdown dan tautannya sendiri tidak dipakai.</p><?php endif; ?>

    <div data-link="page">
        <label for="page">Halaman tujuan</label>
        <select id="page" name="page">
            <option value="">— Pilih halaman —</option>
            <?php $__currentLoopData = $pageGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $pages): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <optgroup label="<?php echo e($group); ?>">
                    <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($key); ?>" <?php if(old('page', $item->page) === $key): echo 'selected'; endif; ?>><?php echo e($name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </optgroup>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php $__errorArgs = ['page'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="errs"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div data-link="url">
        <label for="url">Alamat tujuan <small>(contoh: https://spmb.raudhatuljannah.or.id atau /informasi/berita)</small></label>
        <input id="url" type="text" name="url" value="<?php echo e(old('url', $item->url)); ?>" maxlength="255" inputmode="url" autocomplete="off">
        <?php $__errorArgs = ['url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="errs"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div data-link="none">
        <p class="help">Menu tanpa tautan hanya berfungsi sebagai judul dropdown. Setelah disimpan, tambahkan isinya lewat tombol “+ Submenu”. Selama belum ada submenu yang tampil, menu ini tidak muncul di website.</p>
    </div>

    <div data-link="page url">
        <input type="hidden" name="new_tab" value="0">
        <label class="chk"><input type="checkbox" name="new_tab" value="1" <?php if(old('new_tab', $item->new_tab ? '1' : '0')): echo 'checked'; endif; ?>> Buka di tab baru</label>
    </div>

    <input type="hidden" name="is_visible" value="0">
    <label class="chk"><input type="checkbox" name="is_visible" value="1" <?php if(old('is_visible', $item->is_visible ? '1' : '0')): echo 'checked'; endif; ?>> Tampilkan di website</label>
    <p class="help">Hilangkan centang untuk menyembunyikan menu tanpa menghapusnya.</p>

    <p><button class="btn" type="submit">Simpan</button> <a class="btn sec" href="<?php echo e(route('admin.menu.index')); ?>">Batal</a></p>
</form>

<script>
(function () {
    var radios = document.querySelectorAll('input[name="link_type"]');
    var blocks = document.querySelectorAll('[data-link]');
    function sync() {
        var cur = (document.querySelector('input[name="link_type"]:checked') || {}).value || 'page';
        blocks.forEach(function (b) {
            b.hidden = b.getAttribute('data-link').split(' ').indexOf(cur) === -1;
        });
    }
    radios.forEach(function (r) { r.addEventListener('change', sync); });
    sync();
})();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ajmal\Downloads\portal-sdit-raudhatul-jannah (1)\portal-sdit-raudhatul-jannah\resources\views/admin/menu/form.blade.php ENDPATH**/ ?>