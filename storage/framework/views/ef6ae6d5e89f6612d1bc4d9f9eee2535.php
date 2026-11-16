<?php $__env->startSection('title', 'Menu situs'); ?>
<?php $__env->startSection('content'); ?>
<div class="bar"><h1>Menu situs</h1><a class="btn" href="<?php echo e(route('admin.menu.create')); ?>">+ Menu</a></div>
<p class="muted" style="margin:-8px 0 16px">Menu di bagian atas website. Urutan di sini sama dengan urutan di website (kiri ke kanan). Menu yang punya submenu tampil sebagai dropdown.</p>

<div class="card">
<table class="resp">
    <thead><tr><th>Menu</th><th>Tujuan</th><th>Status</th><th></th></tr></thead>
    <tbody>
    <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $top): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php $shownKids = $top->children->filter(fn ($c) => $c->is_visible && $c->href())->count(); ?>
        <?php $__currentLoopData = collect([$top])->concat($top->children); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $isChild = (bool) $i->parent_id;
            $siblings = $isChild ? $top->children : $items;
            $note = null;
            if ($i->is_visible) {
                if ($isChild && ! $top->is_visible) $note = 'Tidak tampil: menu induknya disembunyikan';
                elseif ($i->link_type === 'page' && $i->page === 'spmb' && ! $i->href() && (! $isChild ? $shownKids === 0 : true)) $note = 'Tidak tampil: tautan SPMB di Pengaturan situs masih kosong';
                elseif (! $isChild && $shownKids === 0 && ! $i->href()) $note = 'Tidak tampil: belum ada submenu yang tampil';
                elseif ($isChild && ! $i->href()) $note = 'Tidak tampil: halaman tujuan tidak ditemukan';
            }
        ?>
        <tr>
            <td data-label="Menu">
                <span class="tt" <?php if($isChild): ?> style="display:inline-block;padding-left:26px" <?php endif; ?>>
                    <?php if($isChild): ?><span class="muted" aria-hidden="true">└ </span><?php endif; ?>
                    <?php if($isChild): ?><?php echo e($i->label); ?><?php else: ?><b><?php echo e($i->label); ?></b><?php endif; ?>
                    <?php if(! $isChild && $top->children->count()): ?><small class="muted"> · dropdown, <?php echo e($top->children->count()); ?> submenu</small><?php endif; ?>
                </span>
            </td>
            <td data-label="Tujuan">
                <span class="tt">
                <?php if(! $isChild && $top->children->count()): ?>
                    <span class="muted">Membuka dropdown</span>
                <?php elseif($i->href()): ?>
                    <a href="<?php echo e($i->href()); ?>" target="_blank" rel="noopener" style="word-break:break-all"><?php echo e($i->targetLabel()); ?></a><?php if($i->new_tab): ?> <small class="muted">(tab baru)</small><?php endif; ?>
                <?php else: ?>
                    <span class="muted"><?php echo e($i->targetLabel()); ?></span>
                <?php endif; ?>
                </span>
            </td>
            <td data-label="Status">
                <span class="tt">
                    <span class="badge <?php echo e($i->is_visible ? 's-published' : 's-draft'); ?>"><?php echo e($i->is_visible ? 'Tampil' : 'Disembunyikan'); ?></span>
                    <?php if($note): ?><br><small class="muted"><?php echo e($note); ?></small><?php endif; ?>
                </span>
            </td>
            <td class="act">
                <form method="POST" action="<?php echo e(route('admin.menu.move', [$i, 'up'])); ?>"><?php echo csrf_field(); ?><button class="btn sec sm" title="Geser ke atas" aria-label="Geser <?php echo e($i->label); ?> ke atas" <?php if($siblings->first()->is($i)): echo 'disabled'; endif; ?>>↑</button></form>
                <form method="POST" action="<?php echo e(route('admin.menu.move', [$i, 'down'])); ?>"><?php echo csrf_field(); ?><button class="btn sec sm" title="Geser ke bawah" aria-label="Geser <?php echo e($i->label); ?> ke bawah" <?php if($siblings->last()->is($i)): echo 'disabled'; endif; ?>>↓</button></form>
                <form method="POST" action="<?php echo e(route('admin.menu.toggle', $i)); ?>"><?php echo csrf_field(); ?><button class="btn sec sm"><?php echo e($i->is_visible ? 'Sembunyikan' : 'Tampilkan'); ?></button></form>
                <?php if(! $isChild): ?><a class="btn sec sm" href="<?php echo e(route('admin.menu.create', ['parent' => $i->id])); ?>">+ Submenu</a><?php endif; ?>
                <a class="btn sec sm" href="<?php echo e(route('admin.menu.edit', $i)); ?>">Ubah</a>
                <form method="POST" action="<?php echo e(route('admin.menu.destroy', $i)); ?>" data-confirm="<?php echo e(! $isChild && $top->children->count() ? 'Hapus menu "'.$i->label.'" beserta '.$top->children->count().' submenunya?' : 'Hapus menu "'.$i->label.'"?'); ?>"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="btn del sm">Hapus</button></form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr><td colspan="4" class="muted">Belum ada menu. Tekan “+ Menu” untuk menambah, atau kembalikan menu bawaan di bawah.</td></tr>
    <?php endif; ?>
    </tbody>
</table>
</div>

<div class="card">
    <h2>Catatan</h2>
    <p class="help" style="margin-bottom:12px">Tombol emas “<?php echo e(site('spmb_button') ?: 'Daftar Sekarang'); ?>” di ujung kanan diatur di <a href="<?php echo e(route('admin.settings.edit')); ?>">Pengaturan situs</a> bagian Beranda (teks tombol dan tautan pendaftaran). Jika tautan pendaftaran dikosongkan, tombol itu tidak ditampilkan.</p>
    <form method="POST" action="<?php echo e(route('admin.menu.reset')); ?>" data-confirm="Kembalikan menu ke susunan bawaan? Semua perubahan menu (tambahan, urutan, yang disembunyikan) akan hilang."><?php echo csrf_field(); ?><button class="btn del sm">Kembalikan menu bawaan</button></form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ajmal\Downloads\portal-sdit-raudhatul-jannah (1)\portal-sdit-raudhatul-jannah\resources\views/admin/menu/index.blade.php ENDPATH**/ ?>