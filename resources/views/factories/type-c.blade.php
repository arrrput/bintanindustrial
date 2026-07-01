@extends('layouts.main')

@section('title', 'Factory Type C - Bintan Industrial Estate')

@section('content')

  <div class="page-title" data-aos="fade">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">Factory Specifications</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="{{ url('/') }}">Home</a></li>
          <li><a href="{{ url('/#factype') }}">Factory Types</a></li>
          <li class="current">Type C</li>
        </ol>
      </nav>
    </div>
  </div>

  <section id="factory-details" class="portfolio-details section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row gy-4">
        <div class="col-lg-8">
          <div class="main-image mb-4">
            <img src="{{ asset('assets/img/Factory/Tipe C-Single-Storey-Semi-Detached-copy.webp') }}" class="img-fluid rounded shadow" alt="Type C Factory">
          </div>
            <div class="floor-plans">
              <h4 class="mb-3">Detailed Drawings</h4>
              <div class="row gy-3">
                
                <div class="col-md-6">
                  <div class="row gy-3">
                    <div class="col-12">
                      <img src="{{ asset('assets/img/Factory/Type-C-Front-Elevation.png') }}" class="img-fluid rounded border" alt="Front Elevation">
                      <p class="text-muted mt-2">Front Elevation</p>
                    </div>
                    <div class="col-12">
                      <img src="{{ asset('assets/img/Factory/Type-C-Rare-Elevation.png') }}" class="img-fluid rounded border" alt="Rear Elevation">
                      <p class="text-muted mt-2">Rear Elevation</p>
                    </div>
                    <div class="col-12">
                      <img src="{{ asset('assets/img/Factory/Type-C-Side-Elevation.png') }}" class="img-fluid rounded border" alt="Side Elevation">
                      <p class="text-muted mt-2">Side Elevation</p>
                    </div>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div style="top: 120px; z-index: 990;">
                    <img src="{{ asset('assets/img/Factory/Type-C-Ground-Floor-Plan.png') }}" class="img-fluid rounded border" alt="Ground Floor Plan">
                    <p class="text-muted mt-2">Ground Floor Plan</p>
                  </div>
                </div>

              </div>
            </div>
        </div>

        <div class="col-lg-4">
          <div class="portfolio-info" data-aos="fade-up" data-aos-delay="200">
            <h3>Type C - Single Storey Semi-Detached</h3>
            <ul>
              <li><strong>Land Plot Area:</strong> 37.5m x 69m (2,587m²)</li>
              <li><strong>Main Building Size:</strong> 23m x 48m (1,104m²)</li>
              <li><strong>Building Height:</strong> 4.7m</li>
              <li><strong>Floor Loading:</strong> 7.5 kN/m²</li>
            </ul>
          </div>
          <div class="portfolio-description mt-4" data-aos="fade-up" data-aos-delay="300">
            <h2>Detailed Specifications</h2>
            <ul class="list-unstyled">
              <li><strong>Structure:</strong> Reinforced concrete structure.</li>
              <li><strong>Doors/Windows:</strong> Timber doors, adjustable louvre windows.</li>
              <li><strong>Walls/Roof:</strong> Block wall painted, Metal deck roofing with insulation.</li>
              <li><strong>Electricity:</strong> 3-phase 380V, 50Hz, up to 300kVA.</li>
              <li><strong>Fire Protection:</strong> Fire hydrant and hosereel.</li>
              <li><strong>Others:</strong> Guard house, car parks, driveway, perimeter fencing.</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection