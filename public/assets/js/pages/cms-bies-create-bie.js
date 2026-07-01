    function toggleFields() {
        const category = document.getElementById('categorySelect').value;
        const imageField = document.getElementById('imageField');
        const iconField = document.getElementById('iconField');
        const badgeField = document.getElementById('badgeField');
        const subtitleField = document.getElementById('subtitleField');

        if (category === 'main_section') {
            imageField.classList.remove('d-none');
            badgeField.classList.remove('d-none');
            subtitleField.classList.remove('d-none');
            iconField.classList.add('d-none');
        } else {
            imageField.classList.add('d-none');
            badgeField.classList.add('d-none');
            subtitleField.classList.add('d-none');
            iconField.classList.remove('d-none');
        }
    }

    document.addEventListener('DOMContentLoaded', toggleFields);
