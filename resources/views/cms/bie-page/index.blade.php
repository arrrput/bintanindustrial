@extends('layouts.main')

@section('title', 'Manage Profiles - BIIE CMS')

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
        <li class="current">Manage Profiles</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-4 py-md-5 mt-2">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-start mb-5 flex-wrap gap-3">
        <div>
                <i class="fa-solid fa-building-columns text-success me-2"></i> Manage Profiles
            </h2>
            <p class="text-muted mb-0">Manage the Bintan Island slider and Business Opportunity shown on the public <strong>Profile</strong> page.</p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('cms.dashboard') }}" class="btn btn-secondary rounded-pill px-4 fw-bold">
                <i class="fa-solid fa-arrow-left me-2"></i> Back
            </a>
            <a href="{{ route('profile') }}" target="_blank" class="btn btn-outline-success rounded-pill px-4 fw-bold">
                <i class="fa-solid fa-arrow-up-right-from-square me-2"></i> View Live Page
            </a>
        </div>
    </div>

    {{-- Tab Navigation --}}
    <ul class="nav section-tab-nav gap-2 mb-5" id="bieTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab-bintan" data-bs-toggle="tab" data-bs-target="#pane-bintan" type="button" role="tab">
                <i class="fa-solid fa-earth-asia me-1"></i> Bintan Island
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-business" data-bs-toggle="tab" data-bs-target="#pane-business" type="button" role="tab">
                <i class="fa-solid fa-briefcase me-1"></i> Business Opportunity
            </button>
        </li>
    </ul>

    <div class="tab-content" id="bieTabContent">

        {{-- TAB 1: BINTAN ISLAND                                   --}}
        {{-- ===================================================== --}}
        <div class="tab-pane fade show active" id="pane-bintan" role="tabpanel">

            {{-- Bintan Banner Settings --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-4">
                        <i class="fa-solid fa-image text-warning me-2"></i> Bintan Island &mdash; Heading &amp; Banner
                    </h5>
                    <form action="{{ route('cms.section-settings.update') }}" method="POST" enctype="multipart/form-data" class="js-banner-bg-form">
                        @csrf
                        <input type="hidden" name="section_key" value="bintan">
                        <div class="row g-3">
                            @include('cms.partials.section-heading-fields', ['key' => 'bintan', 'setting' => $bintanSetting])
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Banner Title</label>
                                <input type="text" name="title" class="form-control rounded-pill" value="{{ $bintanSetting->title ?? 'Bintan Island' }}" placeholder="Enter banner title">
                            </div>
                            @include('cms.partials.banner-background', ['key' => 'bintan', 'setting' => $bintanSetting])
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                                    <i class="fa-solid fa-save me-2"></i> Save Banner
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Bintan Slider Items Table --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-images text-warning me-2"></i> Bintan Slider Items
                    </h5>
                    <p class="text-muted small mb-0 mt-1">Each item is one slide in the Bintan Island swiper with its description.</p>
                </div>
                <a href="{{ route('cms.bies.create', ['page_group' => 'bintan']) }}" class="btn btn-warning text-dark rounded-pill px-4 shadow-sm fw-bold">
                    <i class="fa-solid fa-plus me-2"></i> Add Slide
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted" style="font-size: 0.82rem; letter-spacing: 1px;">
                                <tr>
                                    <th class="ps-3 py-3" style="width: 48px;"><span class="visually-hidden">Reorder</span></th>
                                <th class="ps-4 py-3 text-uppercase" style="width: 80px;">Image</th>
                                    <th class="py-3 text-uppercase">Title & Layout</th>
                                    <th class="py-3 text-uppercase d-none d-md-table-cell">Description</th>
                                    <th class="pe-4 py-3 text-uppercase text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody data-sortable-url="{{ route('cms.bies.reorder') }}">
                                @forelse($bintans as $item)
                                <tr data-id="{{ $item->id }}">
                                    <td class="drag-handle ps-3 py-3" title="Drag to reorder" aria-label="Drag to reorder"><i class="fa-solid fa-grip-vertical"></i></td>
                                    <td class="py-3">
                                        @if($item->image)
                                            @if(Str::startsWith($item->image, 'Bintan/'))
                                                <img src="{{ asset('assets/img/' . $item->image) }}" class="rounded-3 shadow-sm" style="width: 56px; height: 56px; object-fit: cover;">
                                            @else
                                                <img src="{{ asset('storage/' . $item->image) }}" class="rounded-3 shadow-sm" style="width: 56px; height: 56px; object-fit: cover;">
                                            @endif
                                        @elseif($item->icon)
                                            <div class="bg-warning-subtle text-warning rounded-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                                                <i class="{{ $item->icon }} fs-4"></i>
                                            </div>
                                        @else
                                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted" style="width: 56px; height: 56px;">
                                                <i class="fa-solid fa-image"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        <h6 class="mb-1 fw-bold text-dark">{{ $item->title }}</h6>
                                        <span class="badge {{ match($item->layout_style) { 'info_grid' => 'bg-info', 'advantage_grid' => 'bg-success', default => 'bg-secondary' } }} px-2 py-1 rounded-pill text-uppercase" style="font-size: 0.62rem;">
                                            {{ str_replace('_', ' ', $item->layout_style ?? 'default') }}
                                        </span>
                                    </td>
                                    <td class="py-3 d-none d-md-table-cell text-muted small">
                                        {{ Str::limit(strip_tags($item->description), 80) }}
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('cms.bies.edit', $item->id) }}" class="btn btn-sm btn-light text-primary rounded-circle shadow-sm" title="Edit">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <form action="{{ route('cms.bies.destroy', $item->id) }}" method="POST" data-confirm="Delete this slide?">
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
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-folder-open fs-1 mb-3 d-block text-light"></i>
                                        No Bintan slides yet. <a href="{{ route('cms.bies.create', ['page_group' => 'bintan']) }}">Add one</a>.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        {{-- ===================================================== --}}
        {{-- TAB 2: BUSINESS OPPORTUNITY                           --}}
        {{-- ===================================================== --}}
        <div class="tab-pane fade" id="pane-business" role="tabpanel">

            {{-- Business Opportunity Banner Settings --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-4">
                        <i class="fa-solid fa-image text-info me-2"></i> Business Opportunity &mdash; Heading &amp; Banner
                    </h5>
                    <form action="{{ route('cms.section-settings.update') }}" method="POST" enctype="multipart/form-data" class="js-banner-bg-form">
                        @csrf
                        <input type="hidden" name="section_key" value="work">
                        <div class="row g-3">
                            @include('cms.partials.section-heading-fields', ['key' => 'work', 'setting' => $workSetting])
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Banner Title</label>
                                <input type="text" name="title" class="form-control rounded-pill" value="{{ $workSetting->title ?? 'Business Opportunity' }}" placeholder="Enter banner title">
                            </div>
                            @include('cms.partials.banner-background', ['key' => 'work', 'setting' => $workSetting])
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                                    <i class="fa-solid fa-save me-2"></i> Save Banner
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Business Opportunity (main_section) --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="fw-bold text-dark mb-1">
                        <i class="fa-solid fa-briefcase text-info me-2"></i> Business Opportunity
                        <span class="sub-section-label ms-2">main section</span>
                    </h5>
                    <p class="text-muted small mb-0">Alternating image + text rows (e.g. Prepared Land Parcels, Ready Built Factories) on the Profile page.</p>
                </div>
                <a href="{{ route('cms.bies.create', ['page_group' => 'work', 'category' => 'main_section']) }}" class="btn btn-info text-white rounded-pill px-4 shadow-sm fw-bold">
                    <i class="fa-solid fa-plus me-2"></i> Add Item
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted" style="font-size: 0.82rem; letter-spacing: 1px;">
                                <tr>
                                    <th class="ps-3 py-3" style="width: 48px;"><span class="visually-hidden">Reorder</span></th>
                                <th class="ps-4 py-3 text-uppercase" style="width: 80px;">Image</th>
                                    <th class="py-3 text-uppercase">Title</th>
                                    <th class="py-3 text-uppercase d-none d-md-table-cell">Description</th>
                                    <th class="pe-4 py-3 text-uppercase text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody data-sortable-url="{{ route('cms.bies.reorder') }}">
                                @forelse($mainWorks as $item)
                                <tr data-id="{{ $item->id }}">
                                    <td class="drag-handle ps-3 py-3" title="Drag to reorder" aria-label="Drag to reorder"><i class="fa-solid fa-grip-vertical"></i></td>
                                    <td class="py-3">
                                        @if($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" class="rounded-3 shadow-sm" style="width: 56px; height: 56px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted" style="width: 56px; height: 56px;">
                                                <i class="fa-solid fa-image"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-3">
                                        <h6 class="mb-1 fw-bold text-dark">{{ $item->title }}</h6>
                                        @if($item->subtitle)
                                            <span class="text-muted small fst-italic">{{ Str::limit($item->subtitle, 50) }}</span>
                                        @endif
                                    </td>
                                    <td class="py-3 d-none d-md-table-cell text-muted small">
                                        {{ Str::limit(strip_tags($item->description), 80) }}
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('cms.bies.edit', $item->id) }}" class="btn btn-sm btn-light text-primary rounded-circle shadow-sm" title="Edit">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <form action="{{ route('cms.bies.destroy', $item->id) }}" method="POST" data-confirm="Delete this item?">
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
                                    <td colspan="5" class="text-center py-4 text-muted small">No business opportunity items yet.</td>
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

@push('scripts')
<script src="{{ asset('assets/js/pages/cms-bie-page-index.js') }}"></script>
@endpush

@include('cms.partials.sortable-assets')
