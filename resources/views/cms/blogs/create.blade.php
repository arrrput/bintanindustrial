@extends('layouts.main')
@section('title', 'Create New Article - BIIE CMS')

@section('content')
<div class="page-title" data-aos="fade">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <nav class="breadcrumbs">
      <ol>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ route('cms.dashboard') }}">CMS</a></li>
        <li><a href="{{ route('cms.blogs.index') }}">Blogs</a></li>
        <li class="current">Create Article</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-5 mt-2">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-success py-3 border-0">
                    <h5 class="mb-0 text-white fw-bold"><i class="fa-solid fa-pen-nib me-2"></i> Write New Article</h5>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('cms.blogs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">
                            <div class="col-lg-8">
                                <div class="row g-4">
                                    <div class="col-12">
                                        <label class="form-label fw-bold text-dark">Article Title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-lg @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" placeholder="Enter an engaging title..." required>
                                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold text-dark">SEO Slug <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-muted small">{{ url('/blog') }}/</span>
                                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}" required>
                                        </div>
                                        @error('slug') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold text-dark">Full Content <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="12" placeholder="Write your article here..." required>{{ old('content') }}</textarea>
                                        @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card border-0 bg-light p-4 rounded-4 mb-4">
                                    <label class="form-label fw-bold text-dark">Featured Image(s)</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image[]" accept="image/*" multiple onchange="previewImages(event)" required>
                                    <div id="previewContainer" class="mt-3 d-flex flex-wrap gap-2"></div>
                                    @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>

                                <div class="card border-0 p-4 rounded-4 bg-primary-subtle border border-primary-subtle">
                                    <h6 class="fw-bold text-primary mb-3"><i class="fa-brands fa-instagram me-2"></i> Instagram Automation</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" role="switch" id="post_to_ig" name="post_to_ig" value="1" {{ old('post_to_ig') ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="post_to_ig">Auto-post to IG</label>
                                    </div>
                                    <label class="form-label fw-bold text-dark small">IG Caption / Excerpt</label>
                                    <textarea class="form-control" name="excerpt" rows="4" placeholder="Social media caption...">{{ old('excerpt') }}</textarea>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-5">
                                    <a href="{{ route('cms.blogs.index') }}" class="btn btn-light rounded-pill px-4 fw-bold">Cancel</a>
                                    <button type="submit" class="btn btn-primary rounded-pill px-5 shadow fw-bold">
                                        <i class="fa-solid fa-save me-2"></i> Save Article
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/pages/cms-blogs-create.js') }}"></script>
@endpush
