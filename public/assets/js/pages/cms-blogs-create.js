    // Auto-slug
    document.getElementById('title').addEventListener('keyup', function() {
        document.getElementById('slug').value = this.value.toLowerCase().replace(/[^\w\s-]/g, '').replace(/[\s_-]+/g, '-').replace(/^-+|-+$/g, '');
    });

    function previewImages(event) {
        const container = document.getElementById("previewContainer");
        container.innerHTML = "";
        Array.from(event.target.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.createElement("img");
                img.src = e.target.result;
                img.style.width = "80px"; img.style.height = "80px"; img.style.objectFit = "cover";
                img.classList.add("rounded", "border", "shadow-sm");
                container.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    }
