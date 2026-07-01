@extends('layouts.main')

@section('title', 'Application Form - ' . $career->title)

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/pages/careers-apply.css') }}">
@endpush

@section('content')
<div class="apply-header">
    <div class="container" data-aos="fade-up">
        <h2 class="fw-bold mb-2">Application Form</h2>
        <p class="mb-0 text-white-50">Applying for: <span class="text-white fw-bold">{{ $career->title }}</span></p>
    </div>
</div>

<div class="container mt-4 mt-md-5 mb-5 pb-5">
    <form action="{{ route('careers.apply.post', $career->slug) }}" method="POST" enctype="multipart/form-data" id="multiStepForm">
        @csrf
        
        <div class="row justify-content-center">
            <div class="col-lg-10">

                @if ($errors->any())
                    <div class="alert alert-danger rounded-4 mb-4 shadow-sm">
                        <h6 class="fw-bold"><i class="fa-solid fa-circle-exclamation me-2"></i> Please fix the following errors:</h6>
                        <ul class="mb-0 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="accordion" id="applicationAccordion">
                    
                    <!-- 1. Contact Information Section -->
                    <div class="accordion-item">
                        <div class="card section-card">
                            <div class="section-title-box active" id="headingOne" data-step="1" onclick="toggleSection(1)">
                                <h5><span class="step-badge">1</span> Contact Information</h5>
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>
                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne">
                                <div class="card-body p-4 p-md-5">
                                    <div class="row g-4">
                                        <div class="col-md-12">
                                            <label class="form-label">Resume / CV <span class="text-danger">*</span></label>
                                            <input type="file" name="resume" class="form-control required-field" accept=".pdf" required>
                                            <small class="text-muted">PDF format only (Max 2MB).</small>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Title <span class="text-danger">*</span></label>
                                            <select name="title" class="form-select required-field" required>
                                                <option value="">Select...</option>
                                                <option value="Mr." {{ old('title') == 'Mr.' ? 'selected' : '' }}>Mr.</option>
                                                <option value="Mrs." {{ old('title') == 'Mrs.' ? 'selected' : '' }}>Mrs.</option>
                                                <option value="Ms." {{ old('title') == 'Ms.' ? 'selected' : '' }}>Ms.</option>
                                                <option value="Miss" {{ old('title') == 'Miss' ? 'selected' : '' }}>Miss</option>
                                                <option value="Dr." {{ old('title') == 'Dr.' ? 'selected' : '' }}>Dr.</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">First Name <span class="text-danger">*</span></label>
                                            <input type="text" name="first_name" class="form-control required-field" value="{{ old('first_name') }}" placeholder="Enter first name" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Middle Name (Optional)</label>
                                            <input type="text" name="middle_name" class="form-control" value="{{ old('middle_name') }}" placeholder="Enter middle name">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                            <input type="text" name="last_name" class="form-control required-field" value="{{ old('last_name') }}" placeholder="Enter last name" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Email Address</label>
                                            <input type="email" name="email" class="form-control bg-light" value="{{ session('apply_email') }}" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <select name="phone_code" id="phone_code" class="form-select" style="max-width: 90px;">
                                                    <option value="+62" {{ old('phone_code') == '+62' ? 'selected' : '' }}>+62</option>
                                                    <option value="+65" {{ old('phone_code') == '+65' ? 'selected' : '' }}>+65</option>
                                                </select>
                                                <input type="text" name="phone_number" class="form-control required-field" value="{{ old('phone_number') }}" placeholder="812..." required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">LinkedIn Profile URL (Optional)</label>
                                            <input type="url" name="linkedin_profile" class="form-control" value="{{ old('linkedin_profile') }}" placeholder="https://linkedin.com/in/username">
                                        </div>
                                        <div class="col-md-12 text-end mt-4">
                                            <button type="button" class="btn btn-next px-4" onclick="nextStep(1)">Next Step <i class="fa-solid fa-arrow-right ms-2"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Address Section -->
                    <div class="accordion-item locked-section" id="itemTwo">
                        <div class="card section-card">
                            <div class="section-title-box" id="headingTwo" data-step="2" onclick="toggleSection(2)">
                                <h5><span class="step-badge">2</span> Address Information</h5>
                                <i class="fa-solid fa-chevron-right"></i>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo">
                                <div class="card-body p-4 p-md-5">
                                    <!-- Container for Added Addresses -->
                                    <div class="mb-4" id="addedAddressesContainer"></div>
                                    <div id="addressInputsContainer"></div>

                                    <!-- Toggle Button -->
                                    <div class="text-center mb-4 d-none" id="toggleAddressBtnContainer">
                                        <button type="button" class="btn btn-outline-success rounded-pill px-4 btn-sm fw-bold shadow-sm" onclick="showAddressForm()">
                                            <i class="fa-solid fa-plus me-1"></i> Add Another Address
                                        </button>
                                    </div>

                                    <!-- Form to Add/Edit Address -->
                                    <div id="addressFormCollapse">
                                        <div class="card border border-success-subtle bg-success-subtle bg-opacity-10 rounded-4 mb-4" id="addressFormCard">
                                            <div class="card-body p-4">
                                                <h6 class="fw-bold text-success mb-3" id="addressFormTitle"><i class="fa-solid fa-plus-circle me-1"></i> Add Address</h6>
                                                <input type="hidden" id="addr_edit_index" value="-1">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label small">Country <span class="text-danger">*</span></label>
                                                        <input type="text" id="addr_country" class="form-control form-control-sm" placeholder="Enter country">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small">Postal Code <span class="text-danger">*</span></label>
                                                        <input type="text" id="addr_postal_code" class="form-control form-control-sm" placeholder="Enter postal code">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="form-label small">Address Line <span class="text-danger">*</span></label>
                                                        <textarea id="addr_line" class="form-control form-control-sm" rows="2" placeholder="Street name, building number..."></textarea>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small">City / Regency <span class="text-danger">*</span></label>
                                                        <input type="text" id="addr_city_regency" class="form-control form-control-sm" placeholder="Enter city or regency">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small">Province <span class="text-danger">*</span></label>
                                                        <input type="text" id="addr_province" class="form-control form-control-sm" placeholder="Enter province">
                                                    </div>
                                                    <div class="col-md-12 text-end mt-3">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 me-2 d-none" id="btnCancelAddr" onclick="cancelAddressForm()">Cancel</button>
                                                        <button type="button" class="btn btn-sm btn-success rounded-pill px-4 shadow-sm" onclick="saveAddress()">Save Address</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 d-flex justify-content-between mt-4 border-top pt-4">
                                        <button type="button" class="btn btn-light btn-prev rounded-pill px-4" onclick="prevStep(1)">Previous</button>
                                        <button type="button" class="btn btn-next px-4" onclick="validateAndNextStep2()">Next Step <i class="fa-solid fa-arrow-right ms-2"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Education Section -->
                    <div class="accordion-item locked-section" id="itemThree">
                        <div class="card section-card">
                            <div class="section-title-box" id="headingThree" data-step="3" onclick="toggleSection(3)">
                                <h5><span class="step-badge">3</span> Education Background</h5>
                                <i class="fa-solid fa-chevron-right"></i>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree">
                                <div class="card-body p-4 p-md-5">
                                    
                                    <!-- Container for Added Educations -->
                                    <div class="mb-4" id="addedEducationsContainer"></div>
                                    <div id="educationInputsContainer"></div>

                                    <!-- Toggle Button -->
                                    <div class="text-center mb-4 d-none" id="toggleEduFormBtnContainer">
                                        <button type="button" class="btn btn-outline-success rounded-pill px-4 btn-sm fw-bold shadow-sm" onclick="showEduForm()">
                                            <i class="fa-solid fa-plus me-1"></i> Add Another Education
                                        </button>
                                    </div>

                                    <!-- Form to Add/Edit Education -->
                                    <div id="eduFormCollapse">
                                        <div class="card border border-success-subtle bg-success-subtle bg-opacity-10 rounded-4 mb-4" id="eduFormCard">
                                            <div class="card-body p-4">
                                                <h6 class="fw-bold text-success mb-3" id="eduFormTitle"><i class="fa-solid fa-plus-circle me-1"></i> Add Education</h6>
                                                <input type="hidden" id="edu_edit_index" value="-1">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label small">Degree <span class="text-danger">*</span></label>
                                                        <select id="edu_degree" class="form-select form-select-sm">
                                                            <option value="">Select...</option>
                                                            <option value="High School Diploma">High School Diploma</option>
                                                            <option value="Diploma 1">Diploma 1</option>
                                                            <option value="Diploma 2">Diploma 2</option>
                                                            <option value="Associate Degree (D3)">Associate Degree (D3)</option>
                                                            <option value="Bachelor (S1/D4)">Bachelor (S1/D4)</option>
                                                            <option value="Master's Degree">Master's Degree</option>
                                                            <option value="Doctoral Degree">Doctoral Degree</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small">Major <span class="text-danger">*</span></label>
                                                        <input type="text" id="edu_major" class="form-control form-control-sm" placeholder="e.g. Computer Science">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="form-label small">School Name <span class="text-danger">*</span></label>
                                                        <input type="text" id="edu_school" class="form-control form-control-sm" placeholder="Enter school name">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label small">Start Date <span class="text-danger">*</span></label>
                                                        <input type="date" id="edu_start_date" class="form-control form-control-sm">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label small">End Date <span class="text-danger">*</span></label>
                                                        <input type="date" id="edu_end_date" class="form-control form-control-sm">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label small">Country <span class="text-danger">*</span></label>
                                                        <input type="text" id="edu_country" class="form-control form-control-sm" placeholder="e.g. Indonesia">
                                                    </div>
                                                    <div class="col-md-12 text-end mt-3">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 me-2 d-none" id="btnCancelEdu" onclick="cancelEduForm()">Cancel</button>
                                                        <button type="button" class="btn btn-sm btn-success rounded-pill px-4 shadow-sm" onclick="saveEducation()">Save Education</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 d-flex justify-content-between mt-4 border-top pt-4">
                                        <button type="button" class="btn btn-light btn-prev rounded-pill px-4" onclick="prevStep(2)">Previous</button>
                                        <button type="button" class="btn btn-next px-4" onclick="validateAndNextStep3()">Next Step <i class="fa-solid fa-arrow-right ms-2"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Experience Section -->
                    <div class="accordion-item locked-section" id="itemFour">
                        <div class="card section-card">
                            <div class="section-title-box" id="headingFour" data-step="4" onclick="toggleSection(4)">
                                <h5><span class="step-badge">4</span> Work Experience (Optional)</h5>
                                <i class="fa-solid fa-chevron-right"></i>
                            </div>
                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour">
                                <div class="card-body p-4 p-md-5">
                                    
                                    <!-- Container for Added Experiences -->
                                    <div class="mb-4" id="addedExpContainer"></div>
                                    <div id="expInputsContainer"></div>

                                    <!-- Toggle Button -->
                                    <div class="text-center mb-4 d-none" id="toggleExpBtnContainer">
                                        <button type="button" class="btn btn-outline-success rounded-pill px-4 btn-sm fw-bold shadow-sm" onclick="showExpForm()">
                                            <i class="fa-solid fa-plus me-1"></i> Add Another Experience
                                        </button>
                                    </div>

                                    <!-- Form to Add/Edit Experience -->
                                    <div id="expFormCollapse">
                                        <div class="card border border-success-subtle bg-success-subtle bg-opacity-10 rounded-4 mb-4" id="expFormCard">
                                            <div class="card-body p-4">
                                                <h6 class="fw-bold text-success mb-3" id="expFormTitle"><i class="fa-solid fa-plus-circle me-1"></i> Add Work Experience</h6>
                                                <input type="hidden" id="exp_edit_index" value="-1">
                                                <div class="row g-3">
                                                    <div class="col-md-12">
                                                        <label class="form-label small">Job Title <span class="text-danger">*</span></label>
                                                        <input type="text" id="exp_job_title" class="form-control form-control-sm" placeholder="e.g. Software Engineer">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small">Company Name <span class="text-danger">*</span></label>
                                                        <input type="text" id="exp_company" class="form-control form-control-sm" placeholder="Enter company name">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small">Type of Business</label>
                                                        <input type="text" id="exp_type_business" class="form-control form-control-sm" placeholder="e.g. Manufacturing, IT, etc.">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="form-label small">City</label>
                                                        <input type="text" id="exp_city" class="form-control form-control-sm" placeholder="Enter company city">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small">Start Date <span class="text-danger">*</span></label>
                                                        <input type="date" id="exp_start_date" class="form-control form-control-sm">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small">End Date</label>
                                                        <input type="date" id="exp_end_date" class="form-control form-control-sm">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="form-label small">Job Description</label>
                                                        <textarea id="exp_job_desc" class="form-control form-control-sm" rows="3"></textarea>
                                                    </div>
                                                    <div class="col-md-12 text-end mt-3">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 me-2 d-none" id="btnCancelExp" onclick="cancelExpForm()">Cancel</button>
                                                        <button type="button" class="btn btn-sm btn-success rounded-pill px-4 shadow-sm" onclick="saveExperience()">Save Experience</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 d-flex justify-content-between mt-4 border-top pt-4">
                                        <button type="button" class="btn btn-light btn-prev rounded-pill px-4" onclick="prevStep(3)">Previous</button>
                                        <button type="button" class="btn btn-next px-4" onclick="nextStep(4)">Next Step <i class="fa-solid fa-arrow-right ms-2"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 5. Licenses & Certifications Section -->
                    <div class="accordion-item locked-section" id="itemFive">
                        <div class="card section-card">
                            <div class="section-title-box" id="headingFive" data-step="5" onclick="toggleSection(5)">
                                <h5><span class="step-badge">5</span> Licenses & Certifications (Optional)</h5>
                                <i class="fa-solid fa-chevron-right"></i>
                            </div>
                            <div id="collapseFive" class="collapse" aria-labelledby="headingFive">
                                <div class="card-body card-body-custom">
                                    
                                    <!-- Container for Added Certifications -->
                                    <div class="mb-4 mt-2" id="addedCertContainer"></div>
                                    <div id="certInputsContainer"></div>

                                    <!-- Toggle Button -->
                                    <div class="text-center mb-4 d-none" id="toggleCertBtnContainer">
                                        <button type="button" class="btn btn-outline-success rounded-pill px-4 btn-sm fw-bold shadow-sm" onclick="showCertForm()">
                                            <i class="fa-solid fa-plus me-1"></i> Add Another Certification
                                        </button>
                                    </div>

                                    <!-- Form to Add/Edit Certification -->
                                    <div id="certFormCollapse">
                                        <div class="card border border-success-subtle bg-success-subtle bg-opacity-10 rounded-4 mb-4 mt-2" id="certFormCard">
                                            <div class="card-body p-4">
                                                <h6 class="fw-bold text-success mb-3" id="certFormTitle"><i class="fa-solid fa-plus-circle me-1"></i> Add Certification</h6>
                                                <input type="hidden" id="cert_edit_index" value="-1">
                                                <div class="row g-3">
                                                    <div class="col-md-12">
                                                        <label class="form-label small">License or Certificate Name <span class="text-danger">*</span></label>
                                                        <input type="text" id="cert_name" class="form-control form-control-sm" placeholder="Enter certificate name">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="form-label small">Issued By <span class="text-danger">*</span></label>
                                                        <input type="text" id="cert_issued_by" class="form-control form-control-sm" placeholder="Issuing organization">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small">Issued Date <span class="text-danger">*</span></label>
                                                        <input type="date" id="cert_issued_date" class="form-control form-control-sm">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label small">Expiration Date</label>
                                                        <input type="date" id="cert_expiration_date" class="form-control form-control-sm">
                                                    </div>
                                                    <div class="col-md-12 text-end mt-3">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 me-2 d-none" id="btnCancelCert" onclick="cancelCertForm()">Cancel</button>
                                                        <button type="button" class="btn btn-sm btn-success rounded-pill px-4 shadow-sm" onclick="saveCertification()">Save Certification</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 d-flex justify-content-between mt-4 border-top pt-4">
                                        <button type="button" class="btn btn-light btn-prev rounded-pill px-4" onclick="prevStep(4)">Previous</button>
                                        <button type="button" class="btn btn-next px-4" onclick="nextStep(5)">Next Step <i class="fa-solid fa-arrow-right ms-2"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 6. Final Details Section -->
                    <div class="accordion-item locked-section" id="itemSix">
                        <div class="card section-card">
                            <div class="section-title-box" id="headingSix" data-step="6" onclick="toggleSection(6)">
                                <h5><span class="step-badge">6</span> Final Details</h5>
                                <i class="fa-solid fa-chevron-right"></i>
                            </div>
                            <div id="collapseSix" class="collapse" aria-labelledby="headingSix">
                                <div class="card-body p-4 p-md-5">
                                    <div class="row g-4">
                                        <div class="col-md-12">
                                            <label class="form-label">Cover Letter / Message</label>
                                            <textarea name="cover_letter" class="form-control" rows="5" placeholder="Tell us more about yourself..."></textarea>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-check bg-light p-3 rounded-3 border">
                                                <input class="form-check-input ms-0" type="checkbox" name="confirm_data" id="confirmCheck" required>
                                                <label class="form-check-label ms-2 fw-bold text-dark" for="confirmCheck" style="cursor: pointer;">
                                                    Make sure all of data is right
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12 d-flex justify-content-between mt-4">
                                            <button type="button" class="btn btn-light btn-prev rounded-pill px-4" onclick="prevStep(5)">Previous</button>
                                            <button type="submit" class="btn btn-apply-submit px-4 shadow-sm">Submit Final Application</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/pages/careers-apply.js') }}"></script>
@endpush
