@extends('layouts.main')

@section('title', 'Manage OSS - BIIE CMS')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/pages/cms-bie-page-index.css') }}">
@endpush

@section('content')

<div class="page-title" data-aos="fade">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <nav class="breadcrumbs">
      <ol>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ route('cms.dashboard') }}">CMS</a></li>
        <li class="current">Manage OSS</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-4 py-md-5 mt-2">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-start mb-5 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="fa-solid fa-screwdriver-wrench text-info me-2"></i> Manage OSS
            </h2>
            <p class="text-muted mb-0">Manage the One Stop Service Suite and Facilities shown on the public <strong>OSS</strong> page.</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('cms.dashboard') }}" class="btn btn-secondary rounded-pill px-4 fw-bold">
                <i class="fa-solid fa-arrow-left me-2"></i> Back
            </a>
            <a href="{{ route('oss') }}" target="_blank" class="btn btn-outline-success rounded-pill px-4 fw-bold">
                <i class="fa-solid fa-arrow-up-right-from-square me-2"></i> View Live Page
            </a>
        </div>
    </div>

    {{-- Tab Navigation --}}
    <ul class="nav section-tab-nav gap-2 mb-5" id="ossTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab-service-suite" data-bs-toggle="tab" data-bs-target="#pane-service-suite" type="button" role="tab" aria-controls="pane-service-suite" aria-selected="true">
                <i class="fa-solid fa-screwdriver-wrench me-1"></i> One Stop Service Suite
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-facilities" data-bs-toggle="tab" data-bs-target="#pane-facilities" type="button" role="tab" aria-controls="pane-facilities" aria-selected="false">
                <i class="fa-solid fa-industry me-1"></i> Facilities
            </button>
        </li>
    </ul>

    <div class="tab-content" id="ossTabContent">

    {{-- ===================================================== --}}
    {{-- TAB 1: ONE STOP SERVICE SUITE                          --}}
    {{-- ===================================================== --}}
    <div class="tab-pane fade show active" id="pane-service-suite" role="tabpanel" aria-labelledby="tab-service-suite">

        {{-- One Stop Service Suite Banner Settings --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold text-dark mb-4">
                    <i class="fa-solid fa-image text-info me-2"></i> One Stop Service Suite &mdash; Heading &amp; Banner
                </h5>
                <form action="{{ route('cms.section-settings.update') }}" method="POST" enctype="multipart/form-data" class="js-banner-bg-form">
                    @csrf
                    <input type="hidden" name="section_key" value="service_suite">
                    <div class="row g-3">
                        @include('cms.partials.section-heading-fields', ['key' => 'service_suite', 'setting' => $serviceSuiteSetting])
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Banner Title</label>
                            <input type="text" name="title" class="form-control rounded-pill" value="{{ $serviceSuiteSetting->title ?? 'One Stop Service Suite' }}" placeholder="Enter banner title">
                        </div>
                        @include('cms.partials.banner-background', ['key' => 'service_suite', 'setting' => $serviceSuiteSetting])
                        <div class="col-12">
                            <label class="form-label small fw-bold">Banner Subtitle <span class="text-muted fw-normal">(optional)</span></label>
                            <textarea name="subtitle" class="form-control rounded-4" rows="2" maxlength="1000" placeholder="Short text shown under the banner title">{{ old('subtitle', $serviceSuiteSetting ? $serviceSuiteSetting->subtitle : 'Comprehensive support services designed for operational efficiency.') }}</textarea>
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                                <i class="fa-solid fa-save me-2"></i> Save Banner
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- One Stop Service Suite --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="fw-bold text-dark mb-1">
                    <i class="fa-solid fa-screwdriver-wrench text-info me-2"></i> One Stop Service Suite
                    <span class="sub-section-label ms-2">service suite</span>
                </h5>
                <p class="text-muted small mb-0">Icon cards shown below the One Stop Service Suite banner on the OSS page.</p>
            </div>
            <a href="{{ route('cms.bies.create', ['page_group' => 'work', 'category' => 'service_suite']) }}" class="btn btn-info text-white rounded-pill px-4 shadow-sm fw-bold">
                <i class="fa-solid fa-plus me-2"></i> Add Service
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted" style="font-size: 0.82rem; letter-spacing: 1px;">
                            <tr>
                                <th class="ps-3 py-3" style="width: 48px;"><span class="visually-hidden">Reorder</span></th>
                                <th class="ps-4 py-3 text-uppercase" style="width: 80px;">Icon</th>
                                <th class="py-3 text-uppercase">Service Name</th>
                                <th class="py-3 text-uppercase d-none d-md-table-cell">Description</th>
                                <th class="pe-4 py-3 text-uppercase text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody data-sortable-url="{{ route('cms.bies.reorder') }}">
                            @forelse($suiteWorks as $item)
                            <tr data-id="{{ $item->id }}">
                                <td class="drag-handle ps-3 py-3" title="Drag to reorder" aria-label="Drag to reorder"><i class="fa-solid fa-grip-vertical"></i></td>
                                <td class="py-3">
                                    <div class="bg-info-subtle text-info rounded-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                                        <i class="{{ $item->icon ?? 'fa-solid fa-gear' }} fs-4"></i>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <h6 class="mb-0 fw-bold text-dark">{{ $item->title }}</h6>
                                </td>
                                <td class="py-3 d-none d-md-table-cell text-muted small">
                                    {{ Str::limit(strip_tags($item->description), 80) }}
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('cms.bies.edit', $item->id) }}" class="btn btn-sm btn-light text-primary rounded-circle shadow-sm" title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <form action="{{ route('cms.bies.destroy', $item->id) }}" method="POST" data-confirm="Delete this service?">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light text-danger rounded-circle shadow-sm" title="Delete">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted small">No service suite items yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- ===================================================== --}}
    {{-- TAB 2: FACILITIES                                      --}}
    {{-- ===================================================== --}}
    <div class="tab-pane fade" id="pane-facilities" role="tabpanel" aria-labelledby="tab-facilities">

    {{-- Facilities Heading Settings (this section has no banner) --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <h5 class="fw-bold text-dark mb-4">
                <i class="fa-solid fa-heading text-success me-2"></i> Facilities &mdash; Heading
            </h5>
            <form action="{{ route('cms.section-settings.update') }}" method="POST">
                @csrf
                <input type="hidden" name="section_key" value="facilities">
                <input type="hidden" name="title" value="{{ $facilitiesSetting->title ?? 'Facilities' }}">
                <div class="row g-3">
                    @include('cms.partials.section-heading-fields', ['key' => 'facilities', 'setting' => $facilitiesSetting, 'withBanner' => false])
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                            <i class="fa-solid fa-save me-2"></i> Save Heading
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Facilities (photo cards, shown under "World-Class Infrastructure" on the OSS page) --}}
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
            <h5 class="fw-bold text-dark mb-1">
                <i class="fa-solid fa-industry text-success me-2"></i> Facilities
                <span class="sub-section-label ms-2">photo cards</span>
            </h5>
            <p class="text-muted small mb-0">Infrastructure and amenities shown as photo cards in the Facilities section of the OSS page. Visitors can click a card to view the full photo.</p>
        </div>
        <a href="{{ route('cms.bies.create', ['page_group' => 'work', 'category' => 'facility']) }}" class="btn btn-success rounded-pill px-4 shadow-sm fw-bold">
            <i class="fa-solid fa-plus me-2"></i> Add Facility
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted" style="font-size: 0.82rem; letter-spacing: 1px;">
                        <tr>
                            <th class="ps-3 py-3" style="width: 48px;"><span class="visually-hidden">Reorder</span></th>
                                <th class="ps-4 py-3 text-uppercase" style="width: 110px;">Photo</th>
                            <th class="py-3 text-uppercase">Facility</th>
                            <th class="py-3 text-uppercase d-none d-md-table-cell">Description</th>
                            <th class="pe-4 py-3 text-uppercase text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody data-sortable-url="{{ route('cms.bies.reorder') }}">
                        @forelse($facilities as $item)
                        <tr data-id="{{ $item->id }}">
                            <td class="drag-handle ps-3 py-3" title="Drag to reorder" aria-label="Drag to reorder"><i class="fa-solid fa-grip-vertical"></i></td>
                            <td class="py-3">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="rounded-3 shadow-sm" style="width: 80px; height: 56px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted" style="width: 80px; height: 56px;">
                                        <i class="fa-solid fa-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="py-3">
                                <h6 class="mb-1 fw-bold text-dark">
                                    <i class="{{ $item->icon ?? 'fa-solid fa-industry' }} text-success me-1"></i> {{ $item->title }}
                                </h6>
                            </td>
                            <td class="py-3 d-none d-md-table-cell text-muted small">
                                {{ $item->description ? Str::limit(strip_tags($item->description), 80) : '—' }}
                            </td>
                            <td class="pe-4 py-3 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('cms.bies.edit', $item->id) }}" class="btn btn-sm btn-light text-primary rounded-circle shadow-sm" title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('cms.bies.destroy', $item->id) }}" method="POST" data-confirm="Delete this facility?">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light text-danger rounded-circle shadow-sm" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted small">
                                No facilities yet. <a href="{{ route('cms.bies.create', ['page_group' => 'work', 'category' => 'facility']) }}">Add one</a>.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    </div>

    </div>
</div>
@endsection

@include('cms.partials.sortable-assets')

@push('scripts')
<script src="{{ asset('assets/js/pages/cms-bie-page-index.js') }}"></script>
@endpush
