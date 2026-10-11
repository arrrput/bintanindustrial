    document.addEventListener("DOMContentLoaded", function() {
        // Keep the logo counter in sync after AJAX bulk deletes
        const updateTotal = () => {
            const totalEl = document.getElementById('tenantTotal');
            if (totalEl) totalEl.textContent = document.querySelectorAll('#tenantList [data-tenant-id]').length;
        };

        window.setupBulkDelete({
            containerId: 'tenantList',
            checkClass: 'tenant-check',
            selectAllId: 'tenantSelectAll',
            bulkBtnId: 'tenantBulkDelete',
            countId: 'tenantSelCount',
            itemAttr: 'data-tenant-id',
            confirmTitle: 'Delete selected logos?',
            onEmpty: () => {
                updateTotal();
                const list = document.getElementById('tenantList');
                if (list && !list.querySelector('[data-tenant-id]')) {
                    list.innerHTML = '<tr><td colspan="5" class="text-center py-5 text-muted">No tenant logos yet.</td></tr>';
                }
            },
        });
    });
