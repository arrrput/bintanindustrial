@extends('layouts.main')

@section('title', 'Manage Applicants - BIIE CMS')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/pages/cms-applicants-index.css') }}">
@endpush

@section('content')
<div class="page-title" data-aos="fade">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <nav class="breadcrumbs">
      <ol>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ route('cms.dashboard') }}">CMS</a></li>
        <li><a href="{{ route('cms.careers.index') }}">Careers</a></li>
        <li class="current">Applicants</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-4 py-md-5 mt-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0 fs-3">
                <i class="fa-solid fa-user-tie text-success me-2"></i> Applicants Management
            </h2>
            <p class="text-muted small mb-0 mt-1">Review and manage job applications.</p>
        </div>
        <div>
            <form action="{{ route('cms.applicants.index') }}" method="GET" class="d-flex gap-2">
                <div class="applicant-filter-wrapper">
                    <select name="career_id" class="form-select rounded-pill px-3 form-select-applicant" onchange="this.form.submit()">
                        <option value="">All Job Positions</option>
                        @foreach($careers as $career)
                            <option value="{{ $career->id }}" {{ request('career_id') == $career->id ? 'selected' : '' }}>{{ $career->title }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- ACTIVE APPLICANTS SECTION -->
    <div class="mb-4 mt-5">
        <h5 class="fw-bold text-dark"><i class="fa-solid fa-bolt text-warning me-2"></i> Active Applicants</h5>
        <p class="text-muted small">Candidates currently in the screening or interview process.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted" style="font-size: 0.85rem; letter-spacing: 1px;">
                        <tr>
                            <th class="ps-4 py-3">APPLICANT</th>
                            <th class="py-3">JOB POSITION</th>
                            <th class="py-3">STATUS</th>
                            <th class="py-3">APPLIED DATE</th>
                            <th class="pe-4 py-3 text-end">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activeApplicants as $applicant)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="fw-bold text-dark">{{ $applicant->name }}</div>
                                <div class="text-muted small">{{ $applicant->edu_degree }} in {{ $applicant->edu_major }}</div>
                            </td>
                            <td class="py-3">
                                <span class="text-dark">{{ $applicant->career->title }}</span>
                            </td>
                            <td class="py-3">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-secondary',
                                        'screening' => 'bg-info',
                                        'interview' => 'bg-primary'
                                    ];
                                @endphp
                                <span class="badge {{ $statusClasses[$applicant->status] ?? 'bg-dark' }} rounded-pill text-uppercase" style="font-size: 0.65rem;">
                                    {{ $applicant->status }}
                                </span>
                            </td>
                            <td class="py-3 text-muted small">
                                {{ $applicant->created_at->format('M d, Y') }}
                            </td>
                            <td class="pe-4 py-3 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('cms.applicants.show', $applicant) }}" class="btn btn-sm btn-light text-success rounded-circle shadow-sm" title="View Details">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <!-- Trigger Decision Modal -->
                                    <button type="button" class="btn btn-sm btn-light text-danger rounded-circle shadow-sm" data-bs-toggle="modal" data-bs-target="#decisionModal{{ $applicant->id }}" title="Make Decision">
                                        <i class="fa-solid fa-gavel"></i>
                                    </button>

                                    <!-- Decision Modal -->
                                    <div class="modal fade" id="decisionModal{{ $applicant->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 rounded-4 shadow">
                                                <div class="modal-header border-0 pb-0">
                                                    <h5 class="modal-title fw-bold text-dark"><i class="fa-solid fa-scale-balanced text-primary me-2"></i> Make Decision</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-4 text-start">
                                                    <p class="text-muted small mb-3">You are about to make a final decision for <strong>{{ $applicant->name }}</strong>.</p>
                                                    
                                                    <form action="{{ route('cms.applicants.update-status', $applicant) }}" method="POST">
                                                        @csrf @method('PUT')
                                                        
                                                        <div class="mb-4">
                                                            <label class="form-label fw-bold small text-dark">Reason (Optional)</label>
                                                            <textarea name="status_reason" class="form-control rounded-3" rows="3" placeholder="Explain the reason for hiring or rejecting..."></textarea>
                                                        </div>

                                                        <div class="d-grid gap-2 mb-3">
                                                            <button type="button" class="btn btn-success rounded-pill fw-bold" onclick="triggerConfirm(this.form, 'HIRED', '{{ $applicant->name }}', '{{ $applicant->career->title }}')">
                                                                <i class="fa-solid fa-check-circle me-1"></i> Hired
                                                            </button>
                                                            <button type="button" class="btn btn-danger rounded-pill fw-bold" onclick="triggerConfirm(this.form, 'REJECTED', '{{ $applicant->name }}', '{{ $applicant->career->title }}')">
                                                                <i class="fa-solid fa-circle-xmark me-1"></i> Rejected
                                                            </button>
                                                        </div>
                                                        <div class="text-center">
                                                            <a href="#" data-bs-dismiss="modal" class="text-muted small text-decoration-none fw-bold">Cancel</a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">No active applicants at the moment.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mb-5">
        {{ $activeApplicants->appends(['history_page' => $historyApplicants->currentPage()])->links() }}
    </div>

    <div class="section-divider"></div>

    <!-- HISTORY APPLICANTS SECTION -->
    <div class="mb-4">
        <h5 class="fw-bold text-muted"><i class="fa-solid fa-clock-rotate-left me-2"></i> Application History</h5>
        <p class="text-muted small">Candidates who have been hired or rejected.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden history-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted" style="font-size: 0.85rem; letter-spacing: 1px;">
                        <tr>
                            <th class="ps-4 py-3">APPLICANT</th>
                            <th class="py-3">JOB POSITION</th>
                            <th class="py-3 text-center">DECISION</th>
                            <th class="py-3">DECISION DATE</th>
                            <th class="pe-4 py-3 text-end">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($historyApplicants as $applicant)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="fw-bold text-dark">{{ $applicant->name }}</div>
                                <div class="text-muted small">{{ $applicant->edu_degree }} in {{ $applicant->edu_major }}</div>
                            </td>
                            <td class="py-3">
                                <span class="text-dark">{{ $applicant->career->title }}</span>
                            </td>
                            <td class="py-3 text-center">
                                <span class="badge {{ $applicant->status == 'hired' ? 'bg-success' : 'bg-danger' }} rounded-pill text-uppercase" style="font-size: 0.65rem;">
                                    {{ $applicant->status }}
                                </span>
                            </td>
                            <td class="py-3 text-muted small">
                                {{ $applicant->updated_at->format('M d, Y') }}
                            </td>
                            <td class="pe-4 py-3 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('cms.applicants.show', $applicant) }}" class="btn btn-sm btn-light text-success rounded-circle shadow-sm" title="View Details">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <form action="{{ route('cms.applicants.destroy', $applicant) }}" method="POST" onsubmit="return confirm('Delete this history record?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light text-danger rounded-circle shadow-sm">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">No history found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-4">
        {{ $historyApplicants->appends(['active_page' => $activeApplicants->currentPage()])->links() }}
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

<script src="{{ asset('assets/js/pages/cms-applicants-index.js') }}"></script>
@endsection
