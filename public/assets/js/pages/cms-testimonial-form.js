document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById('testimonialForm');
    const input = document.getElementById('testimonialPhotoInput');
    const preview = document.getElementById('testimonialPhotoPreview');
    if (!form || !input) return;

    const csrfToken = form.querySelector('input[name="_token"]')?.value;
    const COMPRESS_QUALITY = 0.6;              // 60% quality
    const MAX_DIMENSION = 1000;                // cap the longest side (px)
    const MAX_ORIGINAL_SIZE = 2 * 1024 * 1024; // 2MB — only files above this get compressed

    // Compress an image File/Blob into a WebP blob at 60% quality.
    function compressImage(file) {
        return new Promise((resolve, reject) => {
            if (!file.type.startsWith('image/')) {
                return reject(new Error(`${file.name || 'File'} is not an image.`));
            }
            const img = new Image();
            const objectUrl = URL.createObjectURL(file);
            img.onload = () => {
                URL.revokeObjectURL(objectUrl);
                let width = img.naturalWidth;
                let height = img.naturalHeight;
                if (width > MAX_DIMENSION || height > MAX_DIMENSION) {
                    const scale = MAX_DIMENSION / Math.max(width, height);
                    width = Math.round(width * scale);
                    height = Math.round(height * scale);
                }
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

    // Only compress when the file is bigger than 2MB; otherwise keep it untouched.
    async function prepareFile(file) {
        if (!file || file.size <= MAX_ORIGINAL_SIZE) return file;
        try {
            const blob = await compressImage(file);
            const baseName = (file.name || 'photo').replace(/\.[^.]+$/, '');
            return new File([blob], `${baseName}.webp`, { type: 'image/webp' });
        } catch (e) {
            return file; // fall back to the original if compression fails
        }
    }

    // Render a 1:1 (square) preview of the chosen/pasted photo.
    function renderPreview(file) {
        if (!preview) return;
        if (preview.dataset.url) {
            URL.revokeObjectURL(preview.dataset.url);
            delete preview.dataset.url;
        }
        if (!file || !file.type.startsWith('image/')) {
            preview.innerHTML = '';
            return;
        }
        const url = URL.createObjectURL(file);
        preview.dataset.url = url;
        preview.innerHTML = `
            <div class="d-inline-block position-relative">
                <div class="border rounded-3 overflow-hidden shadow-sm" style="width:140px;aspect-ratio:1/1;">
                    <img src="${url}" style="width:100%;height:100%;object-fit:cover;">
                </div>
                <button type="button" id="testimonialPhotoRemove" class="btn btn-danger btn-sm rounded-circle d-flex align-items-center justify-content-center shadow position-absolute" style="width:25px;height:25px;top:-8px;right:-8px;">
                    <i class="fa-solid fa-xmark" style="font-size:0.7rem;"></i>
                </button>
            </div>`;
    }

    input.addEventListener('change', () => renderPreview(input.files[0]));

    // Red X on the preview clears the chosen/pasted photo.
    if (preview) {
        preview.addEventListener('click', (e) => {
            if (e.target.closest('#testimonialPhotoRemove')) {
                input.value = '';
                renderPreview(null);
            }
        });
    }

    // Ctrl + V paste support — drop the pasted image into the photo input.
    document.addEventListener('paste', (e) => {
        const items = e.clipboardData && e.clipboardData.items;
        if (!items) return;
        for (const item of items) {
            if (item.kind === 'file' && item.type.startsWith('image/')) {
                const file = item.getAsFile();
                if (file) {
                    const dt = new DataTransfer();
                    dt.items.add(file);
                    input.files = dt.files;
                    input.dispatchEvent(new Event('change'));
                    e.preventDefault();
                }
                break;
            }
        }
    });

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        Swal.fire({
            title: 'Saving...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading(),
        });

        try {
            const formData = new FormData(form);
            const file = input.files[0];
            if (file) {
                const prepared = await prepareFile(file);
                formData.set('photo', prepared, prepared.name);
            }

            const res = await fetch(form.getAttribute('action'), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const data = await res.json().catch(() => ({}));

            if (!res.ok) {
                const msg = data.message
                    || (data.errors ? Object.values(data.errors).flat().join('\n') : 'Something went wrong.');
                throw new Error(msg);
            }

            await Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message || 'Saved successfully!',
                timer: 1600,
                showConfirmButton: false,
            });
            window.location = data.redirect || document.referrer || '/';
        } catch (err) {
            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: err.message || 'Something went wrong while saving.',
            });
        }
    });
});
