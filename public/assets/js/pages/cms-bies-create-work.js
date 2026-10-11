    // Show the fields that matter for the chosen category:
    // - Business Opportunity (main_section): cover image + subtitle + description
    // - Service Suite card: icon + description
    // - Facility photo card: photo + icon, description optional
    function toggleFields() {
        const category = document.getElementById('categorySelect').value;
        const show = (id, visible) => document.getElementById(id)?.classList.toggle('d-none', !visible);

        show('imageField', category !== 'service_suite');
        show('iconField', category !== 'main_section');
        show('subtitleField', category !== 'facility');

        const imageLabel = document.getElementById('imageLabel');
        if (imageLabel) imageLabel.textContent = category === 'facility' ? 'Photo' : 'Cover Image';

        const description = document.getElementById('descriptionInput');
        const descriptionRequired = document.getElementById('descriptionRequired');
        if (description) description.required = category !== 'facility';
        if (descriptionRequired) descriptionRequired.classList.toggle('d-none', category === 'facility');
    }

    document.addEventListener('DOMContentLoaded', toggleFields);
