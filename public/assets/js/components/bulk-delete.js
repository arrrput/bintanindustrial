/**
 * Generic bulk-delete wiring: select-all + per-item checkboxes + a bulk button.
 * Used by Manage Home (testimonials) and Manage Tenant Logos.
 *
 * window.setupBulkDelete({
 *     containerId, checkClass, selectAllId, bulkBtnId, countId,
 *     itemAttr, confirmTitle, onEmpty
 * }) → { refresh } | null
 */
(function () {
    "use strict";

    window.setupBulkDelete = function (opts) {
        const container = document.getElementById(opts.containerId);
        const bulkBtn = document.getElementById(opts.bulkBtnId);
        const selectAll = opts.selectAllId ? document.getElementById(opts.selectAllId) : null;
        const countEl = opts.countId ? document.getElementById(opts.countId) : null;
        if (!container || !bulkBtn) return null;

        const csrfToken = document.querySelector('input[name="_token"]')?.value;
        const checks = () => Array.from(container.querySelectorAll('.' + opts.checkClass));
        const selected = () => checks().filter(c => c.checked);

        function refresh() {
            const all = checks();
            const n = selected().length;
            if (countEl) countEl.textContent = n;
            bulkBtn.classList.toggle('d-none', n === 0);
            if (selectAll) {
                selectAll.checked = all.length > 0 && n === all.length;
                selectAll.indeterminate = n > 0 && n < all.length;
            }
        }

        container.addEventListener('change', (e) => {
            if (e.target.classList && e.target.classList.contains(opts.checkClass)) refresh();
        });

        if (selectAll) {
            selectAll.addEventListener('change', () => {
                checks().forEach(c => { c.checked = selectAll.checked; });
                refresh();
            });
        }

        bulkBtn.addEventListener('click', async () => {
            const ids = selected().map(c => c.value);
            if (ids.length === 0) return;

            const confirmRes = await Swal.fire({
                title: opts.confirmTitle,
                html: `This will permanently delete <b>${ids.length}</b> item(s).`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete',
                confirmButtonColor: '#d33',
                cancelButtonText: 'Cancel',
            });
            if (!confirmRes.isConfirmed) return;

            ButtonLoading.start(bulkBtn, 'Deleting...');
            try {
                const res = await fetch(bulkBtn.dataset.url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ ids }),
                });

                const data = await res.json().catch(() => ({}));
                if (!res.ok) {
                    const msg = data.message
                        || (data.errors ? Object.values(data.errors).flat().join('\n') : 'Delete failed.');
                    throw new Error(msg);
                }

                (data.ids || ids).forEach(id => {
                    const el = container.querySelector(`[${opts.itemAttr}="${id}"]`);
                    if (el) el.remove();
                });

                ButtonLoading.stop(bulkBtn);

                if (selectAll) { selectAll.checked = false; selectAll.indeterminate = false; }
                refresh();
                if (typeof opts.onEmpty === 'function') opts.onEmpty();

                AppAlert.success(data.message || 'Selected items deleted.');
            } catch (err) {
                ButtonLoading.stop(bulkBtn);
                refresh();
                Swal.fire({
                    icon: 'error',
                    title: 'Failed',
                    text: err.message || 'Something went wrong while deleting.',
                });
            }
        });

        return { refresh };
    };
})();
