    (function () {
        /* Set CSS variable untuk tinggi header */
        function updateHeaderH() {
            var hdr = document.querySelector('#header');
            if (hdr) document.documentElement.style.setProperty('--header-h', hdr.offsetHeight + 'px');
        }
        updateHeaderH();
        /* ResizeObserver: update setiap frame selama topbar transition (0.5s) agar overlay
           selalu menempel tepat di bawah header tanpa jeda */
        var hdr = document.querySelector('#header');
        if (hdr && window.ResizeObserver) {
            new ResizeObserver(updateHeaderH).observe(hdr);
        } else {
            window.addEventListener('resize', updateHeaderH);
            window.addEventListener('scroll', updateHeaderH, { passive: true });
        }

        document.addEventListener('DOMContentLoaded', function () {
            updateHeaderH();

            /* Tutup menu saat klik backdrop (bukan di dalam ul) */
            document.querySelector('#navmenu')?.addEventListener('click', function (e) {
                const body = document.body;
                if (!e.target.closest('#navmenu > ul') && body.classList.contains('mobile-nav-active') && !body.classList.contains('mobile-nav-closing')) {
                    document.querySelector('.mobile-nav-toggle')?.click();
                }
            });

            /* Toggle CMS user dropdown di mobile */
            document.querySelectorAll('.navmenu .user-dropdown-toggle').forEach(function (toggle) {
                toggle.addEventListener('click', function (e) {
                    if (window.innerWidth < 1200) {
                        e.preventDefault();
                        e.stopPropagation();
                        e.stopImmediatePropagation();
                        this.closest('.user-dropdown').classList.toggle('mobile-open');
                    }
                }, true);
            });
        });
    })();
