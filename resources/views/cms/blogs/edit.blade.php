@extends('layouts.main')
@section('title', 'Edit Article - BIIE CMS')

@section('content')
<div class="page-title" data-aos="fade">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <nav class="breadcrumbs">
      <ol>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ route('cms.dashboard') }}">CMS</a></li>
        <li><a href="{{ route('cms.blogs.index') }}">Blogs</a></li>
        <li class="current">Edit Article</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-5 mt-2">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-primary py-3 border-0">
                    <h5 class="mb-0 text-white fw-bold"><i class="fa-solid fa-pen-to-square me-2"></i> Edit Article</h5>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('cms.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row g-4">
                            <div class="col-lg-8">
                                <div class="row g-4">
                                    <div class="col-12">
                                        <label class="form-label fw-bold text-dark">Article Title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-lg @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $blog->title) }}" required>
                                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold text-dark">SEO Slug <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-muted small">{{ url('/blog') }}/</span>
                                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $blog->slug) }}" required>
                                        </div>
                                        @error('slug') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-bold text-dark">Full Content <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="12" required>{{ old('content', $blog->content) }}</textarea>
                                        @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card border-0 bg-light p-4 rounded-4 mb-4">
                                    <label class="form-label fw-bold text-dark">Change Image(s)</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image[]" accept="image/*" multiple onchange="previewImages(event)">
                                    
                                    <div id="previewContainer" class="mt-3 d-flex flex-wrap gap-2">
                                        @php
                                            $images = [];
                                            if ($blog->image) {
                                                $images = is_array($blog->image) ? $blog->image : json_decode($blog->image, true);
                                                if (!$images) $images = [$blog->image];
                                            }
                                        @endphp
                                        @foreach($images as $img)
                                            <div class="position-relative" id="old-img-{{ $loop->index }}">
                                                <img src="{{ asset('storage/' . $img) }}" class="rounded border shadow-sm" style="width: 80px; height: 80px; object-fit: cover;">
                                                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 22px; height: 22px; transform: translate(30%, -30%);" onclick="removeOldImage('{{ $img }}', 'old-img-{{ $loop->index }}')">
                                                    <i class="fa-solid fa-xmark" style="font-size: 0.7rem;"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div id="deletedImagesContainer"></div>
                                    @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>

                                <div class="card border-0 p-4 rounded-4 bg-primary-subtle border border-primary-subtle">
                                    <h6 class="fw-bold text-primary mb-3"><i class="fa-brands fa-instagram me-2"></i> Instagram Automation</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" role="switch" id="post_to_ig" name="post_to_ig" value="1" {{ old('post_to_ig') ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="post_to_ig">Auto-post to IG</label>
                                    </div>
                                    <label class="form-label fw-bold text-dark small">IG Caption / Excerpt</label>
                                    <textarea class="form-control" name="excerpt" rows="4">{{ old('excerpt', $blog->excerpt) }}</textarea>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="{{ route('cms.blogs.index') }}" class="btn btn-light rounded-pill px-4 fw-bold">Cancel</a>
                                    <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow">
                                        <i class="fa-solid fa-save me-2"></i> Update Article
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
<script src="{{ asset('assets/js/pages/cms-blogs-edit.js') }}"></script>
@endpush
