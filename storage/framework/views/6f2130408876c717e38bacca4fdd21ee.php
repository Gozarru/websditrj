<?php $__env->startSection('title', 'Ringkasan'); ?>
<?php $__env->startSection('content'); ?>
<?php $max = max(1, collect($chart)->max('n')); ?>
<div class="hello">
    <div><h1>Halo, <?php echo e(explode(' ', $user->name)[0]); ?></h1><p class="muted" style="margin:0">Anda masuk sebagai <span class="badge r-<?php echo e($user->role); ?>"><?php echo e($user->roleLabel()); ?></span></p></div>
    <?php if($user->can('posts.write')): ?>
    <div style="display:flex;gap:8px;flex-wrap:wrap">
        <a class="btn" href="<?php echo e(route('admin.posts.create')); ?>">+ Berita</a>
        <a class="btn sec" href="<?php echo e(route('admin.posts.create', ['type' => 'pengumuman'])); ?>">+ Pengumuman</a>
    </div>
    <?php endif; ?>
</div>

<div class="stats">
    <div class="stat hl"><small>Pengunjung hari ini</small><b><?php echo e(number_format($visits['today'])); ?></b><span><?php echo e(number_format($visits['week'])); ?> dalam 7 hari terakhir</span></div>
    <div class="stat"><small>Pengunjung 30 hari</small><b><?php echo e(number_format($visits['month'])); ?></b><span><?php echo e(number_format($visits['views30'])); ?> halaman dibuka</span></div>
    <a class="stat" href="<?php echo e(route('admin.posts.index', ['type' => 'berita'])); ?>"><small>Artikel (berita)</small><b><?php echo e($content['berita']['live']); ?></b><span>tayang dari <?php echo e($content['berita']['all']); ?> tulisan</span></a>
    <a class="stat" href="<?php echo e(route('admin.posts.index', ['type' => 'pengumuman'])); ?>"><small>Pengumuman</small><b><?php echo e($content['pengumuman']['live']); ?></b><span>tayang dari <?php echo e($content['pengumuman']['all']); ?> tulisan</span></a>
    <?php if($user->can('agenda.manage')): ?>
    <a class="stat" href="<?php echo e(route('admin.agendas.index')); ?>"><small>Agenda</small><b><?php echo e($content['agenda']['upcoming']); ?></b><span>mendatang dari <?php echo e($content['agenda']['all']); ?> agenda</span></a>
    <?php else: ?>
    <div class="stat"><small>Agenda</small><b><?php echo e($content['agenda']['upcoming']); ?></b><span>mendatang dari <?php echo e($content['agenda']['all']); ?> agenda</span></div>
    <?php endif; ?>
</div>

<div class="grid2">
    <div>
        <div class="card">
            <h2>Pengunjung 14 hari terakhir</h2>
            <div class="bars" role="img" aria-label="Grafik pengunjung harian">
                <?php $__currentLoopData = $chart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="c" title="<?php echo e($c['label']); ?>: <?php echo e($c['n']); ?> pengunjung">
                    <span class="v"><?php echo e($c['n'] ?: ''); ?></span>
                    <div class="b" style="height:<?php echo e(max(2, round($c['n'] / $max * 100))); ?>%"></div>
                    <span class="l"><?php echo e($c['short']); ?></span>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <p class="help">Pengunjung dihitung unik per hari (perangkat yang sama dihitung sekali sehari). Total sejak awal: <?php echo e(number_format($visits['total'])); ?> kunjungan harian.</p>
        </div>

        <div class="card">
            <h2>Alur publikasi</h2>
            <div class="pipe">
                <?php $__currentLoopData = \App\Models\Post::STATUSES; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('admin.posts.index', ['status' => $k])); ?>"><b><?php echo e($status[$k] ?? 0); ?></b><small><?php echo e($label); ?></small></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    <div>
        <div class="card">
            <h2>Perlu tindakan Anda</h2>
            <?php if($queue->isNotEmpty()): ?>
            <ul class="list">
                <?php $__currentLoopData = $queue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <span class="tt"><a href="<?php echo e(route('admin.posts.show', $p)); ?>"><?php echo e($p->title); ?></a><small><?php echo e($p->typeLabel()); ?> · <?php echo e($p->author?->name ?? '—'); ?></small></span>
                    <span class="badge s-<?php echo e($p->status); ?>"><?php echo e($p->statusLabel()); ?></span>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <?php else: ?>
            <p class="empty">Tidak ada tulisan yang menunggu tindakan Anda.</p>
            <?php endif; ?>
        </div>

        <div class="card">
            <h2><?php echo e($user->can('audit.view') ? 'Aktivitas terbaru' : 'Aktivitas saya'); ?></h2>
            <?php if($logs->isNotEmpty()): ?>
            <ul class="log">
                <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($l->description); ?><small><?php echo e($l->user_name); ?> · <?php echo e($l->created_at->diffForHumans()); ?></small></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <?php if($user->can('audit.view')): ?><p style="margin:12px 0 0"><a href="<?php echo e(route('admin.audit.index')); ?>">Lihat semua aktivitas →</a></p><?php endif; ?>
            <?php else: ?>
            <p class="empty">Belum ada aktivitas.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ajmal\Downloads\portal-sdit-raudhatul-jannah (1)\portal-sdit-raudhatul-jannah\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>