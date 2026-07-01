@extends('layouts.main')

@section('title', 'Edit Job - BIIE CMS')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/cms-careers-edit.css') }}">
@endpush

@section('content')
<div id="adminWarningToast" class="custom-warning-toast">
    <i class="fa-solid fa-triangle-exclamation fs-5"></i> <span id="warningMessage">Warning Message</span>
</div>

<div class="page-title" data-aos="fade">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <nav class="breadcrumbs">
      <ol>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ route('cms.dashboard') }}">CMS</a></li>
        <li><a href="{{ route('cms.careers.index') }}">Careers</a></li>
        <li class="current">Edit Job</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-5 mt-2">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-primary py-3 border-0">
                    <h5 class="mb-0 text-white fw-bold"><i class="fa-solid fa-pen-to-square me-2"></i> Edit Job: {{ $career->title }}</h5>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('cms.careers.update', $career) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Job Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="title" id="title" value="{{ $career->title }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Location <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="location" id="location" value="{{ $career->location }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Level <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="level" id="level" value="{{ $career->level }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Min. Education <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="min_education" id="min_education" value="{{ $career->min_education }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Min. Experience <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="min_experience" id="min_experience" value="{{ $career->min_experience }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Closing Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="closing_date" id="closing_date" value="{{ $career->closing_date }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Job Status</label>
                                <select class="form-select" name="status" id="status">
                                    <option value="open" {{ $career->status == 'open' ? 'selected' : '' }}>OPEN</option>
                                    <option value="closed" {{ $career->status == 'closed' ? 'selected' : '' }}>CLOSED</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold text-dark">Job Description <span class="text-danger">*</span></label>
                                <textarea class="form-control summernote-editor" name="description" required>{!! $career->description !!}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold text-dark">Requirements <span class="text-danger">*</span></label>
                                <textarea class="form-control summernote-editor" name="requirements" required>{!! $career->requirements !!}</textarea>
                            </div>

                            <!-- LinkedIn Automation -->
                            <div class="col-12 mt-4">
                                <div class="card border-0 shadow-sm rounded-4 p-4 bg-primary-subtle border border-primary-subtle">
                                    <h5 class="fw-bold text-primary mb-3">
                                        <i class="fa-brands fa-linkedin me-2"></i> LinkedIn Automation
                                        @if($career->linkedin_post_id)
                                            <span class="badge bg-success ms-2" style="font-size: 0.7rem;"><i class="fa-solid fa-check-circle"></i> Already Posted</span>
                                        @endif
                                    </h5>
                                    
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" role="switch" id="post_to_linkedin" name="post_to_linkedin" value="1" 
                                            style="transform: scale(1.3); margin-left: -2.5em; margin-top: 0.1em;" 
                                            onchange="toggleLinkedinCaption(this)" {{ $career->linkedin_post_id ? 'checked' : '' }}>
                                        <label class="form-check-label ms-3 fw-bold" for="post_to_linkedin">
                                            {{ $career->linkedin_post_id ? 'Re-post to LinkedIn' : 'Post to LinkedIn Now' }}
                                        </label>
                                    </div>

                                    <div id="linkedinCaptionContainer" class="mt-3 {{ $career->linkedin_post_id ? '' : 'd-none' }}">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <label class="form-label fw-bold mb-0">LinkedIn Post Caption</label>
                                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="generateCaption()">
                                                <i class="fa-solid fa-magic-wand-sparkles me-1"></i> Generate Template
                                            </button>
                                        </div>
                                        <textarea class="form-control" id="linkedin_caption" name="linkedin_caption" rows="8">{{ old('linkedin_caption', $career->linkedin_caption) }}</textarea>
                                        
                                        <div class="mt-4">
                                            <label class="form-label fw-bold"><i class="fa-solid fa-photo-film me-2"></i> Post Media (Optional)</label>
                                            <input type="file" class="form-control" name="media" accept="image/*,video/*" onchange="previewMedia(event)">
                                            
                                            <div id="mediaPreviewContainer" class="mt-3 p-3 bg-white rounded border {{ $career->media ? '' : 'd-none' }} text-center">
                                                @if($career->media)
                                                    @php
                                                        $mime = \Illuminate\Support\Facades\Storage::disk('public')->mimeType($career->media);
                                                    @endphp
                                                    @if(str_contains($mime, 'image'))
                                                        <img src="{{ asset('storage/' . $career->media) }}" class="img-fluid rounded shadow-sm" style="max-height: 250px;">
                                                    @elseif(str_contains($mime, 'video'))
                                                        <video src="{{ asset('storage/' . $career->media) }}" controls class="img-fluid rounded shadow-sm" style="max-height: 250px;"></video>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-5">
                            <a href="{{ route('cms.careers.index') }}" class="btn btn-light rounded-pill px-4 fw-bold">Cancel</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-5 shadow fw-bold">
                                <i class="fa-solid fa-save me-2"></i> Update Job
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        window.__careersUrl = "{{ url('/careers') }}";
    </script>
    <script src="{{ asset('assets/js/pages/cms-careers-edit.js') }}"></script>
@endpush
