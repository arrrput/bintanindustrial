    const layoutStyle = document.getElementById('layout_style');
    const container = document.getElementById('extra-content-container');
    const title = document.getElementById('extra-content-title');
    const advantageEditor = document.getElementById('advantage-grid-editor');
    const infoEditor = document.getElementById('info-grid-editor');

    layoutStyle.addEventListener('change', function() {
        container.style.display = 'block';
        advantageEditor.style.display = 'none';
        infoEditor.style.display = 'none';

        if (this.value === 'default') {
            container.style.display = 'none';
        } else if (this.value === 'advantage_grid') {
            title.innerText = 'Advantage Cards Content';
            advantageEditor.style.display = 'block';
        } else if (this.value === 'info_grid') {
            title.innerText = 'Information Grid Content';
            infoEditor.style.display = 'block';
        }
    });

    function addAdvantageCard() {
        const template = document.getElementById('advantage-card-template').innerHTML;
        const html = template.replace(/INDEX/g, Date.now());
        document.getElementById('cards-list').insertAdjacentHTML('beforeend', html);
    }

    function addInfoItem(type) {
        let index = Date.now();
        const template = document.getElementById('info-item-template').innerHTML;
        const html = template.replace(/INDEX/g, index).replace(/TYPE/g, type);
        document.getElementById(type + '-list').insertAdjacentHTML('beforeend', html);
    }

    window.addEventListener('load', function() {
        if (layoutStyle.value !== 'default') {
            layoutStyle.dispatchEvent(new Event('change'));
        }
    });
