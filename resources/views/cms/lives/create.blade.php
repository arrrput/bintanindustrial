@extends('layouts.main')

@section('title', 'Add Life Content - BIIE CMS')

@section('content')
<div class="page-title" data-aos="fade">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <nav class="breadcrumbs">
      <ol>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ route('cms.dashboard') }}">CMS</a></li>
        <li><a href="{{ route('cms.lives.index') }}">Life</a></li>
        <li class="current">Add Content</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-5 mt-2">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-success py-3 border-0">
                    <h5 class="mb-0 text-white fw-bold"><i class="fa-solid fa-plus-circle me-2"></i> Add New Life Content</h5>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('cms.lives.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row g-4">
                            <!-- Title -->
                            <div class="col-md-8">
                                <label class="form-label fw-bold text-dark">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="e.g., LIFE AT WORK" required>
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Category -->
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Category <span class="text-danger">*</span></label>
                                <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                                    <option value="work" {{ old('category') == 'work' ? 'selected' : '' }}>Life at Work</option>
                                    <option value="relaxation" {{ old('category') == 'relaxation' ? 'selected' : '' }}>Resort-Style Relaxation</option>
                                </select>
                                @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Subtitle / Quote -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-dark">Subtitle / Lead Text (Optional)</label>
                                <input type="text" name="subtitle" class="form-control @error('subtitle') is-invalid @enderror" value="{{ old('subtitle') }}" placeholder="e.g., A lush, tranquil environment...">
                                @error('subtitle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Image -->
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark">Cover Image</label>
                                <div class="p-4 border border-2 border-dashed rounded-3 text-center bg-light">
                                    <i class="fa-solid fa-cloud-arrow-up fs-1 text-muted mb-2"></i>
                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                </div>
                                @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark">Description <span class="text-danger">*</span></label>
                                <textarea name="description" rows="6" class="form-control @error('description') is-invalid @enderror" required placeholder="Write the detailed content here...">{{ old('description') }}</textarea>
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-5">
                            <a href="{{ route('cms.lives.index') }}" class="btn btn-light rounded-pill px-4 fw-bold">Cancel</a>
                            <button type="submit" class="btn btn-success rounded-pill px-5 shadow fw-bold">
                                <i class="fa-solid fa-save me-2"></i> Save Content
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
