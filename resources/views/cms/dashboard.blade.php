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
        @role('BDD|CRS|IT')
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
            <a href="{{ route('cms.home.index') }}" class="card bg-white p-4 cms-card h-100">
                <div class="cms-icon-wrapper bg-primary-subtle text-primary">
                    <i class="fa-solid fa-house-chimney-window"></i>
                </div>
                <h4 class="fw-bold text-dark mb-2">Manage Home</h4>
                <p class="text-muted small mb-0">Manage home page components including testimonials, client feedback, and tenant logos.</p>
                
                <div class="mt-4 d-flex align-items-center text-primary fw-bold text-uppercase small" style="letter-spacing: 1px;">
                    Open Module <i class="fa-solid fa-arrow-right ms-2"></i>
                </div>
            </a>
        </div>
        @endrole

        <!-- 2. Manage BIE Page (unified) -->
        @role('BDD|CRS|IT')
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
            <a href="{{ route('cms.bie-page.index') }}" class="card bg-white p-4 cms-card h-100">
                <div class="cms-icon-wrapper bg-success-subtle text-success">
                    <i class="fa-solid fa-building-columns"></i>
                </div>
                <h4 class="fw-bold text-dark mb-2">Manage BIE Page</h4>
                <p class="text-muted small mb-0">Manage all content of the BIE page — industrial estate sections, facilities & infrastructure, and Bintan Island slides.</p>

                <div class="mt-4 d-flex align-items-center text-success fw-bold text-uppercase small" style="letter-spacing: 1px;">
                    Open Module <i class="fa-solid fa-arrow-right ms-2"></i>
                </div>
            </a>
        </div>
        @endrole

        <!-- 3. Manage Life -->
        @role('BDD|CRS|IT')
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
            <a href="{{ route('cms.lives.index') }}" class="card bg-white p-4 cms-card h-100">
                <div class="cms-icon-wrapper bg-danger-subtle text-danger">
                    <i class="fa-solid fa-heart"></i>
                </div>
                <h4 class="fw-bold text-dark mb-2">Manage Life</h4>
                <p class="text-muted small mb-0">Manage "Life at BIE" content, including work-life balance and resort facilities.</p>

                <div class="mt-4 d-flex align-items-center text-danger fw-bold text-uppercase small" style="letter-spacing: 1px;">
                    Open Module <i class="fa-solid fa-arrow-right ms-2"></i>
                </div>
            </a>
        </div>
        @endrole

        <!-- 4. Manage Careers -->
        @role('HRGA|IT')
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="400">
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
        @endrole

        <!-- 5. Manage Blogs -->
        @role('BDD|CRS|IT')
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="500">
            <a href="{{ route('cms.blogs.index') }}" class="card bg-white p-4 cms-card h-100">
                <div class="cms-icon-wrapper bg-primary-subtle text-primary">
                    <i class="fa-solid fa-newspaper"></i>
                </div>
                <h4 class="fw-bold text-dark mb-2">Manage Blogs</h4>
                <p class="text-muted small mb-0">Write company news, press releases, and articles about Bintan Industrial Estate.</p>
                
                <div class="mt-4 d-flex align-items-center text-primary fw-bold text-uppercase small" style="letter-spacing: 1px;">
                    Open Module <i class="fa-solid fa-arrow-right ms-2"></i>
                </div>
            </a>
        </div>
        @endrole

    </div>
</div>
@endsection