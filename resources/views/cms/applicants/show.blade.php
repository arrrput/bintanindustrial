@extends('layouts.main')

@section('title', 'Applicant Detail - ' . $applicant->name)

@section('content')
<div class="page-title" data-aos="fade">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <nav class="breadcrumbs">
      <ol>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ route('cms.dashboard') }}">CMS</a></li>
        <li><a href="{{ route('cms.applicants.index') }}">Applicants</a></li>
        <li class="current">Detail</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-5 mt-2">
    <div class="row g-4 align-items-start">
        <!-- Applicant Profile Card -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-body text-center p-5">
                    <div class="avatar-lg mb-4 mx-auto" style="width: 100px; height: 100px; background: var(--accent-color); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 40px;">
                        {{ substr($applicant->first_name, 0, 1) }}
                    </div>
                    <h4 class="fw-bold text-dark mb-1">{{ $applicant->title }} {{ $applicant->name }}</h4>
                    <p class="text-muted small mb-4">{{ $applicant->edu_degree }} in {{ $applicant->edu_major }}</p>
                    
                    <div class="d-grid">
                        @php
                            $statusClasses = [
                                'pending' => 'bg-secondary',
                                'screening' => 'bg-info',
                                'interview' => 'bg-primary',
                                'rejected' => 'bg-danger',
                                'hired' => 'bg-success'
                            ];
                        @endphp
                        <span class="badge {{ $statusClasses[$applicant->status] }} py-2 rounded-pill text-uppercase mb-4">
                            Status: {{ $applicant->status }}
                        </span>
                    </div>

                    <form action="{{ route('cms.applicants.update-status', $applicant) }}" method="POST">
                        @csrf @method('PUT')
                        <label class="form-label small fw-bold text-muted text-uppercase d-block text-start mb-2">Update Status</label>
                        <select name="status" class="form-select rounded-pill mb-3" onchange="triggerSelectConfirm(this, '{{ $applicant->name }}', '{{ $applicant->career->title }}', '{{ $applicant->status }}')">
                            <option value="pending" {{ $applicant->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="screening" {{ $applicant->status == 'screening' ? 'selected' : '' }}>Screening</option>
                            <option value="interview" {{ $applicant->status == 'interview' ? 'selected' : '' }}>Interview</option>
                            <option value="rejected" {{ $applicant->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="hired" {{ $applicant->status == 'hired' ? 'selected' : '' }}>Hired</option>
                        </select>
                    </form>
                </div>
            </div>

            <!-- Documents Card -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">Documents</h6>
                    
                    <div class="mb-3 p-3 border rounded-3 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-file-pdf text-danger me-2 fs-4"></i>
                            <span class="small fw-bold">Resume / CV</span>
                        </div>
                        <a href="{{ asset('storage/' . $applicant->resume_path) }}" target="_blank" class="btn btn-sm btn-light rounded-circle shadow-sm"><i class="fa-solid fa-eye"></i></a>
                    </div>

                    @if($applicant->portfolio_path)
                    <div class="mb-0 p-3 border rounded-3 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-briefcase text-primary me-2 fs-4"></i>
                            <span class="small fw-bold">Portfolio</span>
                        </div>
                        <a href="{{ asset('storage/' . $applicant->portfolio_path) }}" target="_blank" class="btn btn-sm btn-light rounded-circle shadow-sm"><i class="fa-solid fa-eye"></i></a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Detailed Information -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 p-md-5">
                    
                    <!-- Section: Applied Position -->
                    <div class="mb-5">
                        <h6 class="text-success fw-bold text-uppercase small border-start border-success border-4 ps-2 mb-3">Applied Position</h6>
                        <div class="p-3 bg-light rounded-3 d-flex align-items-center">
                            <i class="fa-solid fa-briefcase text-muted me-3 fs-4"></i>
                            <div>
                                <h6 class="mb-0 fw-bold text-dark">{{ $applicant->career->title }}</h6>
                                <span class="text-muted small">{{ $applicant->career->location }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Personal Info -->
                    <div class="mb-5">
                        <h6 class="text-success fw-bold text-uppercase small border-start border-success border-4 ps-2 mb-3">Personal & Contact</h6>
                        <div class="p-4 border rounded-4 bg-light bg-opacity-50">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="text-muted small d-block">Full Name</label>
                                    <span class="fw-bold text-dark">{{ $applicant->first_name }} {{ $applicant->middle_name }} {{ $applicant->last_name }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small d-block">Email Address</label>
                                    <span class="fw-bold text-dark">{{ $applicant->email }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small d-block">Phone Number</label>
                                    <span class="fw-bold text-dark">{{ $applicant->phone }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small d-block">LinkedIn Profile</label>
                                    @if($applicant->linkedin_profile)
                                        <a href="{{ $applicant->linkedin_profile }}" target="_blank" class="fw-bold text-primary text-truncate d-block">{{ $applicant->linkedin_profile }}</a>
                                    @else
                                        <span class="text-muted italic small">Not provided</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Address -->
                    <div class="mb-5">
                        <h6 class="text-success fw-bold text-uppercase small border-start border-success border-4 ps-2 mb-3">Address Information</h6>
                        @forelse($applicant->addresses as $addr)
                        <div class="p-4 border rounded-4 bg-light bg-opacity-50 mb-3">
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <label class="text-muted small d-block">Street Address</label>
                                    <span class="fw-bold text-dark" style="white-space: pre-line;">{{ $addr->address_line }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small d-block">City / Regency</label>
                                    <span class="fw-bold text-dark">{{ $addr->city_regency }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small d-block">Province</label>
                                    <span class="fw-bold text-dark">{{ $addr->province }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small d-block">Postal Code</label>
                                    <span class="fw-bold text-dark">{{ $addr->postal_code }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small d-block">Country</label>
                                    <span class="fw-bold text-dark">{{ $addr->country }}</span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="p-4 border rounded-4 bg-light text-center text-muted">
                            No address information provided.
                        </div>
                        @endforelse
                    </div>

                    <!-- Section: Education -->
                    <div class="mb-5">
                        <h6 class="text-success fw-bold text-uppercase small border-start border-success border-4 ps-2 mb-3">Education Background</h6>
                        @forelse($applicant->educations as $edu)
                        <div class="p-4 border rounded-4 bg-light bg-opacity-50 mb-3">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="text-muted small d-block">Degree</label>
                                    <span class="fw-bold text-dark">{{ $edu->degree }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small d-block">Major</label>
                                    <span class="fw-bold text-dark">{{ $edu->major }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small d-block">School/University</label>
                                    <span class="fw-bold text-dark">{{ $edu->school }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small d-block">Period & Country</label>
                                    <span class="fw-bold text-dark">
                                        {{ \Carbon\Carbon::parse($edu->start_date)->format('M Y') }} - 
                                        {{ \Carbon\Carbon::parse($edu->end_date)->format('M Y') }} 
                                        <span class="text-muted fw-normal small ms-1">({{ $edu->country }})</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="p-4 border rounded-4 bg-light text-center text-muted">
                            No education background provided.
                        </div>
                        @endforelse
                    </div>

                    <!-- Section: Experience -->
                    <div class="mb-5">
                        <h6 class="text-success fw-bold text-uppercase small border-start border-success border-4 ps-2 mb-3">Work Experience</h6>
                        @forelse($applicant->experiences as $exp)
                        <div class="p-4 border rounded-4 mb-3">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="text-muted small d-block">Job Title</label>
                                    <span class="fw-bold text-dark">{{ $exp->job_title }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small d-block">Company & Location</label>
                                    <span class="fw-bold text-dark">{{ $exp->company }} <span class="text-muted fw-normal small">({{ $exp->city ?? '-' }})</span></span>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small d-block">Business Type</label>
                                    <span class="fw-bold text-dark">{{ $exp->type_business ?? '-' }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small d-block">Period</label>
                                    <span class="fw-bold text-dark">
                                        {{ \Carbon\Carbon::parse($exp->start_date)->format('M Y') }} - 
                                        {{ $exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->format('M Y') : 'Present' }}
                                    </span>
                                </div>
                                @if($exp->job_desc)
                                <div class="col-md-12">
                                    <label class="text-muted small d-block">Job Description</label>
                                    <p class="text-dark small mb-0" style="white-space: pre-line;">{{ $exp->job_desc }}</p>
                                </div>
                                @endif
                                @if($exp->leaving_reason)
                                <div class="col-md-12">
                                    <label class="text-muted small d-block">Reason for Leaving</label>
                                    <p class="text-dark small mb-0 fst-italic">"{{ $exp->leaving_reason }}"</p>
                                </div>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="p-4 border rounded-4 bg-light text-center text-muted">
                            No work experience provided.
                        </div>
                        @endforelse
                    </div>

                    <!-- Section: Certification -->
                    <div class="mb-5">
                        <h6 class="text-success fw-bold text-uppercase small border-start border-success border-4 ps-2 mb-3">Licenses & Certifications</h6>
                        @forelse($applicant->certifications as $cert)
                        <div class="p-4 border rounded-4 bg-light bg-opacity-25 mb-3">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="text-muted small d-block">Certificate Name</label>
                                    <span class="fw-bold text-dark">{{ $cert->name }}</span>
                                </div>
                                <div class="col-md-12">
                                    <label class="text-muted small d-block">Issued By</label>
                                    <span class="fw-bold text-dark">{{ $cert->issued_by }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small d-block">Date</label>
                                    <span class="fw-bold text-dark">
                                        {{ \Carbon\Carbon::parse($cert->issued_date)->format('M d, Y') }} - 
                                        {{ $cert->expiration_date ? \Carbon\Carbon::parse($cert->expiration_date)->format('M d, Y') : 'No Expiry' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="p-4 border rounded-4 bg-light text-center text-muted">
                            No certifications provided.
                        </div>
                        @endforelse
                    </div>

                    <!-- Section: Cover Letter -->
                    <div>
                        <h6 class="text-success fw-bold text-uppercase small border-start border-success border-4 ps-2 mb-3">Cover Letter / Additional Message</h6>
                        <div class="p-4 bg-light rounded-4 text-muted shadow-inner" style="min-height: 150px; white-space: pre-line; border: 1px dashed #ccc;">
                            {{ $applicant->cover_letter ?? 'No additional message provided.' }}
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-top text-end">
                        <a href="{{ route('cms.applicants.index') }}" class="btn btn-light rounded-pill px-4 fw-bold text-muted me-2">
                            <i class="fa-solid fa-arrow-left me-2"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reusable Beautiful Confirmation Modal -->
<div class="modal fade" id="statusConfirmModal" tabindex="-1" aria-hidden="true" style="z-index: 2000;">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header border-0 pb-0 justify-content-center pt-4">
                <div class="rounded-circle bg-warning-subtle text-warning d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px; background-color: #fff3cd;">
                    <i class="fa-solid fa-circle-question fs-2 text-warning"></i>
                </div>
            </div>
            <div class="modal-body p-4 text-center">
                <h5 class="fw-bold text-dark mb-2">Confirm Status Update</h5>
                <p class="text-muted small mb-0" id="statusConfirmMessage" style="font-size: 0.9rem; line-height: 1.5;"></p>
            </div>
            <div class="modal-footer border-0 pt-0 justify-content-center gap-2 pb-4">
                <button type="button" class="btn btn-light rounded-pill px-4 btn-sm fw-bold text-muted border" data-bs-dismiss="modal" id="statusConfirmCancelBtn">Cancel</button>
                <button type="button" class="btn btn-success rounded-pill px-4 btn-sm fw-bold shadow-sm" id="statusConfirmProceedBtn" style="background-color: #198754; border-color: #198754;">Confirm</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/pages/cms-applicants-show.js') }}"></script>
@endsection
