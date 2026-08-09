    document.addEventListener("DOMContentLoaded", function() {
        const toast = document.getElementById('adminSuccessToast');
        if (toast) {
            setTimeout(() => { toast.classList.add('show'); }, 100);
            setTimeout(() => { toast.classList.remove('show'); }, 3000);
        }

        // Delete a testimonial without reloading (SweetAlert confirm + AJAX),
        // so it stays consistent with the tenant-logo flow.
        const testimonialBody = document.getElementById('testimonialTableBody');
        if (testimonialBody) {
            testimonialBody.addEventListener('submit', async (e) => {
                const delForm = e.target.closest('form.js-delete-testimonial');
                if (!delForm) return;
                e.preventDefault();

                const confirmRes = await Swal.fire({
                    title: 'Delete this testimonial?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete',
                    confirmButtonColor: '#d33',
                    cancelButtonText: 'Cancel',
                });
                if (!confirmRes.isConfirmed) return;

                try {
                    const res = await fetch(delForm.getAttribute('action'), {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': delForm.querySelector('input[name="_token"]')?.value,
                            'Accept': 'application/json',
                        },
                        body: new FormData(delForm), // carries _token and _method=DELETE
                    });

                    const data = await res.json().catch(() => ({}));
                    if (!res.ok) throw new Error(data.message || 'Delete failed.');

                    const row = delForm.closest('[data-testimonial-id]');
                    if (row) row.remove();

                    if (!testimonialBody.querySelector('[data-testimonial-id]')) {
                        testimonialBody.innerHTML = '<tr><td colspan="5" class="text-center py-5 text-muted">No testimonials found.</td></tr>';
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted',
                        text: data.message || 'Testimonial deleted.',
                        timer: 1300,
                        showConfirmButton: false,
                    });
                } catch (err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: err.message || 'Something went wrong while deleting.',
                    });
                }
            });
        }

        const form = document.getElementById('tenantUploadForm');
        const input = document.getElementById('tenantLogosInput');
        const preview = document.getElementById('tenantPreview');
        const submitWrap = document.getElementById('tenantSubmitWrap');
        const uploadBtn = document.getElementById('tenantUploadBtn');
        const clearBtn = document.getElementById('tenantClearBtn');
        const countEl = document.getElementById('tenantCount');
        if (!form || !input || !preview) return;

        const uploadUrl = form.getAttribute('action');
        const csrfToken = form.querySelector('input[name="_token"]')?.value;
        const COMPRESS_QUALITY = 0.6;              // 60% quality
        const MAX_DIMENSION = 1000;                // cap the longest side (px) to keep logos light
        const MAX_ORIGINAL_SIZE = 2 * 1024 * 1024; // 2MB — only files above this get compressed

        // Staged files waiting to be uploaded: [{ file, url }]
        let staged = [];

        // Compress a single image File/Blob into a WebP blob at 60% quality.
        // WebP keeps transparency, which matters for logos.
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

        // Compress only when the file is bigger than 2MB; otherwise upload it untouched.
        async function prepareFile(file) {
            if (file.size <= MAX_ORIGINAL_SIZE) return file;
            try {
                const blob = await compressImage(file);
                const baseName = (file.name || 'pasted-logo').replace(/\.[^.]+$/, '');
                return new File([blob], `${baseName}.webp`, { type: 'image/webp' });
            } catch (e) {
                return file; // fall back to the original if compression fails
            }
        }

        // Add newly selected/pasted images to the staging list.
        function addFiles(files) {
            const imageFiles = Array.from(files).filter(f => f.type.startsWith('image/'));
            imageFiles.forEach(file => {
                staged.push({ file, url: URL.createObjectURL(file) });
            });
            renderPreview();
        }

        function removeAt(index) {
            const item = staged[index];
            if (item) URL.revokeObjectURL(item.url);
            staged.splice(index, 1);
            renderPreview();
        }

        function clearStaged() {
            staged.forEach(item => URL.revokeObjectURL(item.url));
            staged = [];
            renderPreview();
        }

        function renderPreview() {
            preview.innerHTML = staged.map((item, i) => `
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden position-relative" style="background:#f8f9fa;">
                        <div class="p-3 d-flex align-items-center justify-content-center" style="height:100px;">
                            <img src="${item.url}" class="img-fluid" style="max-height:60px;object-fit:contain;">
                        </div>
                        <div class="position-absolute top-0 end-0 p-2">
                            <button type="button" class="btn btn-danger btn-sm rounded-circle d-flex align-items-center justify-content-center shadow" style="width:25px;height:25px;" data-index="${i}">
                                <i class="fa-solid fa-xmark" style="font-size:0.7rem;"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');

            const hasFiles = staged.length > 0;
            submitWrap.classList.toggle('d-none', !hasFiles);
            if (countEl) countEl.textContent = hasFiles ? `(${staged.length})` : '';
        }

        async function uploadStaged() {
            if (staged.length === 0) return;

            Swal.fire({
                title: 'Uploading...',
                html: `Processing and uploading ${staged.length} logo(s)`,
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading(),
            });

            try {
                const formData = new FormData();
                for (const item of staged) {
                    const prepared = await prepareFile(item.file);
                    formData.append('logos[]', prepared, prepared.name || 'pasted-logo.png');
                }

                const res = await fetch(uploadUrl, {
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
                        || (data.errors ? Object.values(data.errors).flat().join('\n') : 'Upload failed.');
                    throw new Error(msg);
                }

                await Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message || 'Tenant logos uploaded successfully!',
                    timer: 1600,
                    showConfirmButton: false,
                });
                window.location.reload();
            } catch (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Upload failed',
                    text: err.message || 'Something went wrong while uploading.',
                });
            }
        }

        // Browse / drag-and-drop selection — stage, don't upload yet.
        input.addEventListener('change', () => {
            if (input.files.length) addFiles(input.files);
            input.value = ''; // allow re-selecting the same file
        });

        // Ctrl + V paste — stage, don't upload yet.
        document.addEventListener('paste', (e) => {
            const items = e.clipboardData && e.clipboardData.items;
            if (!items) return;
            const files = [];
            for (const item of items) {
                if (item.kind === 'file' && item.type.startsWith('image/')) {
                    const file = item.getAsFile();
                    if (file) files.push(file);
                }
            }
            if (files.length) {
                e.preventDefault();
                addFiles(files);
            }
        });

        // Remove a single staged thumbnail (event delegation).
        preview.addEventListener('click', (e) => {
            const btn = e.target.closest('button[data-index]');
            if (!btn) return;
            removeAt(parseInt(btn.dataset.index, 10));
        });

        uploadBtn?.addEventListener('click', uploadStaged);
        clearBtn?.addEventListener('click', clearStaged);

        // Delete an already-uploaded logo without reloading the whole page,
        // so a user mid-upload doesn't lose their staged preview.
        const tenantList = document.getElementById('tenantList');
        if (tenantList) {
            tenantList.addEventListener('submit', async (e) => {
                const delForm = e.target.closest('form.js-delete-tenant');
                if (!delForm) return;
                e.preventDefault();

                const confirmRes = await Swal.fire({
                    title: 'Delete this logo?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete',
                    confirmButtonColor: '#d33',
                    cancelButtonText: 'Cancel',
                });
                if (!confirmRes.isConfirmed) return;

                try {
                    const res = await fetch(delForm.getAttribute('action'), {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': delForm.querySelector('input[name="_token"]')?.value,
                            'Accept': 'application/json',
                        },
                        body: new FormData(delForm), // carries _token and _method=DELETE
                    });

                    const data = await res.json().catch(() => ({}));
                    if (!res.ok) throw new Error(data.message || 'Delete failed.');

                    const col = delForm.closest('[data-tenant-id]');
                    if (col) col.remove();

                    if (!tenantList.querySelector('[data-tenant-id]')) {
                        tenantList.innerHTML = '<div class="col-12 text-center py-4 text-muted small" id="tenantEmpty">No tenant logos uploaded yet.</div>';
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted',
                        text: data.message || 'Tenant logo deleted.',
                        timer: 1300,
                        showConfirmButton: false,
                    });
                } catch (err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: err.message || 'Something went wrong while deleting.',
                    });
                }
            });
        }
    });
