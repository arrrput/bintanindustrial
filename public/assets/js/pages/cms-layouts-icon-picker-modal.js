    let currentInputId = '';
    let currentPreviewId = '';
    let iconModal;

    function openIconPicker(inputId, previewId) {
        currentInputId = inputId;
        currentPreviewId = previewId;
        if(!iconModal) {
            iconModal = new bootstrap.Modal(document.getElementById('iconPickerModal'));
        }
        iconModal.show();
    }

    function selectPickedIcon(iconClass) {
        document.getElementById(currentInputId).value = iconClass;
        document.getElementById(currentPreviewId).innerHTML = `<i class="${iconClass}"></i>`;
        iconModal.hide();
    }

    document.getElementById('iconSearch').addEventListener('input', function(e) {
        const term = e.target.value.toLowerCase();
        document.querySelectorAll('.icon-option').forEach(opt => {
            const icon = opt.getAttribute('data-icon').toLowerCase();
            opt.style.display = icon.includes(term) ? 'flex' : 'none';
        });
    });
