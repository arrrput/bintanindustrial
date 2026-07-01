    document.addEventListener("DOMContentLoaded", function() {
        const toast = document.getElementById('adminSuccessToast');
        if (toast) {
            setTimeout(() => toast.classList.add('show'), 100);
            setTimeout(() => toast.classList.remove('show'), 3500);
        }

        // Persist active tab across page reloads (e.g. after form submit)
        const savedTab = sessionStorage.getItem('bieActiveTab');
        if (savedTab) {
            const tabEl = document.querySelector(`[data-bs-target="${savedTab}"]`);
            if (tabEl) bootstrap.Tab.getOrCreateInstance(tabEl).show();
        }

        document.querySelectorAll('#bieTabs [data-bs-toggle="tab"]').forEach(tab => {
            tab.addEventListener('shown.bs.tab', e => {
                sessionStorage.setItem('bieActiveTab', e.target.dataset.bsTarget);
            });
        });
    });
