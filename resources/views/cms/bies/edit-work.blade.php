@extends('layouts.main')

@section('title', 'Edit Facilities & Work Content - BIIE CMS')

@section('content')
<div class="page-title" data-aos="fade">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <nav class="breadcrumbs">
      <ol>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ route('cms.dashboard') }}">CMS</a></li>
        <li><a href="{{ route('cms.bie-page.index') }}">BIE Page</a></li>
        <li class="current">Edit Work Item</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-5 mt-2">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-primary py-3 border-0">
                    <h5 class="mb-0 text-white fw-bold"><i class="fa-solid fa-pen-to-square me-2"></i> Edit Facilities & Work Content</h5>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('cms.bies.update', $bie->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <!-- Title -->
                            <div class="col-md-8">
                                <label class="form-label fw-bold text-dark">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $bie->title) }}" required>
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Category -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Category <span class="text-danger">*</span></label>
                                <select name="category" id="categorySelect" class="form-select @error('category') is-invalid @enderror" required onchange="toggleFields()">
                                    <option value="main_section" {{ $bie->category == 'main_section' ? 'selected' : '' }}>Main Section (Full Width)</option>
                                    <option value="service_suite" {{ $bie->category == 'service_suite' ? 'selected' : '' }}>Service Suite (Card)</option>
                                </select>
                                @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Subtitle -->
                            <div id="subtitleField" class="col-md-12">
                                <label class="form-label fw-bold text-dark">Subtitle / Lead Text (Optional)</label>
                                <input type="text" name="subtitle" class="form-control @error('subtitle') is-invalid @enderror" value="{{ old('subtitle', $bie->subtitle) }}">
                                @error('subtitle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Icon Picker (for Service Suite) -->
                            <div id="iconField" class="col-md-4 d-none">
                                <label class="form-label fw-bold text-dark">Icon</label>
                                @include('cms.layouts.icon-picker-input', [
                                    'name' => 'icon',
                                    'inputId' => 'workIconInput',
                                    'previewId' => 'workIconPreview',
                                    'value' => old('icon', $bie->icon ?? 'fa-solid fa-gear')
                                ])
                                @error('icon') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>

                            <!-- Image -->
                            <div id="imageField" class="col-12">
                                <label class="form-label fw-bold text-dark">Cover Image</label>
                                <div class="row align-items-center g-3">
                                    <div class="col-md-3">
                                        @if($bie->image)
                                            <img src="{{ asset('storage/' . $bie->image) }}" class="img-fluid rounded-3 shadow-sm border">
                                        @else
                                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center border" style="height: 100px;">
                                                <i class="fa-solid fa-image fs-1 text-muted"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-9">
                                        <div class="p-3 border border-2 border-dashed rounded-3 text-center bg-light">
                                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                                @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark">Description <span class="text-danger">*</span></label>
                                <textarea name="description" rows="6" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $bie->description) }}</textarea>
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-5">
                            <a href="{{ route('cms.bie-page.index') }}" class="btn btn-light rounded-pill px-4 fw-bold">Cancel</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-5 shadow fw-bold">
                                <i class="fa-solid fa-save me-2"></i> Update Content
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('cms.layouts.icon-picker-modal')
@endsection

@push('scripts')
<script src="{{ asset('assets/js/pages/cms-bies-edit-work.js') }}"></script>
@endpush
