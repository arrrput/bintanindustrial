@extends('layouts.main')

@section('title', 'Careers - Bintan Industrial Estate')

@push('styles')
    <link href="{{ asset('assets/css/puu.css') }}" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('assets/css/pages/careers.css') }}">
@endpush

@section('content')
  <div class="page-title" data-aos="fade">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <nav class="breadcrumbs">
        <ol>
          <li><a href="{{ url('/') }}">Home</a></li>
          <li class="current">Careers</li>
        </ol>
      </nav>
    </div>
  </div>

  <link rel="stylesheet" href="{{ asset('assets/css/pages/careers-2.css') }}">

  <section class="career-header">
    <div class="career-bg-container" id="careerBgSlideshow">
      @if($setting && $setting->background_images && count($setting->background_images) > 0)
        @foreach($setting->background_images as $index => $img)
          <div class="career-bg-layer {{ $index === 0 ? 'active' : '' }}" style="background-image: url('{{ asset('storage/' . $img) }}');"></div>
        @endforeach
      @else
        <div class="career-bg-layer active" style="background-image: url('{{ asset('assets/img/Bintan/Villa3.jpg') }}');"></div>
      @endif
    </div>
    <div class="career-bg-overlay"></div>
    <div class="container position-relative text-center" style="z-index: 3;" data-aos="zoom-in" data-aos-duration="1000">
      <h2 class="section-title-custom text-white fw-bold mx-auto">{{ $setting->title ?? 'Join Our Team' }}</h2>
    </div>
  </section>

  @if($setting && $setting->background_images && count($setting->background_images) > 1)
  <script src="{{ asset('assets/js/pages/careers.js') }}"></script>
  @endif

  <section class="page-content section">
    
    <i class="fa-solid fa-briefcase careers-bg-ornament" style="font-size: 15rem; top: 8%; right: -2%;"></i>
    <i class="fa-solid fa-graduation-cap careers-bg-ornament" style="font-size: 13rem; top: 45%; left: -3%; animation-delay: 3s;"></i>
    <i class="fa-solid fa-award careers-bg-ornament" style="font-size: 14rem; bottom: 12%; right: -1%; animation-delay: 6s;"></i>

    <div class="container position-relative" style="z-index: 1;">
      
      <div class="row align-items-center mb-5 pb-4" data-aos="fade-up" data-aos-duration="1000">
        <div class="col-lg-8 mx-auto text-center">
          <span class="badge bg-success-subtle text-success mb-2 px-3 py-2 rounded-pill fw-bold" style="background: rgba(51,86,66,0.1);">Grow With Us</span>
          <p class="lead text-muted">KERJA KERJA KERJA !!!.</p>
        </div>
      </div>
      <div class="row g-4 mt-2">
        
        @forelse($careers as $job)
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="800">
          <div class="value-card h-100 d-flex flex-column" style="{{ $job->status == 'closed' ? 'opacity: 0.85;' : '' }}">
            <div class="d-flex justify-content-between align-items-start mb-3">
              <div class="value-icon-wrapper mb-0" style="{{ $job->status == 'closed' ? 'background: rgba(220, 53, 69, 0.1); color: #dc3545;' : '' }}">
                 <i class="fa-solid {{ $job->status == 'closed' ? 'fa-shield-halved' : 'fa-briefcase' }}" style="font-size: 1.5rem;"></i>
              </div>
              <div class="text-end">
                  @if(!$job->is_closed)
                      <span class="badge bg-success text-white px-3 py-1 rounded-pill mb-1 shadow-sm">OPEN</span><br>
                  @else
                      <span class="badge bg-danger text-white px-3 py-1 rounded-pill mb-1 shadow-sm">CLOSED</span><br>
                  @endif
                  <span class="badge bg-secondary-subtle text-secondary px-3 py-1 rounded-pill">{{ $job->level }}</span>
              </div>
            </div>
            
            <h5 class="fw-bold text-dark mb-2">{{ $job->title }}</h5>
            <p class="small text-muted mb-3"><i class="fa-solid fa-location-dot me-2 {{ $job->is_closed ? 'text-danger' : 'text-primary' }}"></i>{{ $job->location }}</p>
            
            <div class="bg-light p-3 rounded mb-4 flex-grow-1 border">
                <ul class="list-unstyled small text-muted mb-0">
                  <li class="mb-2"><i class="fa-solid fa-graduation-cap me-2 {{ !$job->is_closed ? 'text-primary' : 'text-danger' }}"></i> <strong>Education:</strong> {{ $job->min_education }}</li>
                  <li class="mb-2"><i class="fa-solid fa-briefcase me-2 {{ !$job->is_closed ? 'text-primary' : 'text-danger' }}"></i> <strong>Experience:</strong> {{ $job->min_experience }}</li>
                  
                  <li class="mb-2"><i class="fa-solid fa-calendar-plus me-2 {{ !$job->is_closed ? 'text-primary' : 'text-danger' }}"></i> <strong>Posted:</strong> {{ \Carbon\Carbon::parse($job->posted_date)->format('d M Y') }}</li>
                  <li><i class="fa-solid fa-calendar-xmark me-2 text-danger"></i> <strong>Deadline:</strong> <span class="text-danger fw-bold">{{ \Carbon\Carbon::parse($job->closing_date)->format('d M Y') }}</span></li>
                </ul>
            </div>

            <a href="{{ route('careers.detail', $job->slug) }}" class="btn {{ $job->is_closed ? 'btn-outline-danger' : 'btn-outline-success' }} btn-sm w-100 fw-bold rounded-pill py-2" style="{{ !$job->is_closed ? 'border-color: var(--accent-color); color: var(--accent-color); transition: 0.3s;' : 'transition: 0.3s;' }}" onmouseover="{{ !$job->is_closed ? 'this.style.backgroundColor=\'var(--accent-color)\'; this.style.color=\'#fff\';' : '' }}" onmouseout="{{ !$job->is_closed ? 'this.style.backgroundColor=\'transparent\'; this.style.color=\'var(--accent-color)\';' : '' }}">
                View Details {{ $job->is_closed ? '(Closed)' : '& Apply' }}
            </a>
          </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="fa-solid fa-folder-open fs-1 text-muted mb-3"></i>
            <h5 class="text-muted">Belum ada lowongan pekerjaan saat ini.</h5>
        </div>
        @endforelse

      </div>

    </div>
  </section>
@endsection