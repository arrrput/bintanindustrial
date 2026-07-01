@extends('layouts.main')

@section('title', 'Add Testimonial - BIIE CMS')

@section('content')
<div class="page-title" data-aos="fade">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <nav class="breadcrumbs">
      <ol>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ route('cms.dashboard') }}">CMS</a></li>
        <li><a href="{{ route('cms.home.index') }}">Clients</a></li>
        <li class="current">Add Testimonial</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-5 mt-2">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-success py-3 border-0">
                    <h5 class="mb-0 text-white fw-bold"><i class="fa-solid fa-plus-circle me-2"></i> Add New Testimonial</h5>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('cms.testimonials.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row g-4">
                            <!-- Name -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Client Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control rounded-pill @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="e.g., John Doe" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Position -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Position <span class="text-danger">*</span></label>
                                <input type="text" name="position" class="form-control rounded-pill @error('position') is-invalid @enderror" value="{{ old('position') }}" placeholder="e.g., CEO, Tech Corp" required>
                                @error('position') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Stars -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-dark">Rating (Stars) <span class="text-danger">*</span></label>
                                <div class="d-flex gap-3">
                                    @for($i = 1; $i <= 5; $i++)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="stars" id="star{{ $i }}" value="{{ $i }}" {{ old('stars', 5) == $i ? 'checked' : '' }}>
                                        <label class="form-check-label" for="star{{ $i }}">{{ $i }} <i class="fa-solid fa-star text-warning"></i></label>
                                    </div>
                                    @endfor
                                </div>
                                @error('stars') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <!-- Image -->
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark">Client Photo</label>
                                <div class="p-4 border border-2 border-dashed rounded-3 text-center bg-light">
                                    <i class="fa-solid fa-cloud-arrow-up fs-1 text-muted mb-2"></i>
                                    <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/*">
                                </div>
                                @error('photo') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark">Testimonial Content <span class="text-danger">*</span></label>
                                <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror" required placeholder="Write the client's feedback here...">{{ old('description') }}</textarea>
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-5">
                            <a href="{{ route('cms.home.index') }}" class="btn btn-light rounded-pill px-4 fw-bold">Cancel</a>
                            <button type="submit" class="btn btn-success rounded-pill px-5 shadow fw-bold">
                                <i class="fa-solid fa-save me-2"></i> Save Testimonial
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
