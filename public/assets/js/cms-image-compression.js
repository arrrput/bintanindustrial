/**
 * Global client-side image compression for CMS upload forms.
 *
 * Every plain (non-AJAX) form that contains an image file input gets this
 * automatically: on submit, any selected image over 2MB is re-encoded as
 * WebP at 80% quality (original dimensions kept) before the form actually
 * posts. Non-image files (e.g. the video option on the career "media"
 * field) and small images are left untouched.
 *
 * Forms that already implement their own compression via an AJAX submit
 * (testimonial photo, tenant logos on the home page) are skipped here so
 * they aren't double-handled.
 */
(function () {
    const COMPRESS_QUALITY = 0.8;              // 80% quality
    const MAX_ORIGINAL_SIZE = 2 * 1024 * 1024; // 2MB — only files above this get compressed

    const SKIP_FORM_IDS = ['testimonialForm', 'tenantUploadForm'];

    function compressImage(file) {
        return new Promise((resolve, reject) => {
            const img = new Image();
            const objectUrl = URL.createObjectURL(file);
            img.onload = () => {
                URL.revokeObjectURL(objectUrl);
                const width = img.naturalWidth;
                const height = img.naturalHeight;
                const canvas = document.createElement('canvas');
                canvas.width = width;
                canvas.height = height;
                canvas.getContext('2d').drawImage(img, 0, 0, width, height);
                canvas.toBlob(
                    (blob) => blob ? resolve(blob) : reject(new Error('Compression failed.')),
                    'image/webp',
                    COMPRESS_QUALITY
                );
            };
            img.onerror = () => {
                URL.revokeObjectURL(objectUrl);
                reject(new Error(`Could not read ${file.name || 'the image'}.`));
            };
            img.src = objectUrl;
        });
    }

    // Only compress actual images bigger than 2MB; everything else passes through untouched.
    async function prepareFile(file) {
        if (!file.type.startsWith('image/') || file.size <= MAX_ORIGINAL_SIZE) return file;
        try {
            const blob = await compressImage(file);
            const baseName = (file.name || 'image').replace(/\.[^.]+$/, '');
            return new File([blob], `${baseName}.webp`, { type: 'image/webp' });
        } catch (e) {
            return file; // fall back to the original if compression fails
        }
    }

    function findImageFileInputs(form) {
        return Array.from(form.querySelectorAll('input[type="file"]')).filter(function (input) {
            return (input.getAttribute('accept') || '').toLowerCase().includes('image');
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('form').forEach(function (form) {
            if (SKIP_FORM_IDS.includes(form.id)) return;

            const fileInputs = findImageFileInputs(form);
            if (fileInputs.length === 0) return;

            form.addEventListener('submit', function (e) {
                const hasFiles = fileInputs.some((input) => input.files && input.files.length > 0);
                if (!hasFiles) return; // nothing selected, let the browser submit normally

                e.preventDefault();

                const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Processing...';
                }

                const finish = () => form.submit(); // bypasses this listener — no re-entrancy

                Promise.all(fileInputs.map(async function (input) {
                    if (!input.files || input.files.length === 0) return;
                    const prepared = await Promise.all(Array.from(input.files).map(prepareFile));
                    const dataTransfer = new DataTransfer();
                    prepared.forEach((f) => dataTransfer.items.add(f));
                    input.files = dataTransfer.files;
                })).then(finish).catch(finish);
            });
        });
    });
})();
