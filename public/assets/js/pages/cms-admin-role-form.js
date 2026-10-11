    document.addEventListener('DOMContentLoaded', function() {
        // "Select all" / "Clear" for the permission checkboxes
        document.querySelectorAll('.js-check-all').forEach(link => {
            link.addEventListener('click', e => {
                e.preventDefault();
                document.querySelectorAll('.js-permission').forEach(cb => { cb.checked = link.dataset.check === '1'; });
            });
        });
    });
