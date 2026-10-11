    async function triggerSelectConfirm(selectEl, name, title, oldVal) {
        const newVal = selectEl.value;
        if (newVal === oldVal) return;

        const message = `Verify status update to ${newVal.toUpperCase()} for ${name} for the position of ${title}?`;
        const ok = await AppAlert.confirm(message, {
            title: 'Confirm Status Update',
            icon: 'question',
            confirmText: 'Confirm',
            confirmColor: '#198754',
        });

        if (!ok) {
            selectEl.value = oldVal;
            return;
        }

        selectEl.form.submit(); // form data is captured here, so the select can be disabled afterwards
        selectEl.disabled = true;

        const status = document.createElement('div');
        status.className = 'small text-muted mt-n2 mb-3';
        status.innerHTML = '<span class="spinner-border spinner-border-sm me-2" aria-hidden="true"></span>Saving...';
        selectEl.insertAdjacentElement('afterend', status);
    }
