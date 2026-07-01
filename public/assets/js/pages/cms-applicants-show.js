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
        
        const confirmModalEl = document.getElementById('statusConfirmModal');
        const confirmModal = new bootstrap.Modal(confirmModalEl);
        confirmModal.show();
    }

    function triggerSelectConfirm(selectEl, name, title, oldVal) {
        const newVal = selectEl.value;
        if (newVal === oldVal) return;
        
        const message = `Verify status update to ${newVal.toUpperCase()} for ${name} for the position of ${title}?`;
        showConfirmStatusModal(selectEl.form, message, selectEl, oldVal);
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
