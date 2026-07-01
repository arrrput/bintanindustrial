    function toggleFields() {
        const category = document.getElementById('categorySelect').value;
        const imageField = document.getElementById('imageField');
        const iconField = document.getElementById('iconField');

        if (category === 'service_suite') {
            imageField.classList.add('d-none');
            iconField.classList.remove('d-none');
        } else {
            imageField.classList.remove('d-none');
            iconField.classList.add('d-none');
        }
    }

    document.addEventListener('DOMContentLoaded', toggleFields);
