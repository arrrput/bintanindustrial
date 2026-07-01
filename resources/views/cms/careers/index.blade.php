@extends('layouts.main') 

@section('title', 'Manage Careers - BIIE CMS')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/pages/cms-careers-index.css') }}">
@endpush

@section('content')

  @if(session('success'))
      <div id="adminSuccessToast" class="custom-success-toast">
          <i class="fa-solid fa-circle-check fs-5"></i> {{ session('success') }}
      </div>
  @endif

<div class="page-title" data-aos="fade">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <nav class="breadcrumbs">
      <ol>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ route('cms.dashboard') }}">CMS</a></li>
        <li class="current">Careers</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-4 py-md-5 mt-2">

    <!-- Top Cards Row -->
    <div class="row align-items-start mb-2">
        <!-- 1. Section Settings -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 rounded-4 overflow-hidden custom-card-shadow">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center" style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#collapseSectionSettings" aria-expanded="false" aria-controls="collapseSectionSettings">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-gear text-success me-2"></i> Section Settings
                    </h5>
                    <div class="text-muted">
                        <i class="fa-solid fa-chevron-down transition-icon"></i>
                    </div>
                </div>
                <div class="collapse" id="collapseSectionSettings">
                    <div class="card-body p-4 pt-0">
                        <form action="{{ route('cms.section-settings.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="section_key" value="career">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold">Custom Section Title</label>
                                    <input type="text" name="title" class="form-control rounded-pill px-3" value="{{ $setting->title ?? 'Join Our Team' }}" placeholder="Enter custom title">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label small fw-bold">Background Images</label>
                                    <input type="file" name="background_images[]" class="form-control rounded-pill px-3" multiple>
                                </div>
                                
                                @if($setting && $setting->background_images && count($setting->background_images) > 0)
                                <div class="col-12 mt-2">
                                    <label class="form-label small fw-bold">Current Images</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($setting->background_images as $img)
                                        <div class="position-relative border rounded p-1" style="width: 80px;">
                                            <img src="{{ asset('storage/' . $img) }}" class="rounded w-100" style="height: 50px; object-fit: cover;">
                                            <div class="position-absolute top-0 end-0 p-0">
                                                <input type="checkbox" name="remove_images[]" value="{{ $img }}" id="del_bg_{{ $loop->index }}" class="d-none">
                                                <label for="del_bg_{{ $loop->index }}" class="btn btn-danger btn-sm rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 20px; height: 20px; cursor: pointer; padding: 0;" onclick="this.parentElement.parentElement.style.opacity='0.3';">
                                                    <i class="fa-solid fa-xmark" style="font-size: 0.6rem;"></i>
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                <div class="col-12 mt-3 text-end">
                                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold btn-sm shadow-sm">
                                        <i class="fa-solid fa-save me-2"></i> Update Settings
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Applicant Management Preview -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0 rounded-4 overflow-hidden custom-card-shadow">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center" style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#collapseApplicantMgmt" aria-expanded="true" aria-controls="collapseApplicantMgmt">
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-user-tie text-success me-2"></i> Active Applicant
                    </h5>
                    <div class="text-muted">
                        <i class="fa-solid fa-chevron-down transition-icon"></i>
                    </div>
                </div>
                <div class="collapse show" id="collapseApplicantMgmt">
                    <div class="card-body p-4 pt-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light text-muted" style="font-size: 0.75rem;">
                                    <tr>
                                        <th class="ps-2">NAME</th>
                                        <th>POSITION</th>
                                        <th class="text-center">STATUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($latestApplicants as $app)
                                    <tr>
                                        <td class="ps-2 py-3">
                                            <div class="fw-bold text-dark small text-truncate" style="max-width: 120px;">{{ $app->name }}</div>
                                            <div class="text-muted" style="font-size: 9px;">{{ $app->edu_degree }} in {{ $app->edu_major }}</div>
                                        </td>
                                        <td>
                                            <span class="small text-dark text-truncate d-block" style="font-size: 11px; max-width: 120px;">{{ $app->career->title }}</span>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $appStatusClasses = [
                                                    'pending' => 'bg-secondary',
                                                    'screening' => 'bg-info',
                                                    'interview' => 'bg-primary',
                                                    'rejected' => 'bg-danger',
                                                    'hired' => 'bg-success'
                                                ];
                                            @endphp
                                            <span class="badge {{ $appStatusClasses[$app->status] }} rounded-pill" style="font-size: 8px;">
                                                {{ strtoupper($app->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted small">No applicants yet.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 text-center">
                            <a href="{{ route('cms.applicants.index') }}" class="btn btn-outline-success rounded-pill px-4 fw-bold btn-sm">
                                View All Applicants <i class="fa-solid fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Job Vacancies Unified Card (Active) -->
    <div class="card border-0 rounded-4 overflow-hidden custom-card-shadow mt-2 mb-5">
        <div class="card-header bg-white py-3 py-md-4 border-0">
            <div class="d-flex justify-content-between align-items-center gap-2">
                <div class="text-truncate">
                    <h5 class="fw-bold text-dark mb-0 fs-5 fs-md-3">
                        <i class="fa-solid fa-briefcase text-success me-1 me-md-2"></i> Active Job Vacancies
                    </h5>
                    <p class="text-muted small mb-0 mt-1 d-none d-sm-block">Manage your current job opportunities.</p>
                </div>
                <div class="text-nowrap">
                    <a href="{{ route('cms.careers.create') }}" class="btn btn-success rounded-pill px-3 px-md-4 shadow-sm fw-bold btn-sm btn-md-md text-nowrap">
                        <i class="fa-solid fa-plus me-1 me-md-2"></i> Post Job
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive"> 
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted" style="font-size: 0.85rem; letter-spacing: 1px;">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase">Job Title</th>
                            <th class="py-3 text-uppercase text-center">Applicants</th>
                            <th class="py-3 text-uppercase text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($activeCareers as $career)
                        <tr>
                            <td class="ps-4 py-3">
                                <h6 class="mb-1 fw-bold text-dark">{{ $career->title }}</h6>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2" style="font-size: 0.6rem;">OPEN</span>
                                    <span class="text-muted" style="font-size: 0.7rem;"><i class="fa-solid fa-calendar-day me-1"></i> Ends: {{ \Carbon\Carbon::parse($career->closing_date)->format('M d, Y') }}</span>
                                </div>
                            </td>
                            <td class="py-3 text-center">
                                <a href="{{ route('cms.applicants.index', ['career_id' => $career->id]) }}" class="text-decoration-none">
                                    <div class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fw-bold">
                                        <i class="fa-solid fa-users me-1"></i> {{ $career->applicants_count }}
                                    </div>
                                </a>
                            </td>
                            <td class="pe-4 py-3 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('cms.careers.edit', $career) }}" class="btn btn-sm btn-light text-primary rounded-circle shadow-sm">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('cms.careers.destroy', $career) }}" method="POST" onsubmit="return confirm('Delete this job?');">
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
                            <td colspan="3" class="text-center py-5 text-muted">No active jobs at the moment.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="section-divider"></div>

    <!-- 4. Job Vacancies History Card -->
    <div class="card border-0 rounded-4 overflow-hidden custom-card-shadow history-card mb-5">
        <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
             <h5 class="fw-bold text-muted mb-0">
                <i class="fa-solid fa-clock-rotate-left me-2"></i> Job Vacancies History
            </h5>
            @if(!$historyCareers->isEmpty())
            <div class="d-flex align-items-center gap-2">
                <label class="form-label small fw-bold text-muted mb-0 text-nowrap">Filter Month:</label>
                <select class="form-select form-select-sm rounded-pill px-3" style="width: auto; min-width: 150px;" id="monthFilterSelect">
                    <option value="all">Show All Months</option>
                    @foreach($historyCareers as $month => $careers)
                        <option value="{{ Str::slug($month, '_') }}">{{ $month }}</option>
                    @endforeach
                </select>
            </div>
            @endif
        </div>
        <div class="card-body p-0">
            @if($historyCareers->isEmpty())
                <div class="text-center py-5 text-muted small">No history found.</div>
            @else
                <div class="accordion accordion-flush" id="accordionHistory">
                    @foreach($historyCareers as $month => $careers)
                        @php
                            $accordionId = 'acc_' . Str::slug($month, '_');
                        @endphp
                        <div class="accordion-item border-0 border-bottom" data-month-slug="{{ Str::slug($month, '_') }}">
                            <h2 class="accordion-header" id="heading_{{ $accordionId }}">
                                <button class="accordion-button accordion-button-dark collapsed fw-bold px-4 py-3 d-flex align-items-center justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{ $accordionId }}" aria-expanded="false" aria-controls="collapse_{{ $accordionId }}">
                                    <div class="d-flex align-items-center flex-grow-1 text-dark">
                                        <i class="fa-solid fa-calendar-days me-2 text-success"></i> {{ $month }}
                                        <span class="badge bg-secondary text-white ms-2 small" style="font-size: 0.7rem;">{{ count($careers) }} vacancies</span>
                                    </div>
                                    <span class="btn btn-sm btn-danger rounded-pill px-3 me-3 text-white shadow-sm download-pdf-btn d-flex align-items-center" style="font-size: 0.7rem; font-weight: bold; z-index: 100;" onclick="event.stopPropagation(); downloadPDF('{{ $month }}', 'table_{{ $accordionId }}')">
                                        <i class="fa-solid fa-file-pdf me-1"></i> PDF
                                    </span>
                                </button>
                            </h2>
                            <div id="collapse_{{ $accordionId }}" class="accordion-collapse collapse" aria-labelledby="heading_{{ $accordionId }}" data-bs-parent="#accordionHistory">
                                <div class="accordion-body p-0">
                                    <div class="table-responsive"> 
                                        <table class="table table-hover align-middle mb-0" id="table_{{ $accordionId }}">
                                            <thead class="bg-light text-muted" style="font-size: 0.8rem; letter-spacing: 1px;">
                                                <tr>
                                                    <th class="ps-4 py-3 text-uppercase">Job Title</th>
                                                    <th class="py-3 text-uppercase text-center">Close Date</th>
                                                    <th class="py-3 text-uppercase text-center">Applicants</th>
                                                    <th class="py-3 text-uppercase text-center">Hired</th>
                                                    <th class="pe-4 py-3 text-uppercase text-end">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($careers as $career)
                                                <tr>
                                                    <td class="ps-4 py-3">
                                                        <h6 class="mb-1 fw-bold text-muted">{{ $career->title }}</h6>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2" style="font-size: 0.6rem;">CLOSED</span>
                                                            <span class="text-muted" style="font-size: 0.7rem;"><i class="fa-solid fa-calendar-day me-1"></i> Created: {{ \Carbon\Carbon::parse($career->created_at)->format('M d, Y') }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="py-3 text-center text-muted small">
                                                        {{ $career->closing_date ? \Carbon\Carbon::parse($career->closing_date)->format('M d, Y') : '-' }}
                                                    </td>
                                                    <td class="py-3 text-center">
                                                        <a href="{{ route('cms.applicants.index', ['career_id' => $career->id]) }}" class="text-decoration-none">
                                                            <div class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2 fw-bold">
                                                                <i class="fa-solid fa-users me-1"></i> {{ $career->applicants_count }}
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td class="py-3 text-center text-success fw-bold">
                                                        {{ $career->hired_count }}
                                                    </td>
                                                    <td class="pe-4 py-3 text-end">
                                                        <div class="d-flex justify-content-end gap-2">
                                                            <a href="{{ route('cms.careers.edit', $career) }}" class="btn btn-sm btn-light text-primary rounded-circle shadow-sm">
                                                                <i class="fa-solid fa-pen"></i>
                                                            </a>
                                                            <form action="{{ route('cms.careers.destroy', $career) }}" method="POST" onsubmit="return confirm('Delete this history record?');">
                                                                @csrf @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-light text-danger rounded-circle shadow-sm">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.29/jspdf.plugin.autotable.min.js"></script>
<script src="{{ asset('assets/js/pages/cms-careers-index.js') }}"></script>
@endpush
