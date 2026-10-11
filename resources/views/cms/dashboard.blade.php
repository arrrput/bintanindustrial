@extends('layouts.main') 

@section('title', 'CMS Dashboard - Bintan Industrial Estate')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/pages/cms-dashboard.css') }}">
@endpush

@section('content')
<div class="page-title" data-aos="fade">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <nav class="breadcrumbs">
      <ol>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li class="current">CMS</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-5 mt-2">
    <div class="row mb-5">
        <div class="col-lg-8">
            <h2 class="fw-bold text-dark mb-2">
                <i class="fa-solid fa-gauge-high text-success me-2"></i> Content Management
            </h2>
            <p class="text-muted">Welcome to the BIIE Control Panel. Please select the module you want to manage.</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- 1. Manage Home -->
        @can('home.manage')
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
            <a href="{{ route('cms.home.index') }}" class="card bg-white p-4 cms-card h-100">
                <div class="cms-icon-wrapper bg-primary-subtle text-primary">
                    <i class="fa-solid fa-house-chimney-window"></i>
                </div>
                <h4 class="fw-bold text-dark mb-2">Manage Home</h4>
                <p class="text-muted small mb-0">Manage Home page content — Our Industrial Estate sections, client testimonials, and tenant logos.</p>
                
                <div class="mt-4 d-flex align-items-center text-primary fw-bold text-uppercase small" style="letter-spacing: 1px;">
                    Open Module <i class="fa-solid fa-arrow-right ms-2"></i>
                </div>
            </a>
        </div>
        @endcan

        <!-- 2. Manage Profiles -->
        @can('profiles.manage')
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
            <a href="{{ route('cms.profiles.index') }}" class="card bg-white p-4 cms-card h-100">
                <div class="cms-icon-wrapper bg-success-subtle text-success">
                    <i class="fa-solid fa-building-columns"></i>
                </div>
                <h4 class="fw-bold text-dark mb-2">Manage Profiles</h4>
                <p class="text-muted small mb-0">Manage the Bintan Island slider and Business Opportunity on the Profile page.</p>

                <div class="mt-4 d-flex align-items-center text-success fw-bold text-uppercase small" style="letter-spacing: 1px;">
                    Open Module <i class="fa-solid fa-arrow-right ms-2"></i>
                </div>
            </a>
        </div>
        @endcan

        <!-- 3. Manage OSS -->
        @can('oss.manage')
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
            <a href="{{ route('cms.oss.index') }}" class="card bg-white p-4 cms-card h-100">
                <div class="cms-icon-wrapper bg-info-subtle text-info">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                </div>
                <h4 class="fw-bold text-dark mb-2">Manage OSS</h4>
                <p class="text-muted small mb-0">Manage the One Stop Service Suite and Facilities on the OSS page.</p>

                <div class="mt-4 d-flex align-items-center text-info fw-bold text-uppercase small" style="letter-spacing: 1px;">
                    Open Module <i class="fa-solid fa-arrow-right ms-2"></i>
                </div>
            </a>
        </div>
        @endcan

        <!-- 4. Manage Blog (articles + Beyond The Workplace programs) -->
        @canany(['blog.manage', 'programs.manage'])
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="400">
            <a href="{{ auth()->user()->can('blog.manage') ? route('cms.blogs.index') : route('cms.programs.index') }}" class="card bg-white p-4 cms-card h-100">
                <div class="cms-icon-wrapper bg-primary-subtle text-primary">
                    <i class="fa-solid fa-newspaper"></i>
                </div>
                <h4 class="fw-bold text-dark mb-2">Manage Blog</h4>
                <p class="text-muted small mb-0">Write articles and press releases, and manage the Event, Entertainment &amp; CSR programs of "Beyond The Workplace".</p>

                <div class="mt-4 d-flex align-items-center text-primary fw-bold text-uppercase small" style="letter-spacing: 1px;">
                    Open Module <i class="fa-solid fa-arrow-right ms-2"></i>
                </div>
            </a>
        </div>
        @endcanany

        <!-- 5. Manage Careers -->
        @can('careers.manage')
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="500">
            <a href="{{ route('cms.careers.index') }}" class="card bg-white p-4 cms-card h-100">
                <div class="cms-icon-wrapper bg-success-subtle text-success">
                    <i class="fa-solid fa-briefcase"></i>
                </div>
                <h4 class="fw-bold text-dark mb-2">Manage Careers</h4>
                <p class="text-muted small mb-0">Publish new job vacancies, update requirements, and manage recruitment statuses.</p>

                <div class="mt-4 d-flex align-items-center text-success fw-bold text-uppercase small" style="letter-spacing: 1px;">
                    Open Module <i class="fa-solid fa-arrow-right ms-2"></i>
                </div>
            </a>
        </div>
        @endcan

        <!-- 6. Admin Panel -->
        @canany(['users.manage', 'roles.manage'])
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="600">
            <a href="{{ route('cms.admin.index') }}" class="card bg-white p-4 cms-card h-100">
                <div class="cms-icon-wrapper bg-dark-subtle text-dark">
                    <i class="fa-solid fa-user-gear"></i>
                </div>
                <h4 class="fw-bold text-dark mb-2">Admin Panel</h4>
                <p class="text-muted small mb-0">Manage CMS users, roles, and what each role is allowed to access.</p>

                <div class="mt-4 d-flex align-items-center text-dark fw-bold text-uppercase small" style="letter-spacing: 1px;">
                    Open Module <i class="fa-solid fa-arrow-right ms-2"></i>
                </div>
            </a>
        </div>
        @endcanany

        @if(!auth()->user()->canAny(\App\Support\CmsPermissions::all()))
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-5 text-center text-muted">
                <i class="fa-solid fa-lock fs-1 mb-3"></i>
                <h5 class="fw-bold text-dark">No modules available yet</h5>
                <p class="mb-0">Your role does not have any permissions. Please contact an administrator.</p>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection