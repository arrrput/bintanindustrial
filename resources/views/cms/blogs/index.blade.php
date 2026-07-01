@extends('layouts.main') 

@section('title', 'Manage Blog Articles - BIIE CMS')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/pages/cms-blogs-index.css') }}">
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
        <li class="current">Blogs</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-4 py-md-5 mt-2">
    
    <!-- Section Settings Form -->
    <div class="card border-0 shadow-sm rounded-4 mb-5">
        <div class="card-body p-4">
            <h4 class="fw-bold text-dark mb-4">
                <i class="fa-solid fa-gear text-success me-2"></i> Section Settings
            </h4>
            <form action="{{ route('cms.section-settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="section_key" value="blog">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Custom Section Title</label>
                        <input type="text" name="title" class="form-control rounded-pill" value="{{ $setting->title ?? 'News & Media' }}" placeholder="Enter custom title">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Add Background Images (Can select multiple)</label>
                        <input type="file" name="background_images[]" class="form-control rounded-pill" multiple>
                    </div>
                    
                    @if($setting && $setting->background_images && count($setting->background_images) > 0)
                    <div class="col-12 mt-3">
                        <label class="form-label small fw-bold">Current Background Images (Click icon to remove)</label>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach($setting->background_images as $img)
                            <div class="position-relative border rounded p-1 shadow-sm" style="width: 120px;">
                                <img src="{{ asset('storage/' . $img) }}" class="rounded w-100" style="height: 80px; object-fit: cover;">
                                <div class="position-absolute top-0 end-0 p-1">
                                    <input type="checkbox" name="remove_images[]" value="{{ $img }}" id="del_bg_{{ $loop->index }}" class="d-none">
                                    <label for="del_bg_{{ $loop->index }}" class="btn btn-danger btn-sm rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 25px; height: 25px; cursor: pointer;" onclick="this.parentElement.parentElement.style.opacity='0.3'; this.innerHTML='<i class=\'fa-solid fa-undo\'></i>';">
                                        <i class="fa-solid fa-xmark" style="font-size: 0.7rem;"></i>
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="col-12 mt-4 text-end">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                            <i class="fa-solid fa-save me-2"></i> Update Settings
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h2 class="fw-bold text-dark mb-0 fs-3">
                <i class="fa-solid fa-newspaper text-primary me-2"></i> Blog Articles
            </h2>
            <p class="text-muted small mb-0 mt-1">Create, edit, and manage news and articles.</p>
        </div>
        <div>
            <a href="{{ route('cms.blogs.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">
                <i class="fa-solid fa-plus me-2"></i> Write Article
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive"> 
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted" style="font-size: 0.85rem; letter-spacing: 1px;">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase" style="width: 100px;">Cover</th>
                            <th class="py-3 text-uppercase">Title & Date</th>
                            <th class="py-3 text-uppercase d-none d-md-table-cell">Excerpt</th>
                            <th class="pe-4 py-3 text-uppercase text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($blogs as $blog)
                        <tr>
                            <td class="ps-4 py-3">
                                @php
                                    $images = is_array($blog->image) ? $blog->image : json_decode($blog->image, true);
                                    $cover = $images ? $images[0] : $blog->image;
                                @endphp
                                @if($cover)
                                    <img src="{{ asset('storage/' . $cover) }}" class="rounded-3 shadow-sm" style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted" style="width: 60px; height: 60px;">
                                        <i class="fa-solid fa-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="py-3">
                                <h6 class="mb-1 fw-bold text-dark">{{ $blog->title }}</h6>
                                <span class="text-muted small"><i class="fa-solid fa-calendar-days me-1"></i> {{ $blog->created_at->format('M d, Y') }}</span>
                            </td>
                            <td class="py-3 d-none d-md-table-cell text-muted small">
                                {{ Str::limit($blog->excerpt, 80) }}
                            </td>
                            <td class="pe-4 py-3 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('cms.blogs.edit', $blog->id) }}" class="btn btn-sm btn-light text-primary rounded-circle shadow-sm">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('cms.blogs.destroy', $blog->id) }}" method="POST" onsubmit="return confirm('Delete this article?');">
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
                            <td colspan="4" class="text-center py-5 text-muted">No articles found.</td>
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
<script src="{{ asset('assets/js/pages/cms-blogs-index.js') }}"></script>
@endpush
