@extends('layouts.main')

@section('title', 'Manage Tenant Logos - BIIE CMS')

@section('content')

<div class="page-title" data-aos="fade">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <nav class="breadcrumbs">
      <ol>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ route('cms.dashboard') }}">CMS</a></li>
        <li><a href="{{ route('cms.home.index') }}">Manage Home</a></li>
        <li class="current">Tenant Logos</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-4 py-md-5 mt-2">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-start mb-5 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="fa-solid fa-users text-success me-2"></i> Manage Tenant Logos
            </h2>
            <p class="text-muted mb-0">Manage the tenant logos shown in the partnership section of the public <strong>Home</strong> page.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('cms.home.index') }}" class="btn btn-secondary rounded-pill px-4 fw-bold">
                <i class="fa-solid fa-arrow-left me-2"></i> Back
            </a>
            <a href="{{ route('home') }}#clients" target="_blank" class="btn btn-outline-primary rounded-pill px-4 fw-bold">
                <i class="fa-solid fa-arrow-up-right-from-square me-2"></i> View Live Page
            </a>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold text-dark mb-0">
                Tenant Logos
                <span id="tenantTotal" class="badge bg-success-subtle text-success rounded-pill fs-6 ms-1 align-middle">{{ $tenants->count() }}</span>
            </h4>
            <p class="text-muted small mb-0 mt-1">The alternative text is read by screen readers and shown when visitors hover over a logo.</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" id="tenantBulkDelete" data-url="{{ route('cms.tenants.bulk-destroy') }}" class="btn btn-danger rounded-pill px-4 shadow-sm fw-bold d-none">
                <i class="fa-solid fa-trash me-2"></i> Delete Selected (<span id="tenantSelCount">0</span>)
            </button>
            <a href="{{ route('cms.tenants.create') }}" class="btn btn-success rounded-pill px-4 shadow-sm fw-bold">
                <i class="fa-solid fa-plus me-2"></i> Add Logos
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
                                <input type="checkbox" class="form-check-input" id="tenantSelectAll" aria-label="Select all logos">
                            </th>
                            <th class="py-3 text-uppercase" style="width: 180px;">Logo</th>
                            <th class="py-3 text-uppercase">Alternative Text</th>
                            <th class="py-3 text-uppercase d-none d-md-table-cell">Added</th>
                            <th class="pe-4 py-3 text-uppercase text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tenantList">
                        @forelse($tenants as $t)
                        <tr data-tenant-id="{{ $t->id }}">
                            <td class="ps-4 py-3">
                                <input type="checkbox" class="form-check-input tenant-check" value="{{ $t->id }}" aria-label="Select {{ $t->name }}">
                            </td>
                            <td class="py-3">
                                <div class="rounded-3 border d-flex align-items-center justify-content-center p-2" style="width: 140px; height: 72px; background: #f8f9fa;">
                                    <img src="{{ asset('storage/' . $t->logo) }}" alt="{{ $t->name }}" title="{{ $t->name }}" class="img-fluid" style="max-height: 52px; object-fit: contain;">
                                </div>
                            </td>
                            <td class="py-3">
                                <span class="fw-bold text-dark">{{ $t->name ?: '—' }}</span>
                            </td>
                            <td class="py-3 d-none d-md-table-cell text-muted small">{{ $t->created_at?->format('d M Y') }}</td>
                            <td class="pe-4 py-3 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('cms.tenants.edit', $t) }}" class="btn btn-sm btn-light text-primary rounded-circle shadow-sm" title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('cms.tenants.destroy', $t) }}" method="POST" data-confirm="Delete the logo &quot;{{ $t->name }}&quot;?">
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
                                No tenant logos yet. <a href="{{ route('cms.tenants.create') }}">Add some</a>.
                            </td>
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
<script src="{{ asset('assets/js/components/bulk-delete.js') }}"></script>
<script src="{{ asset('assets/js/pages/cms-tenants-index.js') }}"></script>
@endpush
