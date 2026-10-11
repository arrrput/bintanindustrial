    document.addEventListener("DOMContentLoaded", function() {
        const btnClosed = document.getElementById('btnApplyClosed');

        if (btnClosed) {
            btnClosed.addEventListener('click', function() {
                AppAlert.warning('This vacancy has been closed.', 'Outdated!');
            });
        }
    });
