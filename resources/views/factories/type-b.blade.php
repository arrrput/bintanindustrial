@extends('layouts.main')

@section('title', 'Factory Type B - Bintan Industrial Estate')

@section('content')

  <div class="page-title" data-aos="fade">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">Factory Specifications</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="{{ url('/') }}">Home</a></li>
          <li><a href="{{ url('/#factype') }}">Factory Types</a></li>
          <li class="current">Type B</li>
        </ol>
      </nav>
    </div>
  </div>

  <section id="factory-details" class="portfolio-details section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row gy-4">
        <div class="col-lg-8">
          <div class="main-image mb-4">
            <img src="{{ asset('assets/img/Factory/Tipe B-Detached-Single-Storey-with-Mezzanine-Floor-copy.webp') }}" class="img-fluid rounded shadow" alt="Type B Factory">
          </div>
          <div class="floor-plans">
            <h4 class="mb-3">Detailed Drawings</h4>
            <div class="row gy-3">
              <div class="col-md-6"><img src="{{ asset('assets/img/Factory/Type-B-2nd-Storey-Plan.png') }}" class="img-fluid rounded border" alt="2nd Storey Plan"><p class="text-muted mt-2">2nd Storey Plan</p></div>
              <div class="col-md-6"><img src="{{ asset('assets/img/Factory/Type-B-Front-Elevation.png') }}" class="img-fluid rounded border" alt="Front Elevation"><p class="text-muted mt-2">Front Elevation</p></div>
              <div class="col-md-6"><img src="{{ asset('assets/img/Factory/Type-B-Ground-Floor-Plan.png') }}" class="img-fluid rounded border" alt="Ground Floor Plan"><p class="text-muted mt-2">Ground Floor Plan</p></div>
              <div class="col-md-6"><img src="{{ asset('assets/img/Factory/Type-B-Side-Elevation.png') }}" class="img-fluid rounded border" alt="Side Elevation"><p class="text-muted mt-2">Side Elevation</p></div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="portfolio-info" data-aos="fade-up" data-aos-delay="200">
            <h3>Type B - Detached Single Storey</h3>
            <ul>
              <li><strong>Land Plot Area:</strong> 45m x 100m (4,500m²)</li>
              <li><strong>Main Building Size:</strong> 25m x 72m (1,800m²)</li>
              <li><strong>Lettable Area:</strong> Ground (1,800m²) + Mezzanine (300m²) = 2,100m²</li>
              <li><strong>Building Height:</strong> 3.8m (Ground to Mezzanine), 4.7m (Mezzanine to Ridge)</li>
            </ul>
          </div>
          <div class="portfolio-description mt-4" data-aos="fade-up" data-aos-delay="300">
            <h2>Detailed Specifications</h2>
            <ul class="list-unstyled">
              <li><strong>Floor Loading:</strong> 7.5 or 15 kN/m² (Ground), 2.5 kN/m² (Mezzanine)</li>
              <li><strong>Structure:</strong> Steel and concrete structure.</li>
              <li><strong>Doors/Windows:</strong> Timber/Aluminium doors, Aluminium frame sliding windows.</li>
              <li><strong>Walls/Roof:</strong> Block wall plastered/painted, Metal deck roofing with insulation.</li>
              <li><strong>Electricity:</strong> 3-phase 380V, 50Hz, up to 500kVA.</li>
              <li><strong>Others:</strong> Guard house, car parks, driveway, perimeter fencing.</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection