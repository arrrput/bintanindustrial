@extends('layouts.main')

@section('title', 'Manage BIE Page - BIIE CMS')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/pages/cms-bie-page-index.css') }}">
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
        <li class="current">BIE Page</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-4 py-md-5 mt-2">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-start mb-5 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="fa-solid fa-building-columns text-success me-2"></i> Manage BIE Page
            </h2>
            <p class="text-muted mb-0">Manage all content sections of the public <strong>/bie</strong> page from one place.</p>
        </div>
        <a href="{{ url('/bie') }}" target="_blank" class="btn btn-outline-success rounded-pill px-4 fw-bold">
            <i class="fa-solid fa-arrow-up-right-from-square me-2"></i> View Live Page
        </a>
    </div>

    {{-- Tab Navigation --}}
    <ul class="nav section-tab-nav gap-2 mb-5" id="bieTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab-bie" data-bs-toggle="tab" data-bs-target="#pane-bie" type="button" role="tab">
                Section 1
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-bintan" data-bs-toggle="tab" data-bs-target="#pane-bintan" type="button" role="tab">
                Section 2
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-work" data-bs-toggle="tab" data-bs-target="#pane-work" type="button" role="tab">
                Section 3
            </button>
        </li>
    </ul>

    <div class="tab-content" id="bieTabContent">

        {{-- ===================================================== --}}
        {{-- TAB 1: BIE SECTIONS                                    --}}
        {{-- ===================================================== --}}
        <div class="tab-pane fade show active" id="pane-bie" role="tabpanel">

            {{-- BIE Banner Settings --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-4">
                        <i class="fa-solid fa-image text-success me-2"></i> Hero Banner Settings
                    </h5>
                    <form action="{{ route('cms.section-settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="section_key" value="bie">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Banner Title</label>
                                <input type="text" name="title" class="form-control rounded-pill" value="{{ $bieSetting->title ?? 'Our Industrial Estate' }}" placeholder="Enter banner title">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Add Background Images</label>
                                <input type="file" name="background_images[]" class="form-control rounded-pill" multiple accept="image/*">
                            </div>
                            @if($bieSetting && $bieSetting->background_images && count($bieSetting->background_images) > 0)
                            <div class="col-12">
                                <label class="form-label small fw-bold">Current Images <span class="text-muted fw-normal">(click × to remove)</span></label>
                                <div class="d-flex flex-wrap gap-3">
                                    @foreach($bieSetting->background_images as $img)
                                    <div class="position-relative border rounded p-1 shadow-sm" style="width: 120px;">
                                        <img src="{{ asset('storage/' . $img) }}" class="rounded w-100" style="height: 80px; object-fit: cover;">
                                        <div class="position-absolute top-0 end-0 p-1">
                                            <input type="checkbox" name="remove_images[]" value="{{ $img }}" id="del_bie_{{ $loop->index }}" class="d-none">
                                            <label for="del_bie_{{ $loop->index }}" class="btn btn-danger btn-sm rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 25px; height: 25px; cursor: pointer;" onclick="this.parentElement.parentElement.style.opacity='0.3';">
                                                <i class="fa-solid fa-xmark" style="font-size: 0.7rem;"></i>
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                                    <i class="fa-solid fa-save me-2"></i> Save Banner
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- BIE Content Table --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-list text-success me-2"></i> BIE Content Sections
                    </h5>
                    <p class="text-muted small mb-0 mt-1">Alternating image+text rows shown below the banner.</p>
                </div>
                <a href="{{ route('cms.bies.create') }}" class="btn btn-success rounded-pill px-4 shadow-sm fw-bold">
                    <i class="fa-solid fa-plus me-2"></i> Add Section
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted" style="font-size: 0.82rem; letter-spacing: 1px;">
                                <tr>
                                    <th class="ps-4 py-3 text-uppercase" style="width: 80px;">Media</th>
                                    <th class="py-3 text-uppercase">Title & Type</th>
                                    <th class="py-3 text-uppercase d-none d-md-table-cell">Description</th>
                                    <th class="py-3 text-uppercase text-center">Order</th>
                                    <th class="pe-4 py-3 text-uppercase text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bies as $item)
                                <tr>
                                    <td class="ps-4 py-3">
                                        @if($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" class="rounded-3 shadow-sm" style="width: 56px; height: 56px; object-fit: cover;">
                                        @elseif($item->icon)
                                            <div class="bg-success-subtle text-success rounded-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
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
                                        @if($item->badge)
                                            <span class="badge bg-light text-secondary border me-1 px-2 py-1 rounded-pill" style="font-size: 0.62rem;">{{ $item->badge }}</span>
                                        @endif
                                        <span class="badge {{ $item->category == 'main_section' ? 'bg-primary' : 'bg-success' }} px-2 py-1 rounded-pill text-uppercase" style="font-size: 0.62rem;">
                                            {{ str_replace('_', ' ', $item->category) }}
                                        </span>
                                    </td>
                                    <td class="py-3 d-none d-md-table-cell text-muted small">
                                        {{ Str::limit(strip_tags($item->description), 80) }}
                                    </td>
                                    <td class="py-3 text-center">
                                        <span class="badge bg-light text-dark border">{{ $item->order }}</span>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('cms.bies.edit', $item->id) }}" class="btn btn-sm btn-light text-primary rounded-circle shadow-sm" title="Edit">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <form action="{{ route('cms.bies.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this section?');">
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
                                        No BIE sections yet. <a href="{{ route('cms.bies.create') }}">Add one</a>.
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
        {{-- TAB 3: FACILITIES (Section 3)                          --}}
        {{-- ===================================================== --}}
        <div class="tab-pane fade" id="pane-work" role="tabpanel">

            {{-- Facilities Banner Settings --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-4">
                        <i class="fa-solid fa-image text-info me-2"></i> Hero Banner Settings
                    </h5>
                    <form action="{{ route('cms.section-settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="section_key" value="work">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Banner Title</label>
                                <input type="text" name="title" class="form-control rounded-pill" value="{{ $workSetting->title ?? 'Facilities' }}" placeholder="Enter banner title">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Add Background Images</label>
                                <input type="file" name="background_images[]" class="form-control rounded-pill" multiple accept="image/*">
                            </div>
                            @if($workSetting && $workSetting->background_images && count($workSetting->background_images) > 0)
                            <div class="col-12">
                                <label class="form-label small fw-bold">Current Images <span class="text-muted fw-normal">(click × to remove)</span></label>
                                <div class="d-flex flex-wrap gap-3">
                                    @foreach($workSetting->background_images as $img)
                                    <div class="position-relative border rounded p-1 shadow-sm" style="width: 120px;">
                                        <img src="{{ asset('storage/' . $img) }}" class="rounded w-100" style="height: 80px; object-fit: cover;">
                                        <div class="position-absolute top-0 end-0 p-1">
                                            <input type="checkbox" name="remove_images[]" value="{{ $img }}" id="del_work_{{ $loop->index }}" class="d-none">
                                            <label for="del_work_{{ $loop->index }}" class="btn btn-danger btn-sm rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 25px; height: 25px; cursor: pointer;" onclick="this.parentElement.parentElement.style.opacity='0.3';">
                                                <i class="fa-solid fa-xmark" style="font-size: 0.7rem;"></i>
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                                    <i class="fa-solid fa-save me-2"></i> Save Banner
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Facilities (main_section) --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="fw-bold text-dark mb-1">
                        <i class="fa-solid fa-warehouse text-info me-2"></i> Facilities
                        <span class="sub-section-label ms-2">main section</span>
                    </h5>
                    <p class="text-muted small mb-0">Alternating image+text rows for facilities content.</p>
                </div>
                <a href="{{ route('cms.bies.create', ['page_group' => 'work']) }}" class="btn btn-info text-white rounded-pill px-4 shadow-sm fw-bold">
                    <i class="fa-solid fa-plus me-2"></i> Add Item
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted" style="font-size: 0.82rem; letter-spacing: 1px;">
                                <tr>
                                    <th class="ps-4 py-3 text-uppercase" style="width: 80px;">Image</th>
                                    <th class="py-3 text-uppercase">Title</th>
                                    <th class="py-3 text-uppercase d-none d-md-table-cell">Description</th>
                                    <th class="py-3 text-uppercase text-center">Order</th>
                                    <th class="pe-4 py-3 text-uppercase text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mainWorks as $item)
                                <tr>
                                    <td class="ps-4 py-3">
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
                                    <td class="py-3 text-center">
                                        <span class="badge bg-light text-dark border">{{ $item->order }}</span>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('cms.bies.edit', $item->id) }}" class="btn btn-sm btn-light text-primary rounded-circle shadow-sm" title="Edit">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <form action="{{ route('cms.bies.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this item?');">
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
                                    <td colspan="5" class="text-center py-4 text-muted small">No facility items yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        {{-- ===================================================== --}}
        {{-- TAB 2: BINTAN ISLAND (Section 2)                       --}}
        {{-- ===================================================== --}}
        <div class="tab-pane fade" id="pane-bintan" role="tabpanel">

            {{-- Bintan Banner Settings --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold text-dark mb-4">
                        <i class="fa-solid fa-image text-warning me-2"></i> Hero Banner Settings
                    </h5>
                    <form action="{{ route('cms.section-settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="section_key" value="bintan">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Banner Title</label>
                                <input type="text" name="title" class="form-control rounded-pill" value="{{ $bintanSetting->title ?? 'Bintan Island' }}" placeholder="Enter banner title">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Add Background Images</label>
                                <input type="file" name="background_images[]" class="form-control rounded-pill" multiple accept="image/*">
                            </div>
                            @if($bintanSetting && $bintanSetting->background_images && count($bintanSetting->background_images) > 0)
                            <div class="col-12">
                                <label class="form-label small fw-bold">Current Images <span class="text-muted fw-normal">(click × to remove)</span></label>
                                <div class="d-flex flex-wrap gap-3">
                                    @foreach($bintanSetting->background_images as $img)
                                    <div class="position-relative border rounded p-1 shadow-sm" style="width: 120px;">
                                        <img src="{{ asset('storage/' . $img) }}" class="rounded w-100" style="height: 80px; object-fit: cover;">
                                        <div class="position-absolute top-0 end-0 p-1">
                                            <input type="checkbox" name="remove_images[]" value="{{ $img }}" id="del_bintan_{{ $loop->index }}" class="d-none">
                                            <label for="del_bintan_{{ $loop->index }}" class="btn btn-danger btn-sm rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 25px; height: 25px; cursor: pointer;" onclick="this.parentElement.parentElement.style.opacity='0.3';">
                                                <i class="fa-solid fa-xmark" style="font-size: 0.7rem;"></i>
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
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
                                    <th class="ps-4 py-3 text-uppercase" style="width: 80px;">Image</th>
                                    <th class="py-3 text-uppercase">Title & Layout</th>
                                    <th class="py-3 text-uppercase d-none d-md-table-cell">Description</th>
                                    <th class="py-3 text-uppercase text-center">Order</th>
                                    <th class="pe-4 py-3 text-uppercase text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bintans as $item)
                                <tr>
                                    <td class="ps-4 py-3">
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
                                    <td class="py-3 text-center">
                                        <span class="badge bg-light text-dark border">{{ $item->order }}</span>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('cms.bies.edit', $item->id) }}" class="btn btn-sm btn-light text-primary rounded-circle shadow-sm" title="Edit">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <form action="{{ route('cms.bies.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this slide?');">
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

            <hr class="section-divider">

            {{-- One Stop Service Suite --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="fw-bold text-dark mb-1">
                        <i class="fa-solid fa-screwdriver-wrench text-warning me-2"></i> One Stop Service Suite
                        <span class="sub-section-label ms-2">service suite</span>
                    </h5>
                    <p class="text-muted small mb-0">Icon cards shown below the Bintan slider.</p>
                </div>
                <a href="{{ route('cms.bies.create', ['page_group' => 'work']) }}" class="btn btn-warning text-dark rounded-pill px-4 shadow-sm fw-bold">
                    <i class="fa-solid fa-plus me-2"></i> Add Service
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted" style="font-size: 0.82rem; letter-spacing: 1px;">
                                <tr>
                                    <th class="ps-4 py-3 text-uppercase" style="width: 80px;">Icon</th>
                                    <th class="py-3 text-uppercase">Service Name</th>
                                    <th class="py-3 text-uppercase d-none d-md-table-cell">Description</th>
                                    <th class="py-3 text-uppercase text-center">Order</th>
                                    <th class="pe-4 py-3 text-uppercase text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($suiteWorks as $item)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="bg-warning-subtle text-warning rounded-3 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                                            <i class="{{ $item->icon ?? 'fa-solid fa-gear' }} fs-4"></i>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <h6 class="mb-0 fw-bold text-dark">{{ $item->title }}</h6>
                                    </td>
                                    <td class="py-3 d-none d-md-table-cell text-muted small">
                                        {{ Str::limit(strip_tags($item->description), 80) }}
                                    </td>
                                    <td class="py-3 text-center">
                                        <span class="badge bg-light text-dark border">{{ $item->order }}</span>
                                    </td>
                                    <td class="pe-4 py-3 text-end">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('cms.bies.edit', $item->id) }}" class="btn btn-sm btn-light text-primary rounded-circle shadow-sm" title="Edit">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <form action="{{ route('cms.bies.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this service?');">
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

    </div>

</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/pages/cms-bie-page-index.js') }}"></script>
@endpush
