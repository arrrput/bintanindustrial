    function validateSection(step) {
        const section = document.querySelector(`[data-step="${step}"]`).closest('.card');
        const requiredFields = section.querySelectorAll('.required-field');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (!isValid) {
            alert('Please fill in all required fields before proceeding.');
        }
        return isValid;
    }

    function toggleSection(step) {
        const item = document.querySelector(`.accordion-item:nth-child(${step})`);
        if (item.classList.contains('locked-section')) return;

        const collapseEl = item.querySelector('.collapse');
        const bsCollapse = bootstrap.Collapse.getOrCreateInstance(collapseEl);
        
        if (collapseEl.classList.contains('show')) {
            bsCollapse.hide();
            updateHeaderUI(step, false);
        } else {
            // Close others
            document.querySelectorAll('.collapse.show').forEach(el => {
                const s = el.closest('.accordion-item').querySelector('.section-title-box').dataset.step;
                bootstrap.Collapse.getOrCreateInstance(el).hide();
                updateHeaderUI(s, false);
            });
            bsCollapse.show();
            updateHeaderUI(step, true);
        }
    }

    function nextStep(currentStep) {
        if (validateSection(currentStep)) {
            const nextStepNum = currentStep + 1;
            const nextItem = document.querySelector(`.accordion-item:nth-child(${nextStepNum})`);
            
            // Unlock next section
            if (nextItem) {
                nextItem.classList.remove('locked-section');
                toggleSection(nextStepNum);
            }
        }
    }

    function prevStep(targetStep) {
        toggleSection(targetStep);
    }

    function updateHeaderUI(step, isActive) {
        const box = document.querySelector(`[data-step="${step}"]`);
        if (!box) return;
        const icon = box.querySelector('i:last-child');
        
        if (isActive) {
            box.classList.add('active');
            icon.className = 'fa-solid fa-chevron-down';
        } else {
            box.classList.remove('active');
            icon.className = 'fa-solid fa-chevron-right';
        }
    }

    // Dynamic Address Lines (Removed)
    
    // Dynamic Address Logic
    let addresses = [];
    function showAddressForm() {
        document.getElementById('toggleAddressBtnContainer').classList.add('d-none');
        document.getElementById('addressFormCollapse').classList.remove('d-none');
        resetAddressFormFields();
    }
    function hideAddressForm() {
        if (addresses.length > 0) {
            document.getElementById('addressFormCollapse').classList.add('d-none');
            document.getElementById('toggleAddressBtnContainer').classList.remove('d-none');
        }
    }
    function saveAddress() {
        const country = document.getElementById('addr_country').value;
        const postalCode = document.getElementById('addr_postal_code').value;
        const line = document.getElementById('addr_line').value;
        const cityRegency = document.getElementById('addr_city_regency').value;
        const province = document.getElementById('addr_province').value;

        if(!country || !postalCode || !line || !cityRegency || !province) {
            alert('Please fill in all address fields.'); return;
        }

        const addr = { country, postal_code: postalCode, address_line: line, city_regency: cityRegency, province };
        const editIndex = parseInt(document.getElementById('addr_edit_index').value);

        if (editIndex > -1) addresses[editIndex] = addr;
        else addresses.push(addr);

        renderAddresses();
        hideAddressForm();
    }
    function renderAddresses() {
        const container = document.getElementById('addedAddressesContainer');
        const inputsContainer = document.getElementById('addressInputsContainer');
        if (!container) return;
        container.innerHTML = '';
        inputsContainer.innerHTML = '';

        addresses.forEach((addr, index) => {
            const card = document.createElement('div');
            card.className = 'card mb-3 border border-success-subtle shadow-sm rounded-4';
            card.innerHTML = `
                <div class="card-body p-3 d-flex justify-content-between align-items-center bg-light rounded-4">
                    <div>
                        <h6 class="fw-bold text-success mb-1">${addr.address_line}</h6>
                        <p class="text-muted small mb-0">${addr.city_regency}, ${addr.province} - ${addr.postal_code}</p>
                        <p class="text-muted small mb-0">${addr.country}</p>
                    </div>
                    <div>
                        <button type="button" class="btn btn-sm btn-outline-primary rounded-circle me-1" onclick="editAddress(${index})"><i class="fa-solid fa-pen"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-danger rounded-circle" onclick="deleteAddress(${index})"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
            `;
            container.appendChild(card);
            inputsContainer.innerHTML += `
                <input type="hidden" name="addresses[${index}][country]" value="${addr.country}">
                <input type="hidden" name="addresses[${index}][postal_code]" value="${addr.postal_code}">
                <input type="hidden" name="addresses[${index}][address_line]" value="${addr.address_line}">
                <input type="hidden" name="addresses[${index}][city_regency]" value="${addr.city_regency}">
                <input type="hidden" name="addresses[${index}][province]" value="${addr.province}">
            `;
        });
        if (addresses.length === 0) showAddressForm();
    }
    function editAddress(index) {
        const addr = addresses[index];
        document.getElementById('addr_country').value = addr.country;
        document.getElementById('addr_postal_code').value = addr.postal_code;
        document.getElementById('addr_line').value = addr.address_line;
        document.getElementById('addr_city_regency').value = addr.city_regency;
        document.getElementById('addr_province').value = addr.province;
        document.getElementById('addr_edit_index').value = index;
        document.getElementById('addressFormTitle').innerHTML = '<i class="fa-solid fa-pen me-1"></i> Edit Address';
        document.getElementById('btnCancelAddr').classList.remove('d-none');
        showAddressForm();
    }
    function deleteAddress(index) {
        if(confirm('Delete this address entry?')) {
            addresses.splice(index, 1);
            renderAddresses();
        }
    }
    function cancelAddressForm() { resetAddressFormFields(); hideAddressForm(); }
    function resetAddressFormFields() {
        // Don't reset country, leave default
        document.getElementById('addr_postal_code').value = '';
        document.getElementById('addr_line').value = '';
        document.getElementById('addr_city_regency').value = '';
        document.getElementById('addr_province').value = '';
        document.getElementById('addr_edit_index').value = -1;
        document.getElementById('addressFormTitle').innerHTML = '<i class="fa-solid fa-plus-circle me-1"></i> Add Address';
        document.getElementById('btnCancelAddr').classList.add('d-none');
    }
    function validateAndNextStep2() {
        if (addresses.length === 0) { alert('Add at least one address.'); return; }
        nextStep(2);
    }

    // Dynamic Education Logic
    let educations = [];
    function showEduForm() {
        document.getElementById('toggleEduFormBtnContainer').classList.add('d-none');
        document.getElementById('eduFormCollapse').classList.remove('d-none');
        resetEduFormFields();
    }
    function hideEduForm() {
        if (educations.length > 0) {
            document.getElementById('eduFormCollapse').classList.add('d-none');
            document.getElementById('toggleEduFormBtnContainer').classList.remove('d-none');
        }
    }
    function saveEducation() {
        const degree = document.getElementById('edu_degree').value;
        const major = document.getElementById('edu_major').value;
        const school = document.getElementById('edu_school').value;
        const startDate = document.getElementById('edu_start_date').value;
        const endDate = document.getElementById('edu_end_date').value;
        const country = document.getElementById('edu_country').value;

        if(!degree || !major || !school || !startDate || !endDate || !country) {
            alert('Please fill in all education fields.'); return;
        }

        const edu = { degree, major, school, start_date: startDate, end_date: endDate, country };
        const editIndex = parseInt(document.getElementById('edu_edit_index').value);

        if (editIndex > -1) educations[editIndex] = edu;
        else educations.push(edu);

        renderEducations();
        hideEduForm();
    }
    function renderEducations() {
        const container = document.getElementById('addedEducationsContainer');
        const inputsContainer = document.getElementById('educationInputsContainer');
        if (!container) return;
        container.innerHTML = '';
        inputsContainer.innerHTML = '';

        educations.forEach((edu, index) => {
            const card = document.createElement('div');
            card.className = 'card mb-3 border border-success-subtle shadow-sm rounded-4';
            card.innerHTML = `
                <div class="card-body p-3 d-flex justify-content-between align-items-center bg-light rounded-4">
                    <div>
                        <h6 class="fw-bold text-success mb-1">${edu.degree} in ${edu.major}</h6>
                        <p class="text-muted small mb-0">${edu.school} (${edu.country}) | ${edu.start_date} - ${edu.end_date}</p>
                    </div>
                    <div>
                        <button type="button" class="btn btn-sm btn-outline-primary rounded-circle me-1" onclick="editEducation(${index})"><i class="fa-solid fa-pen"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-danger rounded-circle" onclick="deleteEducation(${index})"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
            `;
            container.appendChild(card);
            inputsContainer.innerHTML += `
                <input type="hidden" name="educations[${index}][degree]" value="${edu.degree}">
                <input type="hidden" name="educations[${index}][major]" value="${edu.major}">
                <input type="hidden" name="educations[${index}][school]" value="${edu.school}">
                <input type="hidden" name="educations[${index}][start_date]" value="${edu.start_date}">
                <input type="hidden" name="educations[${index}][end_date]" value="${edu.end_date}">
                <input type="hidden" name="educations[${index}][country]" value="${edu.country}">
            `;
        });
        if (educations.length === 0) showEduForm();
    }
    function editEducation(index) {
        const edu = educations[index];
        document.getElementById('edu_degree').value = edu.degree;
        document.getElementById('edu_major').value = edu.major;
        document.getElementById('edu_school').value = edu.school;
        document.getElementById('edu_start_date').value = edu.start_date;
        document.getElementById('edu_end_date').value = edu.end_date;
        document.getElementById('edu_country').value = edu.country;
        document.getElementById('edu_edit_index').value = index;
        document.getElementById('eduFormTitle').innerHTML = '<i class="fa-solid fa-pen me-1"></i> Edit Education';
        document.getElementById('btnCancelEdu').classList.remove('d-none');
        showEduForm();
    }
    function deleteEducation(index) {
        if(confirm('Delete this education entry?')) {
            educations.splice(index, 1);
            renderEducations();
        }
    }
    function cancelEduForm() { resetEduFormFields(); hideEduForm(); }
    function resetEduFormFields() {
        document.getElementById('edu_degree').value = '';
        document.getElementById('edu_major').value = '';
        document.getElementById('edu_school').value = '';
        document.getElementById('edu_start_date').value = '';
        document.getElementById('edu_end_date').value = '';
        document.getElementById('edu_country').value = '';
        document.getElementById('edu_edit_index').value = -1;
        document.getElementById('eduFormTitle').innerHTML = '<i class="fa-solid fa-plus-circle me-1"></i> Add Education';
        document.getElementById('btnCancelEdu').classList.add('d-none');
    }
    function validateAndNextStep3() {
        if (educations.length === 0) { alert('Add at least one education.'); return; }
        nextStep(3);
    }

    // Dynamic Experience Logic
    let experiences = [];
    function showExpForm() {
        document.getElementById('toggleExpBtnContainer').classList.add('d-none');
        document.getElementById('expFormCollapse').classList.remove('d-none');
        resetExpFormFields();
    }
    function hideExpForm() {
        if (experiences.length > 0) {
            document.getElementById('expFormCollapse').classList.add('d-none');
            document.getElementById('toggleExpBtnContainer').classList.remove('d-none');
        }
    }
    function saveExperience() {
        const title = document.getElementById('exp_job_title').value;
        const company = document.getElementById('exp_company').value;
        const city = document.getElementById('exp_city').value;
        const typeBusiness = document.getElementById('exp_type_business').value;
        const startDate = document.getElementById('exp_start_date').value;
        const endDate = document.getElementById('exp_end_date').value;
        const desc = document.getElementById('exp_job_desc').value;

        if(!title || !company || !startDate) {
            alert('Job Title, Company, and Start Date are required.'); return;
        }

        const exp = { job_title: title, company, city, type_business: typeBusiness, start_date: startDate, end_date: endDate, job_desc: desc };
        const editIndex = parseInt(document.getElementById('exp_edit_index').value);

        if (editIndex > -1) experiences[editIndex] = exp;
        else experiences.push(exp);

        renderExperiences();
        hideExpForm();
    }
    function renderExperiences() {
        const container = document.getElementById('addedExpContainer');
        const inputsContainer = document.getElementById('expInputsContainer');
        container.innerHTML = '';
        inputsContainer.innerHTML = '';

        experiences.forEach((exp, index) => {
            const card = document.createElement('div');
            card.className = 'card mb-3 border border-success-subtle shadow-sm rounded-4';
            card.innerHTML = `
                <div class="card-body p-3 d-flex justify-content-between align-items-center bg-light rounded-4">
                    <div>
                        <h6 class="fw-bold text-success mb-1">${exp.job_title}</h6>
                        <p class="text-muted small mb-0">${exp.company} (${exp.city || '-'}) - ${exp.type_business || 'N/A'} | ${exp.start_date} - ${exp.end_date || 'Present'}</p>
                    </div>
                    <div>
                        <button type="button" class="btn btn-sm btn-outline-primary rounded-circle me-1" onclick="editExperience(${index})"><i class="fa-solid fa-pen"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-danger rounded-circle" onclick="deleteExperience(${index})"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
            `;
            container.appendChild(card);
            inputsContainer.innerHTML += `
                <input type="hidden" name="experiences[${index}][job_title]" value="${exp.job_title}">
                <input type="hidden" name="experiences[${index}][company]" value="${exp.company}">
                <input type="hidden" name="experiences[${index}][city]" value="${exp.city}">
                <input type="hidden" name="experiences[${index}][type_business]" value="${exp.type_business}">
                <input type="hidden" name="experiences[${index}][start_date]" value="${exp.start_date}">
                <input type="hidden" name="experiences[${index}][end_date]" value="${exp.end_date}">
                <input type="hidden" name="experiences[${index}][job_desc]" value="${exp.job_desc}">
            `;
        });
        if (experiences.length === 0) showExpForm();
    }
    function editExperience(index) {
        const exp = experiences[index];
        document.getElementById('exp_job_title').value = exp.job_title;
        document.getElementById('exp_company').value = exp.company;
        document.getElementById('exp_city').value = exp.city;
        document.getElementById('exp_type_business').value = exp.type_business || '';
        document.getElementById('exp_start_date').value = exp.start_date;
        document.getElementById('exp_end_date').value = exp.end_date;
        document.getElementById('exp_job_desc').value = exp.job_desc;
        document.getElementById('exp_edit_index').value = index;
        document.getElementById('expFormTitle').innerHTML = '<i class="fa-solid fa-pen me-1"></i> Edit Experience';
        document.getElementById('btnCancelExp').classList.remove('d-none');
        showExpForm();
    }
    function deleteExperience(index) {
        if(confirm('Delete this experience?')) {
            experiences.splice(index, 1);
            renderExperiences();
        }
    }
    function cancelExpForm() { resetExpFormFields(); hideExpForm(); }
    function resetExpFormFields() {
        document.getElementById('exp_job_title').value = '';
        document.getElementById('exp_company').value = '';
        document.getElementById('exp_city').value = '';
        document.getElementById('exp_type_business').value = '';
        document.getElementById('exp_start_date').value = '';
        document.getElementById('exp_end_date').value = '';
        document.getElementById('exp_job_desc').value = '';
        document.getElementById('exp_edit_index').value = -1;
        document.getElementById('expFormTitle').innerHTML = '<i class="fa-solid fa-plus-circle me-1"></i> Add Work Experience';
        document.getElementById('btnCancelExp').classList.add('d-none');
    }

    // Dynamic Certification Logic
    let certifications = [];
    function showCertForm() {
        document.getElementById('toggleCertBtnContainer').classList.add('d-none');
        document.getElementById('certFormCollapse').classList.remove('d-none');
        resetCertFormFields();
    }
    function hideCertForm() {
        if (certifications.length > 0) {
            document.getElementById('certFormCollapse').classList.add('d-none');
            document.getElementById('toggleCertBtnContainer').classList.remove('d-none');
        }
    }
    function saveCertification() {
        const name = document.getElementById('cert_name').value;
        const issuedBy = document.getElementById('cert_issued_by').value;
        const issuedDate = document.getElementById('cert_issued_date').value;
        const expirationDate = document.getElementById('cert_expiration_date').value;

        if(!name || !issuedBy || !issuedDate) {
            alert('Certificate Name, Issued By, and Issued Date are required.'); return;
        }

        const cert = { name, issued_by: issuedBy, issued_date: issuedDate, expiration_date: expirationDate };
        const editIndex = parseInt(document.getElementById('cert_edit_index').value);

        if (editIndex > -1) certifications[editIndex] = cert;
        else certifications.push(cert);

        renderCertifications();
        hideCertForm();
    }
    function renderCertifications() {
        const container = document.getElementById('addedCertContainer');
        const inputsContainer = document.getElementById('certInputsContainer');
        if (!container) return;
        container.innerHTML = '';
        inputsContainer.innerHTML = '';

        certifications.forEach((cert, index) => {
            const card = document.createElement('div');
            card.className = 'card mb-3 border border-success-subtle shadow-sm rounded-4';
            card.innerHTML = `
                <div class="card-body p-3 d-flex justify-content-between align-items-center bg-light rounded-4">
                    <div>
                        <h6 class="fw-bold text-success mb-1">${cert.name}</h6>
                        <p class="text-muted small mb-0">${cert.issued_by} | ${cert.issued_date} - ${cert.expiration_date || 'No Expiry'}</p>
                    </div>
                    <div>
                        <button type="button" class="btn btn-sm btn-outline-primary rounded-circle me-1" onclick="editCertification(${index})"><i class="fa-solid fa-pen"></i></button>
                        <button type="button" class="btn btn-sm btn-outline-danger rounded-circle" onclick="deleteCertification(${index})"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
            `;
            container.appendChild(card);
            inputsContainer.innerHTML += `
                <input type="hidden" name="certifications[${index}][name]" value="${cert.name}">
                <input type="hidden" name="certifications[${index}][issued_by]" value="${cert.issued_by}">
                <input type="hidden" name="certifications[${index}][issued_date]" value="${cert.issued_date}">
                <input type="hidden" name="certifications[${index}][expiration_date]" value="${cert.expiration_date}">
            `;
        });
        if (certifications.length === 0) showCertForm();
    }
    function editCertification(index) {
        const cert = certifications[index];
        document.getElementById('cert_name').value = cert.name;
        document.getElementById('cert_issued_by').value = cert.issued_by;
        document.getElementById('cert_issued_date').value = cert.issued_date;
        document.getElementById('cert_expiration_date').value = cert.expiration_date;
        document.getElementById('cert_edit_index').value = index;
        document.getElementById('certFormTitle').innerHTML = '<i class="fa-solid fa-pen me-1"></i> Edit Certification';
        document.getElementById('btnCancelCert').classList.remove('d-none');
        showCertForm();
    }
    function deleteCertification(index) {
        if(confirm('Delete this certification?')) {
            certifications.splice(index, 1);
            renderCertifications();
        }
    }
    function cancelCertForm() { resetCertFormFields(); hideCertForm(); }
    function resetCertFormFields() {
        document.getElementById('cert_name').value = '';
        document.getElementById('cert_issued_by').value = '';
        document.getElementById('cert_issued_date').value = '';
        document.getElementById('cert_expiration_date').value = '';
        document.getElementById('cert_edit_index').value = -1;
        document.getElementById('certFormTitle').innerHTML = '<i class="fa-solid fa-plus-circle me-1"></i> Add Certification';
        document.getElementById('btnCancelCert').classList.add('d-none');
    }

    document.addEventListener('DOMContentLoaded', function() {
        renderEducations();
        renderExperiences();
        renderCertifications();
        const phoneCodeSelect = document.getElementById('phone_code');
        const countryInput = document.getElementById('country_input');
        phoneCodeSelect.addEventListener('change', () => {
            countryInput.value = phoneCodeSelect.value === '+62' ? 'Indonesia' : 'Singapore';
        });
    });
