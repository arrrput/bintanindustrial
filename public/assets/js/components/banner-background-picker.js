  // Banner background picker for CMS section-settings forms (.js-banner-bg-form):
  // toggles the Image / Solid Color panels and keeps the color picker, hex input and preview in sync.
  document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.js-banner-bg-form').forEach(form => {
        const radios = form.querySelectorAll('input[name="background_type"]');
        const panels = form.querySelectorAll('[data-bg-panel]');
        const picker = form.querySelector('.js-bg-color-picker');
        const hexInput = form.querySelector('.js-bg-color-hex');
        const preview = form.querySelector('.js-bg-color-preview');
        const titleInput = form.querySelector('input[name="title"]');
        const isHex = value => /^#[0-9a-fA-F]{6}$/.test(value);

        function showPanel() {
            const type = form.querySelector('input[name="background_type"]:checked')?.value || 'image';
            panels.forEach(panel => panel.classList.toggle('d-none', panel.dataset.bgPanel !== type));
            // The hex field is only submitted (and validated) in color mode.
            if (hexInput) hexInput.disabled = type !== 'color';
        }

        // Same threshold as partials/section-header-overlay: dark title on light colors.
        function applyColor(hex) {
            if (!isHex(hex)) return;
            if (picker) picker.value = hex;
            if (preview) {
                const r = parseInt(hex.substr(1, 2), 16);
                const g = parseInt(hex.substr(3, 2), 16);
                const b = parseInt(hex.substr(5, 2), 16);
                preview.style.background = hex;
                preview.style.color = (0.299 * r + 0.587 * g + 0.114 * b) > 160 ? '#222222' : '#ffffff';
            }
        }

        radios.forEach(radio => radio.addEventListener('change', showPanel));

        picker?.addEventListener('input', () => {
            hexInput.value = picker.value;
            applyColor(picker.value);
        });

        hexInput?.addEventListener('input', () => {
            let value = hexInput.value.trim();
            if (value && value[0] !== '#') value = '#' + value;
            applyColor(value);
        });

        form.querySelectorAll('.js-bg-color-swatch').forEach(swatch => {
            swatch.addEventListener('click', () => {
                hexInput.value = swatch.dataset.color;
                applyColor(swatch.dataset.color);
            });
        });

        form.addEventListener('submit', () => {
            if (hexInput && hexInput.value && hexInput.value[0] !== '#') hexInput.value = '#' + hexInput.value.trim();
        });

        function syncPreviewTitle() {
            if (preview && titleInput) preview.textContent = titleInput.value || titleInput.placeholder;
        }
        titleInput?.addEventListener('input', syncPreviewTitle);

        syncPreviewTitle();
        showPanel();
        applyColor(hexInput?.value || '');
    });
  });
