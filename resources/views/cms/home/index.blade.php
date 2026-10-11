@extends('layouts.main') 

@section('title', 'Manage Home - BIIE CMS')

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
        <li class="current">Manage Home</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-4 py-md-5 mt-2">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-start mb-5 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="fa-solid fa-house-chimney-window text-primary me-2"></i> Manage Home
            </h2>
            <p class="text-muted mb-0">Manage all content sections of the public <strong>Home</strong> page from one place.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('cms.dashboard') }}" class="btn btn-secondary rounded-pill px-4 fw-bold">
                <i class="fa-solid fa-arrow-left me-2"></i> Back
            </a>
            <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-primary rounded-pill px-4 fw-bold">
                <i class="fa-solid fa-arrow-up-right-from-square me-2"></i> View Live Page
            </a>
        </div>
    </div>

    {{-- Tab Navigation --}}
    <ul class="nav section-tab-nav gap-2 mb-5" id="homeTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="tab-estate" data-bs-toggle="tab" data-bs-target="#pane-estate" type="button" role="tab" aria-controls="pane-estate" aria-selected="true">
                <i class="fa-solid fa-industry me-1"></i> Our Industrial Estate
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-testimonials" data-bs-toggle="tab" data-bs-target="#pane-testimonials" type="button" role="tab" aria-controls="pane-testimonials" aria-selected="false">
                <i class="fa-solid fa-comments me-1"></i> Client Testimonials
                <span class="badge rounded-pill bg-white text-dark border ms-1" id="testimonialTabCount">{{ $testimonials->count() }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="tab-tenants" data-bs-toggle="tab" data-bs-target="#pane-tenants" type="button" role="tab" aria-controls="pane-tenants" aria-selected="false">
                <i class="fa-solid fa-users me-1"></i> Tenant Logos
                <span class="badge rounded-pill bg-white text-dark border ms-1">{{ $tenantCount }}</span>
            </button>
        </li>
    </ul>

    <div class="tab-content" id="homeTabContent">

    <div class="tab-pane fade show active" id="pane-estate" role="tabpanel" aria-labelledby="tab-estate">
    <!-- SECTION 1: OUR INDUSTRIAL ESTATE -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <h4 class="fw-bold text-dark mb-4">
                <i class="fa-solid fa-industry text-success me-2"></i> Our Industrial Estate &mdash; Heading &amp; Banner
            </h4>
            <form action="{{ route('cms.section-settings.update') }}" method="POST" enctype="multipart/form-data" class="js-banner-bg-form">
                @csrf
                <input type="hidden" name="section_key" value="bie">
                <div class="row g-3">
                    @include('cms.partials.section-heading-fields', ['key' => 'bie', 'setting' => $bieSetting])
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Banner Title</label>
                        <input type="text" name="title" class="form-control rounded-pill" value="{{ $bieSetting->title ?? 'Our Industrial Estate' }}" placeholder="Enter banner title">
                    </div>
                    @include('cms.partials.banner-background', ['key' => 'bie', 'setting' => $bieSetting])

                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                            <i class="fa-solid fa-save me-2"></i> Save Banner
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="fw-bold text-dark mb-0 fs-3">
                <i class="fa-solid fa-industry text-success me-2"></i> Our Industrial Estate
            </h2>
            <p class="text-muted small mb-0 mt-1">Alternating image+text rows shown below the banner on the home page.</p>
        </div>
        <a href="{{ route('cms.bies.create') }}" class="btn btn-success rounded-pill px-4 shadow-sm fw-bold">
            <i class="fa-solid fa-plus me-2"></i> Add Section
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted" style="font-size: 0.85rem; letter-spacing: 1px;">
                        <tr>
                            <th class="ps-3 py-3" style="width: 48px;"><span class="visually-hidden">Reorder</span></th>
                                <th class="ps-4 py-3 text-uppercase" style="width: 80px;">Media</th>
                            <th class="py-3 text-uppercase">Title & Type</th>
                            <th class="py-3 text-uppercase d-none d-md-table-cell">Description</th>
                            <th class="pe-4 py-3 text-uppercase text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody data-sortable-url="{{ route('cms.bies.reorder') }}">
                        @forelse($bies as $item)
                        <tr data-id="{{ $item->id }}">
                            <td class="drag-handle ps-3 py-3" title="Drag to reorder" aria-label="Drag to reorder"><i class="fa-solid fa-grip-vertical"></i></td>
                            <td class="py-3">
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
                            <td class="pe-4 py-3 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('cms.bies.edit', $item->id) }}" class="btn btn-sm btn-light text-primary rounded-circle shadow-sm" title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('cms.bies.destroy', $item->id) }}" method="POST" data-confirm="Delete this section?">
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
                                No industrial estate sections yet. <a href="{{ route('cms.bies.create') }}">Add one</a>.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    </div>

    <div class="tab-pane fade" id="pane-testimonials" role="tabpanel" aria-labelledby="tab-testimonials">
    <!-- SECTION 2: TESTIMONIALS -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0 fs-3">
                <i class="fa-solid fa-comments text-primary me-2"></i> Client Testimonials
            </h2>
            <p class="text-muted small mb-0 mt-1">Manage feedback and ratings displayed on the home page.</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" id="testimonialBulkDelete" data-url="{{ route('cms.testimonials.bulk-destroy') }}" class="btn btn-danger rounded-pill px-4 shadow-sm fw-bold d-none">
                <i class="fa-solid fa-trash me-2"></i> Delete Selected (<span id="testimonialSelCount">0</span>)
            </button>
            <a href="{{ route('cms.testimonials.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">
                <i class="fa-solid fa-plus me-2"></i> Add Testimonial
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="card-body p-0">
            <div class="table-responsive"> 
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted" style="font-size: 0.85rem; letter-spacing: 1px;">
                        <tr>
                            <th class="ps-4 py-3" style="width: 40px;">
                                <input type="checkbox" class="form-check-input" id="testimonialSelectAll">
                            </th>
                            <th class="py-3 text-uppercase" style="width: 100px;">Photo</th>
                            <th class="py-3 text-uppercase">Name & Position</th>
                            <th class="py-3 text-uppercase text-center">Stars</th>
                            <th class="py-3 text-uppercase d-none d-md-table-cell">Comment</th>
                            <th class="pe-4 py-3 text-uppercase text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="testimonialTableBody">
                        @forelse($testimonials as $t)
                        <tr data-testimonial-id="{{ $t->id }}">
                            <td class="ps-4 py-3">
                                <input type="checkbox" class="form-check-input testimonial-check" value="{{ $t->id }}">
                            </td>
                            <td class="py-3">
                                @if($t->photo)
                                    <img src="{{ asset('storage/' . $t->photo) }}" class="rounded-circle shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-muted" style="width: 50px; height: 50px;">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="py-3">
                                <h6 class="mb-1 fw-bold text-dark">{{ $t->name }}</h6>
                                <span class="text-muted small">{{ $t->position }}</span>
                            </td>
                            <td class="py-3 text-center">
                                @for($i = 0; $i < 5; $i++)
                                    <i class="fa-solid fa-star {{ $i < $t->stars ? 'text-warning' : 'text-light' }}" style="font-size: 0.7rem;"></i>
                                @endfor
                            </td>
                            <td class="py-3 d-none d-md-table-cell text-muted small">
                                {{ Str::limit($t->description, 80) }}
                            </td>
                            <td class="pe-4 py-3 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('cms.testimonials.edit', $t->id) }}" class="btn btn-sm btn-light text-primary rounded-circle shadow-sm">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('cms.testimonials.destroy', $t->id) }}" method="POST" class="js-delete-testimonial">
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
                            <td colspan="6" class="text-center py-5 text-muted">No testimonials found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    </div>

    <div class="tab-pane fade" id="pane-tenants" role="tabpanel" aria-labelledby="tab-tenants">
    <!-- SECTION 3: TENANT LOGOS -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="fw-bold text-dark mb-0 fs-3">
                <i class="fa-solid fa-users text-success me-2"></i> Tenant Logos
                <span class="badge bg-success-subtle text-success rounded-pill fs-6 ms-1 align-middle">{{ $tenantCount }}</span>
            </h2>
            <p class="text-muted small mb-0 mt-1">Tenant logos displayed in the partnership section of the home page.</p>
        </div>
        <a href="{{ route('cms.tenants.index') }}" class="btn btn-success rounded-pill px-4 shadow-sm fw-bold">
            <i class="fa-solid fa-gear me-2"></i> Manage Logos
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-5">
        <div class="card-body p-4">
            @if($tenants->isEmpty())
                <div class="text-center py-4 text-muted small">
                    No tenant logos uploaded yet. <a href="{{ route('cms.tenants.index') }}">Upload some</a>.
                </div>
            @else
                <div class="row g-3">
                    @foreach($tenants as $t)
                    <div class="col-4 col-md-3 col-lg-2">
                        <div class="rounded-4 d-flex align-items-center justify-content-center p-3" style="height: 80px; background: #f8f9fa;">
                            <img src="{{ asset('storage/' . $t->logo) }}" alt="{{ $t->name }}" title="{{ $t->name }}" class="img-fluid" style="max-height: 48px; object-fit: contain;">
                        </div>
                    </div>
                    @endforeach
                </div>
                @if($tenantCount > $tenants->count())
                    <div class="text-center mt-4">
                        <a href="{{ route('cms.tenants.index') }}" class="text-success fw-bold text-decoration-none small">
                            View all {{ $tenantCount }} logos <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                @endif
            @endif
        </div>
    </div>

    </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/components/bulk-delete.js') }}"></script>
<script src="{{ asset('assets/js/pages/cms-bie-page-index.js') }}"></script>
<script src="{{ asset('assets/js/pages/cms-home-index.js') }}"></script>
@endpush

@include('cms.partials.sortable-assets')
