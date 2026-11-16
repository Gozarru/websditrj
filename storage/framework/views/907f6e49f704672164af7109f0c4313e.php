<?php $__env->startSection('title', 'Pengguna'); ?>
<?php $__env->startSection('content'); ?>
<div class="bar"><h1>Pengguna</h1><a class="btn" href="<?php echo e(route('admin.users.create')); ?>">+ Pengguna</a></div>
<div class="card">
<table class="resp">
    <thead><tr><th>Nama</th><th>Peran</th><th>Status</th><th>Terakhir masuk</th><th></th></tr></thead>
    <tbody>
    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td data-label="Nama"><span class="tt"><b><?php echo e($i->name); ?></b><br><small class="muted"><?php echo e($i->email); ?></small></span></td>
        <td data-label="Peran"><span class="badge r-<?php echo e($i->role); ?>"><?php echo e($i->roleLabel()); ?></span></td>
        <td data-label="Status"><?php if($i->is_active): ?><span class="badge s-published">Aktif</span><?php else: ?><span class="badge s-draft">Nonaktif</span><?php endif; ?></td>
        <td data-label="Terakhir masuk"><?php echo e($i->last_login_at?->diffForHumans() ?? 'Belum pernah'); ?></td>
        <td class="act">
            <a class="btn sec sm" href="<?php echo e(route('admin.users.edit', $i)); ?>">Ubah</a>
            <?php if($i->id !== auth()->id()): ?>
            <form method="POST" action="<?php echo e(route('admin.users.destroy', $i)); ?>" data-confirm="Hapus pengguna <?php echo e($i->name); ?>? Riwayat aktivitasnya tetap tersimpan."><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="btn del sm">Hapus</button></form>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
</div>

<div class="card">
    <h2>Hak akses tiap peran</h2>
    <?php $roles = config('roles.roles'); ?>
    <div class="tw"><table class="matrix">
        <thead><tr><th>Hak akses</th><?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><th><?php echo e($r['label']); ?></th><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></tr></thead>
        <tbody>
        <?php $__currentLoopData = config('roles.permissions'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perm => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr><td><?php echo e($label); ?></td><?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><td><?php if(in_array('*', $r['perms']) || in_array($perm, $r['perms'])): ?><span class="yes" aria-label="Ya">✓</span><?php else: ?><span class="no" aria-label="Tidak">–</span><?php endif; ?></td><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table></div>
    <p class="help">Alur tulisan: Editor menulis → Operator memeriksa → Kepala Sekolah menyetujui → Operator/Kepala Sekolah menerbitkan atau menjadwalkan. Admin dapat menjalankan semua tahap.</p>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ajmal\Downloads\portal-sdit-raudhatul-jannah (1)\portal-sdit-raudhatul-jannah\resources\views/admin/users/index.blade.php ENDPATH**/ ?>