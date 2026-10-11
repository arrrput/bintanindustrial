    /**
     * Tenant logo add/edit form.
     * - Dynamic rows (add form): "Add another logo" clones the <template>, up to data-max-rows.
     * - Each row's drop zone accepts click, drag & drop, and Ctrl+V paste (pasted into the active row,
     *   or the first empty row — a new row is added when all rows already have a logo).
     * - The alternative text is pre-filled from the file name when it is still empty.
     */
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('tenantLogoForm');
        if (!form) return;

        const rowsEl = document.getElementById('logoRows');           // add form only
        const template = document.getElementById('logoRowTemplate');  // add form only
        const addBtn = document.getElementById('addLogoRow');
        const countEl = document.getElementById('logoRowCount');
        // Limits come from the server's php.ini (0 = unlimited)
        const maxRows = parseInt(form.dataset.maxRows || '1', 10);
        const maxFileBytes = parseInt(form.dataset.maxFileBytes || '0', 10);
        const maxTotalBytes = parseInt(form.dataset.maxTotalBytes || '0', 10);
        const maxFileHuman = form.dataset.maxFileHuman || '';
        const maxTotalHuman = form.dataset.maxTotalHuman || '';
        let activeRow = null;
        let nextIndex = 0;

        function formatBytes(bytes) {
            const units = ['B', 'KB', 'MB', 'GB'];
            let i = 0;
            while (bytes >= 1024 && i < units.length - 1) { bytes /= 1024; i++; }
            return `${bytes.toFixed(i ? 1 : 0).replace(/\.0$/, '')} ${units[i]}`;
        }

        // A single file larger than the server accepts would be dropped by PHP, so reject it right away
        function tooLarge(file) {
            if (!maxFileBytes || file.size <= maxFileBytes) return false;
            window.AppAlert?.error(
                `"${escapeHtml(file.name || 'The pasted image')}" is ${formatBytes(file.size)}. The server accepts logos up to <b>${maxFileHuman}</b> each.`,
                'File too large'
            );
            return true;
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function clearRow(row) {
            inputOf(row).value = '';
            const preview = row.querySelector('[data-logo-preview]');
            const hint = row.querySelector('[data-logo-hint]');
            // Edit form: keep showing the current logo
            if (preview.dataset.original) {
                preview.src = preview.dataset.original;
            } else {
                preview.classList.add('d-none');
                hint?.classList.remove('d-none');
            }
        }

        const rows = () => Array.from(form.querySelectorAll('[data-logo-row]'));
        const inputOf = row => row.querySelector('[data-logo-input]');

        function setActive(row) {
            rows().forEach(r => r.classList.toggle('is-active', r === row));
            activeRow = row;
        }

        // "PT_Bionesia-logo.png" -> "PT Bionesia logo"
        function nameFromFile(file) {
            if (!file.name || file.name.startsWith('pasted-')) return '';
            return file.name.replace(/\.[^.]+$/, '').replace(/[-_]+/g, ' ').trim();
        }

        function setFile(row, file) {
            if (!file || !file.type.startsWith('image/')) {
                window.AppAlert?.warning('Please choose an image file (JPG, PNG or WEBP).');
                return;
            }
            if (tooLarge(file)) return;
            const input = inputOf(row);
            const dt = new DataTransfer();
            dt.items.add(file);
            input.files = dt.files;
            showPreview(row, file);
        }

        function showPreview(row, file) {
            const preview = row.querySelector('[data-logo-preview]');
            const hint = row.querySelector('[data-logo-hint]');
            if (preview.dataset.objectUrl) URL.revokeObjectURL(preview.dataset.objectUrl);
            const url = URL.createObjectURL(file);
            preview.dataset.objectUrl = url;
            preview.src = url;
            preview.alt = file.name || 'Selected logo';
            preview.classList.remove('d-none');
            hint?.classList.add('d-none');

            const nameInput = row.querySelector('[data-logo-name]');
            if (nameInput && !nameInput.value.trim()) nameInput.value = nameFromFile(file);
        }

        function wireRow(row) {
            const input = inputOf(row);
            const zone = row.querySelector('[data-dropzone]');
            let dragDepth = 0;

            input.addEventListener('change', () => {
                const file = input.files[0];
                if (!file) return;
                if (tooLarge(file)) { clearRow(row); return; }
                showPreview(row, file);
            });

            row.addEventListener('focusin', () => setActive(row));
            row.addEventListener('click', () => setActive(row));

            zone.addEventListener('keydown', e => {
                if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); input.click(); }
            });
            zone.addEventListener('dragenter', e => { e.preventDefault(); dragDepth++; zone.classList.add('is-dragover'); });
            zone.addEventListener('dragover', e => e.preventDefault());
            zone.addEventListener('dragleave', () => { dragDepth = Math.max(0, dragDepth - 1); if (!dragDepth) zone.classList.remove('is-dragover'); });
            zone.addEventListener('drop', e => {
                e.preventDefault();
                dragDepth = 0;
                zone.classList.remove('is-dragover');
                const files = Array.from(e.dataTransfer?.files || []).filter(f => f.type.startsWith('image/'));
                if (!files.length) return;
                setActive(row);
                setFile(row, files[0]);
                // Several images dropped at once: spread them over new rows
                files.slice(1).forEach(file => { const r = addRow(); if (r) setFile(r, file); });
            });

            row.querySelector('[data-remove-row]')?.addEventListener('click', e => {
                e.stopPropagation();
                if (rows().length <= 1) {
                    // Keep one row: just clear it
                    clearRow(row);
                    row.querySelector('[data-logo-name]').value = '';
                    return;
                }
                row.remove();
                if (activeRow === row) setActive(rows()[0]);
                refresh();
            });
        }

        function addRow() {
            if (!template || rows().length >= maxRows) {
                if (template) window.AppAlert?.warning(`The server accepts up to ${maxRows} files per save. Save these first, then add more.`);
                return null;
            }
            const html = template.innerHTML.replace(/__INDEX__/g, String(nextIndex++));
            rowsEl.insertAdjacentHTML('beforeend', html);
            const row = rows()[rows().length - 1];
            wireRow(row);
            setActive(row);
            refresh();
            return row;
        }

        function refresh() {
            if (!addBtn) return;
            const n = rows().length;
            addBtn.disabled = n >= maxRows;
            if (countEl) countEl.textContent = `${n} of ${maxRows} logos`;
        }

        // Ctrl+V: active row if it is still empty, otherwise the first empty row, otherwise a new row
        document.addEventListener('paste', e => {
            const items = Array.from(e.clipboardData?.items || []).filter(i => i.kind === 'file' && i.type.startsWith('image/'));
            if (!items.length) return;
            e.preventDefault();

            items.forEach((item, i) => {
                const blob = item.getAsFile();
                if (!blob) return;
                const ext = (blob.type.split('/')[1] || 'png').replace('jpeg', 'jpg');
                const file = new File([blob], `pasted-${Date.now()}-${i}.${ext}`, { type: blob.type });

                const isEmpty = r => !inputOf(r).files.length;
                let target = activeRow && (isEmpty(activeRow) || !template) ? activeRow : rows().find(isEmpty);
                if (!target) target = addRow();
                if (target) { setActive(target); setFile(target, file); }
            });
        });

        // Before submitting: the whole request must fit the server's post_max_size
        form.addEventListener('submit', e => {
            const files = rows().map(r => inputOf(r).files[0]).filter(Boolean);
            const oversized = files.filter(f => maxFileBytes && f.size > maxFileBytes);
            if (oversized.length) {
                e.preventDefault();
                tooLarge(oversized[0]);
                return;
            }
            const total = files.reduce((sum, f) => sum + f.size, 0);
            // Leave a little room for the text fields and request overhead
            if (maxTotalBytes && total > maxTotalBytes * 0.98) {
                e.preventDefault();
                window.AppAlert?.error(
                    `The selected logos are ${formatBytes(total)} in total, but the server accepts up to <b>${maxTotalHuman}</b> per save. Remove a few rows and save them in a second round.`,
                    'Upload too large'
                );
            }
        });

        // Edit form: remember the current logo so clearing an oversized pick restores it
        form.querySelectorAll('[data-logo-preview]').forEach(img => {
            if (img.getAttribute('src')) img.dataset.original = img.getAttribute('src');
        });

        // Existing rows (one empty row, or rows rebuilt after a validation error)
        rows().forEach(row => {
            wireRow(row);
            const idx = parseInt((inputOf(row).name.match(/\[(\d+)\]/) || [])[1], 10);
            if (!isNaN(idx)) nextIndex = Math.max(nextIndex, idx + 1);
        });
        setActive(rows()[0]);
        addBtn?.addEventListener('click', addRow);
        refresh();
    });
