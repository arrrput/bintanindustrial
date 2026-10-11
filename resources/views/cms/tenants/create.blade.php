@extends('layouts.main')

@section('title', 'Add Tenant Logos - BIIE CMS')

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
        <li class="current">Add Logos</li>
      </ol>
    </nav>
  </div>
</div>

@php
    // Rebuild the rows after a failed validation (images have to be chosen again)
    $oldNames = old('names', ['']);
@endphp

<div class="container py-5 mt-2">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="mb-4">
                <a href="{{ route('cms.tenants.index') }}" class="btn btn-secondary rounded-pill px-4 fw-bold">
                    <i class="fa-solid fa-arrow-left me-2"></i> Back
                </a>
            </div>
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-success py-3 border-0">
                    <h5 class="mb-0 text-white fw-bold"><i class="fa-solid fa-plus-circle me-2"></i> Add Tenant Logos</h5>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('cms.tenants.store') }}" method="POST" enctype="multipart/form-data"
                          id="tenantLogoForm" data-own-upload data-no-compress
                          data-max-rows="{{ $limits['maxFiles'] }}"
                          data-max-file-bytes="{{ $limits['perFileBytes'] }}" data-max-file-human="{{ $limits['perFileHuman'] }}"
                          data-max-total-bytes="{{ $limits['totalBytes'] }}" data-max-total-human="{{ $limits['totalHuman'] }}">
                        @csrf

                        <p class="text-muted small mb-4">
                            <i class="fa-regular fa-clipboard me-1"></i>
                            For each logo, click the box, drag &amp; drop an image onto it, or press <kbd>Ctrl</kbd> + <kbd>V</kbd> to paste one.
                            <br><i class="fa-solid fa-server me-1"></i>
                            Server limits: up to <strong>{{ $limits['maxFiles'] }}</strong> logos per save,
                            <strong>{{ $limits['perFileHuman'] }}</strong> per logo, <strong>{{ $limits['totalHuman'] }}</strong> in total.
                            @if (old('names'))
                                <br><span class="text-danger"><i class="fa-solid fa-circle-info me-1"></i>Please choose the images again — browsers do not keep selected files after an error.</span>
                            @endif
                        </p>

                        <div id="logoRows">
                            @foreach ($oldNames as $i => $name)
                                @include('cms.tenants.partials.logo-row', ['index' => $i, 'name' => $name, 'required' => true, 'maxFileHuman' => $limits['perFileHuman']])
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                            <button type="button" class="btn btn-outline-success rounded-pill px-4 fw-bold" id="addLogoRow">
                                <i class="fa-solid fa-plus me-2"></i> Add another logo
                            </button>
                            <span class="text-muted small" id="logoRowCount"></span>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-5">
                            <a href="{{ route('cms.tenants.index') }}" class="btn btn-light rounded-pill px-4 fw-bold">Cancel</a>
                            <button type="submit" class="btn btn-success rounded-pill px-5 shadow fw-bold">
                                <i class="fa-solid fa-save me-2"></i> Save Logos
                            </button>
                        </div>
                    </form>

                    <template id="logoRowTemplate">
                        @include('cms.tenants.partials.logo-row', ['index' => '__INDEX__', 'name' => '', 'required' => true, 'maxFileHuman' => $limits['perFileHuman']])
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/pages/cms-tenants-form.js') }}"></script>
@endpush
