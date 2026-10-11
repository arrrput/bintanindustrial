@extends('layouts.main')

@section('title', 'Edit Tenant Logo - BIIE CMS')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/pages/cms-tenants-form.css') }}">
@endpush

@section('content')

<div class="page-title" data-aos="fade">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <nav class="breadcrumbs">
      <ol>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ route('cms.dashboard') }}">CMS</a></li>
        <li><a href="{{ route('cms.home.index') }}">Manage Home</a></li>
        <li><a href="{{ route('cms.tenants.index') }}">Tenant Logos</a></li>
        <li class="current">Edit Logo</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-5 mt-2">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="mb-4">
                <a href="{{ route('cms.tenants.index') }}" class="btn btn-secondary rounded-pill px-4 fw-bold">
                    <i class="fa-solid fa-arrow-left me-2"></i> Back
                </a>
            </div>
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-primary py-3 border-0">
                    <h5 class="mb-0 text-white fw-bold"><i class="fa-solid fa-pen-to-square me-2"></i> Edit Tenant Logo</h5>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('cms.tenants.update', $tenant) }}" method="POST" enctype="multipart/form-data"
                          id="tenantLogoForm" data-own-upload data-no-compress
                          data-max-file-bytes="{{ $limits['perFileBytes'] }}" data-max-file-human="{{ $limits['perFileHuman'] }}"
                          data-max-total-bytes="{{ $limits['totalBytes'] }}" data-max-total-human="{{ $limits['totalHuman'] }}">
                        @csrf
                        @method('PUT')

                        @include('cms.tenants.partials.logo-row', [
                            'index'    => null,
                            'name'     => old('name', $tenant->name),
                            'current'  => asset('storage/' . $tenant->logo),
                            'required' => false,
                            'maxFileHuman' => $limits['perFileHuman'],
                        ])

                        <div class="d-flex justify-content-end gap-2 mt-5">
                            <a href="{{ route('cms.tenants.index') }}" class="btn btn-light rounded-pill px-4 fw-bold">Cancel</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-5 shadow fw-bold">
                                <i class="fa-solid fa-save me-2"></i> Update Logo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/pages/cms-tenants-form.js') }}"></script>
@endpush
