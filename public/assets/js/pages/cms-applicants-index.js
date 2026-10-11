    async function showConfirmStatusModal(form, message, btn) {
        // Hide the open status modal so the confirmation is not covered by its backdrop/focus trap
        const openModal = form.closest('.modal');
        document.querySelectorAll('.modal.show').forEach(m => {
            const modalInstance = bootstrap.Modal.getInstance(m);
            if (modalInstance) modalInstance.hide();
        });

        const ok = await AppAlert.confirm(message, {
            title: 'Confirm Status Update',
            icon: 'question',
            confirmText: 'Confirm',
            confirmColor: '#198754',
        });
        if (!ok) return;

        // Re-open the modal so the user sees the button saving while the page submits
        if (openModal) bootstrap.Modal.getOrCreateInstance(openModal).show();
        form.querySelectorAll('button').forEach(b => { if (b !== btn) b.disabled = true; });
        ButtonLoading.start(btn, 'Saving...');
        form.submit();
    }

    function triggerConfirm(form, statusVal, name, title, btn) {
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
        showConfirmStatusModal(form, message, btn);
    }
