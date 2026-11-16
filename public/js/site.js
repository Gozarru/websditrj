(function () {
    'use strict';

    var reduce = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;
    function $(s, c) { return (c || document).querySelector(s); }
    function $$(s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); }

    /* Bayangan header saat halaman digulir */
    var header = $('.site-header');
    function onScroll() { if (header) header.classList.toggle('stuck', window.scrollY > 8); }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    /* Menu seluler */
    var burger = $('[data-burger]'), nav = $('#menu');
    if (burger && nav) {
        burger.addEventListener('click', function () {
            var open = nav.classList.toggle('open');
            burger.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    }

    /* Dropdown menu (hover di desktop lewat CSS, klik/keyboard di sini) */
    var dds = $$('.dd');
    function closeAll(except) {
        dds.forEach(function (d) {
            if (d !== except) {
                d.classList.remove('open');
                d.querySelector('.nl').setAttribute('aria-expanded', 'false');
            }
        });
    }
    dds.forEach(function (d) {
        var b = d.querySelector('.nl');
        b.addEventListener('click', function () {
            var open = !d.classList.contains('open');
            closeAll(d);
            d.classList.toggle('open', open);
            b.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    });
    document.addEventListener('click', function (e) { if (!e.target.closest('.dd')) closeAll(); });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeAll();
            if (nav) nav.classList.remove('open');
            if (burger) burger.setAttribute('aria-expanded', 'false');
        }
    });

    /* Efek riak saat tombol diklik */
    document.addEventListener('pointerdown', function (e) {
        var t = e.target.closest('.btn, .tabs button');
        if (!t) return;
        var r = t.getBoundingClientRect(), s = Math.max(r.width, r.height);
        var x = document.createElement('span');
        x.className = 'ripple';
        x.style.cssText = 'width:' + s + 'px;height:' + s + 'px;left:' + (e.clientX - r.left - s / 2) + 'px;top:' + (e.clientY - r.top - s / 2) + 'px';
        t.appendChild(x);
        setTimeout(function () { x.remove(); }, 700);
    });

    /* Slider foto beranda */
    $$('[data-slider]').forEach(function (sl) {
        var slides = $$('.slide', sl), dots = $$('[data-go]', sl), n = slides.length, i = 0;
        if (n < 2) return;
        $$('img', sl).forEach(function (im) { im.loading = 'eager'; });
        if (reduce) sl.classList.add('manual');

        function show(k) {
            i = (k + n) % n;
            slides.forEach(function (s, j) { s.classList.toggle('on', j === i); });
            dots.forEach(function (d, j) {
                d.classList.remove('on');
                if (j === i) { void d.offsetWidth; d.classList.add('on'); }
            });
        }

        /* Pindah otomatis saat bar progres selesai, sehingga jeda/lanjut selalu sinkron */
        sl.addEventListener('animationend', function (e) {
            if (reduce) return;
            if (e.animationName === 'fill' && e.target.classList && e.target.classList.contains('dot-b')) show(i + 1);
        });

        dots.forEach(function (d) { d.addEventListener('click', function () { show(parseInt(d.getAttribute('data-go'), 10)); }); });
        var prev = $('[data-prev]', sl), next = $('[data-next]', sl);
        if (prev) prev.addEventListener('click', function () { show(i - 1); });
        if (next) next.addEventListener('click', function () { show(i + 1); });

        function pause() { sl.classList.add('paused'); }
        function play() { sl.classList.remove('paused'); }
        sl.addEventListener('mouseenter', pause);
        sl.addEventListener('mouseleave', play);
        sl.addEventListener('focusin', pause);
        sl.addEventListener('focusout', play);
        document.addEventListener('visibilitychange', function () { if (document.hidden) pause(); else play(); });

        /* Geser dengan jari/mouse */
        var sx = null;
        sl.addEventListener('pointerdown', function (e) { if (!e.target.closest('button,a')) sx = e.clientX; });
        sl.addEventListener('pointerup', function (e) {
            if (sx === null) return;
            var dx = e.clientX - sx; sx = null;
            if (Math.abs(dx) > 50) show(dx < 0 ? i + 1 : i - 1);
        });
        sl.addEventListener('pointercancel', function () { sx = null; });
        sl.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowLeft') show(i - 1);
            if (e.key === 'ArrowRight') show(i + 1);
        });
    });

    /* Tab media belajar di beranda */
    $$('[data-tab]').forEach(function (b) {
        b.addEventListener('click', function () {
            $$('[data-tab]').forEach(function (x) { x.setAttribute('aria-pressed', x === b ? 'true' : 'false'); });
            $$('[data-panel]').forEach(function (p) { p.hidden = p.getAttribute('data-panel') !== b.getAttribute('data-tab'); });
        });
    });

    /* Lightbox galeri */
    var lb = null, list = [], idx = 0, trigger = null;
    function lbBuild() {
        lb = document.createElement('div');
        lb.className = 'lb';
        lb.setAttribute('role', 'dialog');
        lb.setAttribute('aria-modal', 'true');
        lb.setAttribute('aria-label', 'Pratinjau foto');
        lb.innerHTML = '<button class="c" type="button" aria-label="Tutup"><svg class="ic"><use href="#i-close"/></svg></button>' +
            '<button class="p" type="button" aria-label="Foto sebelumnya"><svg class="ic"><use href="#i-left"/></svg></button>' +
            '<button class="n" type="button" aria-label="Foto berikutnya"><svg class="ic"><use href="#i-right"/></svg></button>' +
            '<figure><img alt=""><figcaption></figcaption></figure>';
        lb.addEventListener('click', function (e) { if (e.target === lb) lbClose(); });
        $('.c', lb).addEventListener('click', lbClose);
        $('.p', lb).addEventListener('click', function () { lbShow(idx - 1); });
        $('.n', lb).addEventListener('click', function () { lbShow(idx + 1); });
    }
    function lbShow(k) {
        idx = (k + list.length) % list.length;
        var a = list[idx], fig = $('figure', lb), im = $('img', lb);
        im.src = a.getAttribute('href');
        im.alt = a.getAttribute('data-caption') || '';
        $('figcaption', lb).textContent = a.getAttribute('data-caption') || '';
        fig.style.animation = 'none'; void fig.offsetWidth; fig.style.animation = '';
        var many = list.length > 1;
        $('.p', lb).style.display = many ? '' : 'none';
        $('.n', lb).style.display = many ? '' : 'none';
    }
    function lbOpen(a) {
        var group = a.closest('[data-gallery]');
        list = $$('[data-lightbox]', group || document);
        if (!lb) lbBuild();
        trigger = a;
        lb.classList.remove('out');
        document.body.appendChild(lb);
        document.body.style.overflow = 'hidden';
        lbShow(list.indexOf(a));
        $('.c', lb).focus();
    }
    function lbClose() {
        if (!lb || !lb.parentNode) return;
        lb.classList.add('out');
        document.body.style.overflow = '';
        setTimeout(function () { if (lb.parentNode) lb.parentNode.removeChild(lb); if (trigger) trigger.focus(); }, reduce ? 0 : 250);
    }
    document.addEventListener('click', function (e) {
        var a = e.target.closest('[data-lightbox]');
        if (!a || e.metaKey || e.ctrlKey || e.shiftKey) return;
        e.preventDefault();
        lbOpen(a);
    });
    document.addEventListener('keydown', function (e) {
        if (!lb || !lb.parentNode || lb.classList.contains('out')) return;
        if (e.key === 'Escape') lbClose();
        if (e.key === 'ArrowLeft') lbShow(idx - 1);
        if (e.key === 'ArrowRight') lbShow(idx + 1);
    });
})();
