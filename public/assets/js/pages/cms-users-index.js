    document.addEventListener('DOMContentLoaded', function() {
        const successToast = document.getElementById('adminSuccessToast');
        if(successToast) {
            successToast.classList.add('show');
            setTimeout(() => { successToast.classList.remove('show'); }, 4000);
        }

        const errorToast = document.getElementById('adminErrorToast');
        if(errorToast) {
            errorToast.classList.add('show');
            setTimeout(() => { errorToast.classList.remove('show'); }, 4000);
        }

        // Init Tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
