    let currentFormToSubmit = null;
    let currentSelectToRevert = null;
    let previousSelectValue = "";
    let hasConfirmed = false;

    function showConfirmStatusModal(form, message, selectEl = null, oldVal = "") {
        currentFormToSubmit = form;
        currentSelectToRevert = selectEl;
        previousSelectValue = oldVal;
        hasConfirmed = false;
        
        document.getElementById('statusConfirmMessage').innerText = message;
        
        // Hide other open modals to prevent backdrop layering issues
        const openModals = document.querySelectorAll('.modal.show');
        openModals.forEach(m => {
            if (m.id !== 'statusConfirmModal') {
                const modalInstance = bootstrap.Modal.getInstance(m);
                if (modalInstance) modalInstance.hide();
            }
        });
        
        const confirmModalEl = document.getElementById('statusConfirmModal');
        const confirmModal = new bootstrap.Modal(confirmModalEl);
        confirmModal.show();
    }

    function triggerConfirm(form, statusVal, name, title) {
        // Set hidden status input inside form
        let statusInput = form.querySelector('input[name="status"]');
        if (!statusInput) {
            statusInput = document.createElement('input');
            statusInput.type = 'hidden';
            statusInput.name = 'status';
            form.appendChild(statusInput);
        }
        statusInput.value = statusVal.toLowerCase();
        
        const message = `Verify status update to ${statusVal} for ${name} for the position of ${title}?`;
        showConfirmStatusModal(form, message);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const proceedBtn = document.getElementById('statusConfirmProceedBtn');
        if (proceedBtn) {
            proceedBtn.addEventListener('click', function() {
                hasConfirmed = true;
                if (currentFormToSubmit) {
                    currentFormToSubmit.submit();
                }
            });
        }
        
        const modalEl = document.getElementById('statusConfirmModal');
        if (modalEl) {
            modalEl.addEventListener('hidden.bs.modal', function () {
                if (!hasConfirmed && currentSelectToRevert) {
                    currentSelectToRevert.value = previousSelectValue;
                }
            });
        }
    });
