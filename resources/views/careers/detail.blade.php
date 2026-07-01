@extends('layouts.main')

@section('title', 'Job Detail - ' . $career->title)

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/pages/careers-detail.css') }}">
<style>
    .job-detail-header {
        padding: 120px 0 80px 0;
        @if($career->media)
            background: linear-gradient(rgba(38, 87, 65, 0.8), rgba(25, 135, 84, 0.9)), url('{{ asset("storage/" . $career->media) }}') no-repeat center center;
        @else
            background: linear-gradient(rgba(38, 87, 65, 0.8), rgba(25, 135, 84, 0.9)), url('{{ asset("assets/img/Bintan/bie.jpg") }}') no-repeat center center;
        @endif
        background-size: cover;
        position: relative;
    }
</style>
@endpush

@section('content')
  @if(session('success'))
      <div id="appliedSuccessToast" class="custom-success-toast show">
          <i class="fa-solid fa-circle-check fs-5"></i> {{ session('success') }}
      </div>
  @endif

  <div id="outdatedToast" class="custom-outdated-toast">
      <i class="fa-solid fa-circle-exclamation fs-5"></i> Outdated! This vacancy has been closed.
  </div>

  <div class="page-title" data-aos="fade">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <nav class="breadcrumbs">
        <ol>
          <li><a href="{{ url('/') }}">Home</a></li>
          <li><a href="{{ url('/careers') }}">Careers</a></li>
          <li class="current">Job Details</li>
        </ol>
      </nav>
    </div>
  </div>

  <section class="job-detail-header" style="{{ $career->is_closed ? 'filter: grayscale(0.2);' : '' }}">
      <div class="container" data-aos="fade-up">
          <div class="row">
              <div class="col-lg-8">
                  @if($career->is_closed)
                      <span class="badge bg-danger mb-3 px-3 py-2 rounded-pill fs-6 shadow-sm"><i class="fa-solid fa-lock me-2"></i>CLOSED</span>
                  @else
                      <span class="badge bg-success mb-3 px-3 py-2 rounded-pill fs-6 shadow-sm"><i class="fa-solid fa-door-open me-2"></i>WE ARE HIRING</span>
                  @endif
                  
                  <h1 class="fw-bold mb-2 text-white" style="text-shadow: 2px 2px 10px rgba(0,0,0,0.5);">{{ $career->title }}</h1>
                  
                  <h5 class="fw-light text-white"><i class="fa-solid fa-building me-2"></i>Bintan Industrial Estate</h5>
              </div>
          </div>
      </div>
  </section>

  <section class="section page-content bg-light pb-5">
      <div class="container">
          <div class="row g-5">
              
              <div class="col-lg-8 job-description-content" data-aos="fade-right" data-aos-delay="100">
                  <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border border-light">
                      
                      <h4>Job Description</h4>
                      {!! $career->description !!}
                      
                      <h4 class="mt-4">Requirements</h4>
                      {!! $career->requirements !!}

                      <div class="alert-custom mt-5">
                          <h5 class="fw-bold text-danger"><i class="fa-solid fa-triangle-exclamation me-2"></i> ATTENTION</h5>
                          <p class="mb-2 text-dark">We will review further and for those who meet the qualification will be contacted to attend the recruitment process.</p>
                          <p class="mb-0 text-dark fw-bold">Bintan Industrial Estate (BIIE) does not collect any fees from Applicants in the recruitment process.</p>
                      </div>

                  </div>
              </div>

              <div class="col-lg-4" data-aos="fade-left" data-aos-delay="200">
                  <div class="job-card-summary">
                      <h5 class="fw-bold mb-4 border-bottom pb-3">Job Summary</h5>
                      
                      <ul class="list-unstyled mb-4">
                          <li class="d-flex mb-3 align-items-center">
                              <div class="bg-light rounded p-2 text-center me-3" style="width: 45px;"><i class="fa-solid fa-signal text-primary fs-5"></i></div>
                              <div>
                                  <p class="mb-0 text-muted small">Job Status</p>
                                  <h6 class="mb-0 fw-bold {{ $career->is_closed ? 'text-danger' : 'text-success' }}">
                                      {{ $career->is_closed ? 'CLOSED' : 'OPEN' }}
                                  </h6>
                              </div>
                          </li>
                          <li class="d-flex mb-3 align-items-center">
                              <div class="bg-light rounded p-2 text-center me-3" style="width: 45px;"><i class="fa-solid fa-location-dot text-primary fs-5"></i></div>
                              <div>
                                  <p class="mb-0 text-muted small">Location</p>
                                  <h6 class="mb-0 fw-bold text-dark">{{ $career->location }}</h6>
                              </div>
                          </li>
                          <li class="d-flex mb-3 align-items-center">
                              <div class="bg-light rounded p-2 text-center me-3" style="width: 45px;"><i class="fa-solid fa-user-tie text-primary fs-5"></i></div>
                              <div>
                                  <p class="mb-0 text-muted small">Level</p>
                                  <h6 class="mb-0 fw-bold text-dark">{{ $career->level }}</h6>
                              </div>
                          </li>
                          <li class="d-flex mb-3 align-items-center">
                              <div class="bg-light rounded p-2 text-center me-3" style="width: 45px;"><i class="fa-solid fa-graduation-cap text-primary fs-5"></i></div>
                              <div>
                                  <p class="mb-0 text-muted small">Minimum Education</p>
                                  <h6 class="mb-0 fw-bold text-dark">{{ $career->min_education }}</h6>
                              </div>
                          </li>
                          <li class="d-flex mb-3 align-items-center">
                              <div class="bg-light rounded p-2 text-center me-3" style="width: 45px;"><i class="fa-solid fa-briefcase text-primary fs-5"></i></div>
                              <div>
                                  <p class="mb-0 text-muted small">Minimum Experience</p>
                                  <h6 class="mb-0 fw-bold text-dark">{{ $career->min_experience }}</h6>
                              </div>
                          </li>
                          <li class="d-flex align-items-center mb-3">
                              <div class="bg-light rounded p-2 text-center me-3" style="width: 45px;"><i class="fa-solid fa-calendar-plus text-primary fs-5"></i></div>
                              <div>
                                  <p class="mb-0 text-muted small">Posted On</p>
                                  <h6 class="mb-0 fw-bold text-dark">{{ \Carbon\Carbon::parse($career->posted_date)->format('d M Y') }}</h6>
                              </div>
                          </li>
                          <li class="d-flex align-items-center">
                              <div class="bg-danger-subtle rounded p-2 text-center me-3" style="width: 45px;"><i class="fa-solid fa-calendar-xmark text-danger fs-5"></i></div>
                              <div>
                                <p class="mb-0 text-danger small fw-bold">Closing Date</p>
                                <h6 class="mb-0 fw-bold text-danger">{{ \Carbon\Carbon::parse($career->closing_date)->format('d M Y') }}</h6>
                            </div>
                        </li>
                      </ul>

                      <div class="d-grid mt-4">
                          @if($career->is_closed)
                              <button type="button" id="btnApplyClosed" class="btn btn-secondary btn-lg fw-bold rounded-pill shadow-sm">
                                 <i class="fa-solid fa-lock me-2"></i> Apply Closed
                              </button>
                          @else
                              <a href="{{ route('careers.apply.email', $career->slug) }}" class="btn btn-apply-animated btn-lg fw-bold rounded-pill text-center">
                                 <i class="fa-solid fa-paper-plane me-2"></i> Apply for this position
                              </a>
                          @endif
                      </div>
                  </div>
              </div>

          </div>
      </div>
  </section>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/pages/careers-detail.js') }}"></script>
@endpush