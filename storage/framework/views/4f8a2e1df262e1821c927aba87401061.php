<?php $__env->startSection('title', 'Kontak — '.site('school_name')); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('partials.pagehero', ['crumbs' => ['Kontak' => null], 'eyebrow' => 'Kontak', 'title' => 'Hubungi Kami', 'subtitle' => 'Silakan datang langsung atau hubungi sekolah pada jam kerja.'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<section class="sec"><div class="wrap kgrid">
    <div class="klist">
        <?php if(site('address')): ?><div class="kc"><svg class="ic"><use href="#i-pin"/></svg><div><b>Alamat</b><p><?php echo nl2br(e(site('address'))); ?></p></div></div><?php endif; ?>
        <?php if(site('phone')): ?><a class="kc" href="tel:<?php echo e(preg_replace('/[^\d+]/', '', site('phone'))); ?>"><svg class="ic"><use href="#i-phone"/></svg><div><b>Telepon</b><p><?php echo e(site('phone')); ?></p></div></a><?php endif; ?>
        <?php if(wa_link(site('whatsapp'))): ?><a class="kc" href="<?php echo e(wa_link(site('whatsapp'))); ?>" target="_blank" rel="noopener"><svg class="ic"><use href="#i-chat"/></svg><div><b>WhatsApp</b><p><?php echo e(site('whatsapp')); ?></p></div></a><?php endif; ?>
        <?php if(site('email')): ?><a class="kc" href="mailto:<?php echo e(site('email')); ?>"><svg class="ic"><use href="#i-mail"/></svg><div><b>Email</b><p><?php echo e(site('email')); ?></p></div></a><?php endif; ?>
        <?php if(site('spmb_url')): ?><a class="btn primary" href="<?php echo e(site('spmb_url')); ?>" target="_blank" rel="noopener"><?php echo e(site('spmb_button') ?: 'Daftar Sekarang'); ?><svg class="ic ne"><use href="#i-ne"/></svg></a><?php endif; ?>
    </div>
    <?php if(site('address')): ?>
    <div class="map"><iframe title="Peta lokasi sekolah" src="https://www.google.com/maps?q=<?php echo e(urlencode(site('school_name').' '.site('address'))); ?>&amp;output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe></div>
    <?php endif; ?>
</div></section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ajmal\Downloads\portal-sdit-raudhatul-jannah (1)\portal-sdit-raudhatul-jannah\resources\views/pages/kontak.blade.php ENDPATH**/ ?>