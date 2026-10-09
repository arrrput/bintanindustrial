@extends('layouts.main') 

@section('title', 'Manage Programs - BIIE CMS')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/pages/cms-programs-index.css') }}">
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
        <li class="current">Manage Programs</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-4 py-md-5 mt-2">

    <!-- Section Settings Form -->
    <div class="card border-0 shadow-sm rounded-4 mb-5">
        <div class="card-body p-4">
            <h4 class="fw-bold text-dark mb-4">
                <i class="fa-solid fa-image text-danger me-2"></i> Beyond The Workplace &mdash; Banner
            </h4>
            <p class="text-muted small mb-4 mt-n3">Banner shown above the Event, Entertainment &amp; CSR sections on the News page.</p>
            <form action="{{ route('cms.section-settings.update') }}" method="POST" enctype="multipart/form-data" class="js-banner-bg-form">
                @csrf
                <input type="hidden" name="section_key" value="program">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Banner Title</label>
                        <input type="text" name="title" class="form-control rounded-pill" value="{{ $setting->title ?? 'Beyond The Workplace' }}" placeholder="Enter banner title">
                    </div>
                    @include('cms.partials.banner-background', ['key' => 'program', 'setting' => $setting])
                    <div class="col-12">
                        <label class="form-label small fw-bold">Banner Subtitle <span class="text-muted fw-normal">(optional)</span></label>
                        <textarea name="subtitle" class="form-control rounded-4" rows="3" maxlength="1000" placeholder="Short text shown under the banner title">{{ old('subtitle', $setting->subtitle ?? '') }}</textarea>
                    </div>

                    <div class="col-12 mt-4 text-end">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                            <i class="fa-solid fa-save me-2"></i> Update Settings
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h2 class="fw-bold text-dark mb-0 fs-3">
                <i class="fa-solid fa-calendar-days text-danger me-2"></i> Program Content
            </h2>
            <p class="text-muted small mb-0 mt-1">Manage content for "Event", "Entertainment" and "CSR" sections in the "Beyond The Workplace" section of the News page.</p>
        </div>
        <div>
            <a href="{{ route('cms.programs.create') }}" class="btn btn-danger rounded-pill px-4 shadow-sm fw-bold">
                <i class="fa-solid fa-plus me-2"></i> Add Content
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive"> 
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted" style="font-size: 0.85rem; letter-spacing: 1px;">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase" style="width: 100px;">Cover</th>
                            <th class="py-3 text-uppercase">Title & Category</th>
                            <th class="py-3 text-uppercase d-none d-md-table-cell">Preview</th>
                            <th class="pe-4 py-3 text-uppercase text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($programs as $program)
                        <tr>
                            <td class="ps-4 py-3">
                                @if($program->image)
                                    <img src="{{ asset('storage/' . $program->image) }}" class="rounded-3 shadow-sm" style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted" style="width: 60px; height: 60px;">
                                        <i class="fa-solid fa-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="py-3">
                                <h6 class="mb-1 fw-bold text-dark">{{ $program->title }}</h6>
                                <span class="badge {{ $program->category == 'event' ? 'bg-primary' : ($program->category == 'entertainment' ? 'bg-success' : 'bg-warning text-dark') }} px-2 py-1 rounded-pill text-uppercase" style="font-size: 0.65rem;">
                                    {{ $program->category }}
                                </span>
                            </td>
                            <td class="py-3 d-none d-md-table-cell text-muted small">
                                {{ Str::limit(strip_tags($program->description), 80) }}
                            </td>
                            <td class="pe-4 py-3 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('cms.programs.edit', $program->id) }}" class="btn btn-sm btn-light text-primary rounded-circle shadow-sm">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('cms.programs.destroy', $program->id) }}" method="POST" onsubmit="return confirm('Delete this content?');">
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
                            <td colspan="4" class="text-center py-5 text-muted">No content found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/pages/cms-programs-index.js') }}"></script>
@endpush
