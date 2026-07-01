        $(document).ready(function() {
            $('.summernote-editor').summernote({
                height: 180,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['view', ['codeview']]
                ]
            });
            // ... (Same JS logic as create)
            const closingDateInput = document.getElementById('closing_date');
            const statusSelect = document.getElementById('status');
            const warningToast = document.getElementById('adminWarningToast');
            const warningMessage = document.getElementById('warningMessage');
            function showWarning(msg) { warningMessage.innerText = msg; warningToast.classList.add('show'); setTimeout(() => { warningToast.classList.remove('show'); }, 4000); }
            function isDateInPast(dateStr) { if (!dateStr) return false; const today = new Date(); today.setHours(0, 0, 0, 0); const closingDate = new Date(dateStr); closingDate.setHours(0, 0, 0, 0); return closingDate < today; }
            closingDateInput.addEventListener('change', function() { if (isDateInPast(this.value)) { statusSelect.value = 'closed'; } });
            statusSelect.addEventListener('change', function() { if (this.value === 'open' && isDateInPast(closingDateInput.value)) { this.value = 'closed'; showWarning('Cannot set to OPEN because it\'s past the closing date.'); } });
        });
        function toggleLinkedinCaption(checkbox) { document.getElementById('linkedinCaptionContainer').classList.toggle('d-none', !checkbox.checked); }
        function generateCaption() {
            const title = document.getElementById('title').value || '[Job Title]';
            const location = document.getElementById('location').value || '[Location]';
            const level = document.getElementById('level').value || '[Level]';
            const edu = document.getElementById('min_education').value || '[Education]';
            const exp = document.getElementById('min_experience').value || '[Experience]';
            const deadline = document.getElementById('closing_date').value || '[Closing Date]';
            document.getElementById('linkedin_caption').value = `📢 WE ARE HIRING!\n\n${title.toUpperCase()}\n\n📍 Location: ${location}\n💼 Level: ${level}\n🎓 Education: ${edu}\n⏳ Exp: ${exp}\n📅 Deadline: ${deadline}\n\nApply at:\n${window.__careersUrl}\n\n#Hiring #Recruitment`;
        }
        function previewMedia(event) {
            const container = document.getElementById('mediaPreviewContainer');
            const file = event.target.files[0];
            if (file) {
                container.classList.remove('d-none');
                container.innerHTML = '';
                const reader = new FileReader();
                reader.onload = function(e) {
                    const el = document.createElement(file.type.startsWith('image/') ? 'img' : 'video');
                    el.src = e.target.result;
                    el.className = 'img-fluid rounded shadow-sm';
                    el.style.maxHeight = '250px';
                    if (file.type.startsWith('video/')) el.controls = true;
                    container.appendChild(el);
                }
                reader.readAsDataURL(file);
            }
        }
