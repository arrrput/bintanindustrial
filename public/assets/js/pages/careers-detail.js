    document.addEventListener("DOMContentLoaded", function() {
        const btnClosed = document.getElementById('btnApplyClosed');
        const toast = document.getElementById('outdatedToast');

        if (btnClosed && toast) {
            btnClosed.addEventListener('click', function() {
                // Menambahkan kelas 'show' untuk memicu CSS Shake & Fade-In
                toast.classList.add('show');
                
                // Otomatis menyembunyikan kembali alert setelah 3 detik
                setTimeout(function() {
                    toast.classList.remove('show');
                }, 3000);
            });
        }

        const successToast = document.getElementById('appliedSuccessToast');
        if (successToast) {
            setTimeout(() => {
                successToast.classList.remove('show');
            }, 4000);
        }
    });
