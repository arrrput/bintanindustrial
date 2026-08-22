/**
 * CMS image upload helpers, shared across every upload form:
 *  - Paste (Ctrl+V) and drag & drop into any image file input.
 *  - An automatic thumbnail preview for inputs that don't already render
 *    their own (forms that have a bespoke preview — testimonials, blogs,
 *    careers media, tenant logos — are left alone and skipped).
 *  - A click-to-view-full-size lightbox for every image inside the CMS
 *    (both freshly chosen files and already-saved ones).
 *
 * The first image input on the page is the paste target by default (so
 * paste works immediately, no click required); focusing/clicking a
 * different input re-targets paste to that one instead.
 */
(function () {
    let activeFileInput = null;

    function isImageInput(input) {
        return (input.getAttribute('accept') || '').toLowerCase().includes('image');
    }

    function acceptsVideo(input) {
        return (input.getAttribute('accept') || '').toLowerCase().includes('video');
    }

    function buildFileList(input, incomingFiles) {
        const dataTransfer = new DataTransfer();

        if (input.multiple) {
            Array.from(input.files).forEach(function (existing) {
                dataTransfer.items.add(existing);
            });
        }

        incomingFiles.forEach(function (file) {
            dataTransfer.items.add(file);
        });

        return dataTransfer.files;
    }

    function applyFiles(input, files) {
        input.files = buildFileList(input, files);
        input.dispatchEvent(new Event('change', { bubbles: true }));
    }

    // Forms that already render their own preview UI for the chosen file(s).
    // Inputs inside these forms are skipped by the generic auto-preview below.
    function hasDedicatedPreview(input) {
        const scope = input.closest('form') || document;
        return !!scope.querySelector('#testimonialPhotoPreview, #previewContainer, #mediaPreviewContainer, #tenantPreview');
    }

    function renderAutoPreview(input, container) {
        container.innerHTML = '';
        Array.from(input.files).forEach(function (file) {
            if (!file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = file.name || 'Selected image';
                img.className = 'rounded border shadow-sm';
                img.style.cssText = 'width:80px;height:80px;object-fit:cover;';
                container.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('input[type="file"]').forEach(function (input) {
            if (!isImageInput(input)) return;

            // Default to the first image input on the page so paste works
            // right away, even before the user clicks/focuses anything.
            if (!activeFileInput) activeFileInput = input;

            input.addEventListener('focus', function () { activeFileInput = input; });
            input.addEventListener('click', function () { activeFileInput = input; });

            const dropZone = input.parentElement;
            if (!dropZone) return;

            dropZone.classList.add('js-image-dropzone');
            let dragCounter = 0;

            dropZone.addEventListener('dragenter', function (e) {
                e.preventDefault();
                dragCounter++;
                dropZone.classList.add('is-dragover');
            });

            dropZone.addEventListener('dragover', function (e) {
                e.preventDefault();
            });

            dropZone.addEventListener('dragleave', function (e) {
                e.preventDefault();
                dragCounter = Math.max(0, dragCounter - 1);
                if (dragCounter === 0) dropZone.classList.remove('is-dragover');
            });

            dropZone.addEventListener('drop', function (e) {
                e.preventDefault();
                dragCounter = 0;
                dropZone.classList.remove('is-dragover');

                const dropped = Array.from((e.dataTransfer && e.dataTransfer.files) || []).filter(function (file) {
                    return file.type.startsWith('image/') || (acceptsVideo(input) && file.type.startsWith('video/'));
                });
                if (dropped.length === 0) return;

                activeFileInput = input;
                applyFiles(input, dropped);
            });

            if (!hasDedicatedPreview(input)) {
                // Inserted right after the input itself (not the drop zone
                // wrapper), so it stays inside whatever container/grid
                // column the input already lives in instead of breaking
                // out of it.
                const autoPreview = document.createElement('div');
                autoPreview.className = 'js-auto-preview mt-2 d-flex flex-wrap gap-2';
                input.insertAdjacentElement('afterend', autoPreview);
                input.addEventListener('change', function () {
                    renderAutoPreview(input, autoPreview);
                });
            }
        });
    });

    document.addEventListener('paste', function (e) {
        if (!activeFileInput || !document.contains(activeFileInput)) return;

        const items = (e.clipboardData || window.clipboardData || {}).items;
        if (!items) return;

        const imageItems = Array.from(items).filter(function (item) {
            return item.kind === 'file' && item.type.startsWith('image/');
        });
        if (imageItems.length === 0) return;

        e.preventDefault();

        const files = imageItems.map(function (item, index) {
            const blob = item.getAsFile();
            if (!blob) return null;
            const extension = (blob.type.split('/')[1] || 'png').replace('jpeg', 'jpg');
            return new File([blob], 'pasted-' + Date.now() + '-' + index + '.' + extension, { type: blob.type });
        }).filter(Boolean);

        if (files.length === 0) return;

        applyFiles(activeFileInput, files);
    });

    // --- Click-to-view-full-size lightbox, CMS pages only ---
    if (location.pathname.indexOf('/cms') === 0) {
        const cursorStyle = document.createElement('style');
        cursorStyle.textContent = 'main.main img { cursor: zoom-in; }';
        document.head.appendChild(cursorStyle);

        let overlay = null;

        function openLightbox(src) {
            if (!overlay) {
                overlay = document.createElement('div');
                overlay.id = 'cms-image-lightbox';
                overlay.innerHTML = '<img alt="Full size preview">';
                document.body.appendChild(overlay);
                overlay.addEventListener('click', closeLightbox);
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') closeLightbox();
                });
            }
            overlay.querySelector('img').src = src;
            overlay.classList.add('is-open');
        }

        function closeLightbox() {
            if (overlay) overlay.classList.remove('is-open');
        }

        document.addEventListener('click', function (e) {
            const img = e.target.closest('main.main img');
            if (!img) return;
            openLightbox(img.currentSrc || img.src);
        });
    }
})();
