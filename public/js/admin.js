(function () {
    'use strict';
    var body = document.body;
    function toggle(open) { body.classList.toggle('nav-open', open); }
    document.addEventListener('click', function (e) {
        if (e.target.closest('[data-nav-open]')) toggle(true);
        else if (e.target.closest('[data-nav-close]') || e.target.closest('[data-scrim]')) toggle(false);
    });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') toggle(false); });
    // Konfirmasi sebelum aksi yang menghapus/menarik
    document.addEventListener('submit', function (e) {
        var msg = e.target.getAttribute('data-confirm');
        if (msg && !window.confirm(msg)) e.preventDefault();
    });
    // Cegah klik ganda pada tombol kirim
    document.addEventListener('submit', function (e) {
        if (e.defaultPrevented) return;
        var b = e.submitter || e.target.querySelector('button[type=submit], button:not([type])');
        if (b) setTimeout(function () { b.disabled = true; }, 0);
    });
    // Pesan sukses hilang sendiri
    var ok = document.querySelector('.flash:not(.err)');
    if (ok) setTimeout(function () { ok.style.transition = 'opacity .5s'; ok.style.opacity = '0'; setTimeout(function () { ok.remove(); }, 600); }, 6000);
})();
