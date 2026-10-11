    document.addEventListener("DOMContentLoaded", function() {
        // Keep the "Client Testimonials" tab counter in sync when rows are deleted without a reload
        const testimonialTable = document.getElementById('testimonialTableBody');
        const testimonialTabCount = document.getElementById('testimonialTabCount');
        if (testimonialTable && testimonialTabCount) {
            new MutationObserver(() => {
                testimonialTabCount.textContent = testimonialTable.querySelectorAll('[data-testimonial-id]').length;
            }).observe(testimonialTable, { childList: true });
        }

        const testimonialBulk = window.setupBulkDelete({
            containerId: 'testimonialTableBody',
            checkClass: 'testimonial-check',
            selectAllId: 'testimonialSelectAll',
            bulkBtnId: 'testimonialBulkDelete',
            countId: 'testimonialSelCount',
            itemAttr: 'data-testimonial-id',
            confirmTitle: 'Delete selected testimonials?',
            onEmpty: () => {
                const body = document.getElementById('testimonialTableBody');
                if (body && !body.querySelector('[data-testimonial-id]')) {
                    body.innerHTML = '<tr><td colspan="6" class="text-center py-5 text-muted">No testimonials found.</td></tr>';
                }
            },
        });

        // Delete a testimonial without reloading (SweetAlert confirm + AJAX),
        // so it stays consistent with the tenant-logo page.
        const testimonialBody = document.getElementById('testimonialTableBody');
        if (testimonialBody) {
            testimonialBody.addEventListener('submit', async (e) => {
                const delForm = e.target.closest('form.js-delete-testimonial');
                if (!delForm) return;
                e.preventDefault();

                const confirmRes = await Swal.fire({
                    title: 'Delete this testimonial?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete',
                    confirmButtonColor: '#d33',
                    cancelButtonText: 'Cancel',
                });
                if (!confirmRes.isConfirmed) return;

                const delBtn = ButtonLoading.submitButtonOf(delForm, e.submitter);
                ButtonLoading.start(delBtn, 'Deleting...');
                try {
                    const res = await fetch(delForm.getAttribute('action'), {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': delForm.querySelector('input[name="_token"]')?.value,
                            'Accept': 'application/json',
                        },
                        body: new FormData(delForm), // carries _token and _method=DELETE
                    });

                    const data = await res.json().catch(() => ({}));
                    if (!res.ok) throw new Error(data.message || 'Delete failed.');

                    const row = delForm.closest('[data-testimonial-id]');
                    if (row) row.remove();
                    testimonialBulk?.refresh();

                    if (!testimonialBody.querySelector('[data-testimonial-id]')) {
                        testimonialBody.innerHTML = '<tr><td colspan="6" class="text-center py-5 text-muted">No testimonials found.</td></tr>';
                    }

                    AppAlert.success(data.message || 'Testimonial deleted.');
                } catch (err) {
                    ButtonLoading.stop(delBtn);
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: err.message || 'Something went wrong while deleting.',
                    });
                }
            });
        }
    });
