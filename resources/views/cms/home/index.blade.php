@extends('layouts.main') 

@section('title', 'Manage Home - BIIE CMS')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/pages/cms-home-index.css') }}">
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
        <li class="current">Manage Home</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-4 py-md-5 mt-2">
    
    <!-- SECTION 1: TESTIMONIALS -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0 fs-3">
                <i class="fa-solid fa-comments text-primary me-2"></i> Client Testimonials
            </h2>
            <p class="text-muted small mb-0 mt-1">Manage feedback and ratings displayed on the home page.</p>
        </div>
        <a href="{{ route('cms.testimonials.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">
            <i class="fa-solid fa-plus me-2"></i> Add Testimonial
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="card-body p-0">
            <div class="table-responsive"> 
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted" style="font-size: 0.85rem; letter-spacing: 1px;">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase" style="width: 100px;">Photo</th>
                            <th class="py-3 text-uppercase">Name & Position</th>
                            <th class="py-3 text-uppercase text-center">Stars</th>
                            <th class="py-3 text-uppercase d-none d-md-table-cell">Comment</th>
                            <th class="pe-4 py-3 text-uppercase text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($testimonials as $t)
                        <tr>
                            <td class="ps-4 py-3">
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
                                    <form action="{{ route('cms.testimonials.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Delete this testimonial?');">
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
                            <td colspan="5" class="text-center py-5 text-muted">No testimonials found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- SECTION 2: TENANT LOGOS -->
    <div class="card border-0 shadow-sm rounded-4 mb-5">
        <div class="card-body p-4 text-center">
            <h4 class="fw-bold text-dark mb-4 text-start">
                <i class="fa-solid fa-users text-success me-2"></i> Manage Tenant Logos
            </h4>
            <form action="{{ route('cms.tenants.store') }}" method="POST" enctype="multipart/form-data" id="tenantUploadForm">
                @csrf
                <div class="p-5 border border-2 border-dashed rounded-4 bg-light mb-4 position-relative d-flex flex-column align-items-center justify-content-center">
                    <i class="fa-solid fa-images fs-1 text-muted mb-3"></i>
                    <p class="mb-3 text-secondary">Click "Browse" or drag and drop tenant logos here</p>
                    <input type="file" name="logos[]" id="tenantLogosInput" class="form-control position-absolute inset-0 opacity-0 w-100 h-100" style="cursor: pointer; z-index: 2;" multiple onchange="document.getElementById('tenantUploadForm').submit()">
                    <button type="button" class="btn btn-outline-success rounded-pill px-4 fw-bold position-relative" style="z-index: 1;">
                        <i class="fa-solid fa-folder-open me-2"></i> Browse Files
                    </button>
                </div>
            </form>

            <div class="row g-4 text-start">
                @forelse($tenants as $t)
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden position-relative group" style="background: #f8f9fa;">
                        <div class="p-3 d-flex align-items-center justify-content-center" style="height: 100px;">
                            <img src="{{ asset('storage/' . $t->logo) }}" class="img-fluid" style="max-height: 60px; object-fit: contain;">
                        </div>
                        <div class="position-absolute top-0 end-0 p-2">
                            <form action="{{ route('cms.tenants.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Delete this logo?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 25px; height: 25px;">
                                    <i class="fa-solid fa-xmark" style="font-size: 0.7rem;"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-4 text-muted small">No tenant logos uploaded yet.</div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/pages/cms-home-index.js') }}"></script>
@endpush
