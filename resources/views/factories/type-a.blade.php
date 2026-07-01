@extends('layouts.main')

@section('title', 'Factory Type A - Bintan Industrial Estate')

@section('content')

  <div class="page-title" data-aos="fade">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">Factory Specifications</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="{{ url('/') }}">Home</a></li>
          <li><a href="{{ url('/#factype') }}">Factory Types</a></li>
          <li class="current">Type A</li>
        </ol>
      </nav>
    </div>
  </div><section id="factory-details" class="portfolio-details section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row gy-4">

        <div class="col-lg-8">
          <div class="main-image mb-4">
            <img src="{{ asset('assets/img/Factory/Type A-Single Storey Terrace.webp') }}" class="img-fluid rounded shadow" alt="Type A Factory">
          </div>

          <div class="floor-plans">
            <h4 class="mb-3">Detailed Drawings</h4>
            <div class="row gy-3">
              
              <div class="col-md-6">
                <img src="{{ asset('assets/img/Factory/Front-elevation-Type-A.png') }}" class="img-fluid rounded border" alt="Front Elevation">
                <p class="text-muted mt-2">Front Elevation</p>
              </div>
              
              <div class="col-md-6">
                <img src="{{ asset('assets/img/Factory/Side-Elevation-Type-A.png') }}" class="img-fluid rounded border" alt="Side Elevation">
                <p class="text-muted mt-2">Side Elevation</p>
              </div>

              <div class="col-md-6">
                <img src="{{ asset('assets/img/Factory/Ground-Floor-Plan-Type-A.png') }}" class="img-fluid rounded border" alt="Ground Floor Plan">
                <p class="text-muted mt-2">Ground Floor Plan</p>
              </div>
              
              <div class="col-md-6">
                <img src="{{ asset('assets/img/Factory/Rare-Elevation Type-A.png') }}" class="img-fluid rounded border" alt="Rear Elevation">
                <p class="text-muted mt-2">Rear Elevation</p>
              </div>
              

            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="portfolio-info" data-aos="fade-up" data-aos-delay="200">
            <h3>Type A - Single Storey Terrace</h3>
            <ul>
              <li><strong>Main Building Size:</strong> 18m x 28m (504m²)</li>
              <li><strong>Built-in Area:</strong> 18m x 28m (504m²)</li>
              <li><strong>Building Height:</strong> 3.5m</li>
              <li><strong>Floor Loading:</strong> 7.5 kN/m²</li>
            </ul>
          </div>

          <div class="portfolio-description mt-4" data-aos="fade-up" data-aos-delay="300">
            <h2>Detailed Specifications</h2>
            <ul class="list-unstyled">
              <li class="mb-2"><strong>Structure:</strong> Reinforced concrete structure designed to British and Singapore standards.</li>
              <li class="mb-2"><strong>Doors:</strong> Timber doors and manually operated roller shutters.</li>
              <li class="mb-2"><strong>Windows:</strong> Timber frame and adjustable louvre windows.</li>
              <li class="mb-2"><strong>Walls:</strong> Block wall painted on both faces, plastered on external face.</li>
              <li class="mb-2"><strong>Roof:</strong> Metal deck roofing with insulation and wind turbine ventilator.</li>
              <li class="mb-2"><strong>Floor Finishes:</strong> Power-floated finish on factory floor. Tiles on toilet floor only.</li>
              <li class="mb-2"><strong>Water Supply:</strong> Potable water is supplied from BIE distribution network.</li>
              <li class="mb-2"><strong>Electricity Supply:</strong> AC From BIE Powerhouse (3-phase 380V, frequency: 50Hz, capacity up to 100kVA).</li>
              <li class="mb-2"><strong>Fire Protection:</strong> Fire hydrant and hosereel.</li>
              <li class="mb-2"><strong>Telecommunication:</strong> IDD, fax, data, leased lines and broadband.</li>
              <li class="mb-2"><strong>Sewerage:</strong> Septic tank is provided for sewage discharge.</li>
              <li class="mb-2"><strong>Others:</strong> Trailer and car parks provided.</li>
            </ul>
          </div>
        </div>

      </div>
    </div>
  </section>

@endsection