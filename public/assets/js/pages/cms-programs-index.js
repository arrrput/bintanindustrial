    document.addEventListener("DOMContentLoaded", function() {
        const toast = document.getElementById('adminSuccessToast');
        if (toast) {
            setTimeout(() => { toast.classList.add('show'); }, 100);
            setTimeout(() => { toast.classList.remove('show'); }, 3000);
        }
    });
