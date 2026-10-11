    document.addEventListener("DOMContentLoaded", function() {
        // Persist the active tab across page reloads (e.g. after a form submit) — Manage Profiles & Manage OSS
        document.querySelectorAll('ul.section-tab-nav[id]').forEach(nav => {
            const storageKey = 'cmsActiveTab:' + nav.id;

            let savedTab = null;
            try { savedTab = sessionStorage.getItem(storageKey); } catch (e) {}
            if (savedTab) {
                const tabEl = nav.querySelector(`[data-bs-target="${savedTab}"]`);
                if (tabEl) bootstrap.Tab.getOrCreateInstance(tabEl).show();
            }

            nav.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
                tab.addEventListener('shown.bs.tab', e => {
                    try { sessionStorage.setItem(storageKey, e.target.dataset.bsTarget); } catch (err) {}
                });
            });
        });
    });
