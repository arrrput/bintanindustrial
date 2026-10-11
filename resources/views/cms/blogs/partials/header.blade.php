{{-- Manage Blog header + tab menu shared by Articles (blogs) and Programs. Pass $active: articles | programs --}}
@once
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/pages/cms-admin.css') }}">
    @endpush
@endonce

<div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
    <div>
        <h2 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-newspaper text-primary me-2"></i> Manage Blog
        </h2>
        <p class="text-muted mb-0">Manage the articles and the "Beyond The Workplace" programs shown on the public <strong>Blog</strong> page.</p>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('cms.dashboard') }}" class="btn btn-secondary rounded-pill px-4 fw-bold">
            <i class="fa-solid fa-arrow-left me-2"></i> Back
        </a>
        <a href="{{ route('news.index') }}" target="_blank" class="btn btn-outline-primary rounded-pill px-4 fw-bold">
            <i class="fa-solid fa-arrow-up-right-from-square me-2"></i> View Live Page
        </a>
    </div>
</div>

<nav class="admin-nav mb-5" aria-label="Manage Blog sections">
    @can('blog.manage')
        <a href="{{ route('cms.blogs.index') }}" class="admin-nav-link {{ $active === 'articles' ? 'active' : '' }}" @if($active === 'articles') aria-current="page" @endif>
            <i class="fa-solid fa-newspaper me-2"></i>Articles
        </a>
    @endcan
    @can('programs.manage')
        <a href="{{ route('cms.programs.index') }}" class="admin-nav-link {{ $active === 'programs' ? 'active' : '' }}" @if($active === 'programs') aria-current="page" @endif>
            <i class="fa-solid fa-calendar-days me-2"></i>Programs
        </a>
    @endcan
</nav>
