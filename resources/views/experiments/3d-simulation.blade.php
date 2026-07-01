@extends('layouts.main')

@section('title', '3D Factory Simulation - Bintan Industrial Estate')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/experiments-3d-simulation.css') }}">
@endpush

@section('content')

    <!-- EXACT FACTYPE SECTION FROM HOME -->
    <section id="factype" class="featured-services section" style="padding-top: 100px;">
      <div class="ornament-wrapper">
        <i class="fa-solid fa-city floating-ornament" style="top: 20%; left: 3%; animation-duration: 25s;"></i>
        <i class="fa-solid fa-gears floating-ornament" style="top: 5%; left: 80%; animation-duration: 20s; animation-delay: -2s;"></i>
      </div>
      <div class="container section-title" data-aos="fade-up">
        <h2>Industrial Solutions</h2>
        <p>Explore Our <span>Factory Types</span></p>
        <small class="text-muted d-block mt-2">Click anywhere on a card to view its 3D model. Click the title to see details.</small>
      </div>

      <div class="container">
        
        <!-- THE 400px 3D CANVAS (Directly Above Cards) -->
        <div class="canvas-container" id="main-canvas" data-aos="zoom-in">
            <div id="loading-overlay">
                <h4 class="mb-0">Loading 3D Models...</h4>
                <div class="progress-bar-bg"><div id="progress-fill"></div></div>
            </div>
        </div>

        <div class="row gy-4">
          
          <!-- TYPE A -->
          <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item image-bg-card position-relative w-100 shadow active-card" id="card-A" onclick="switchModel('A', event)" style="cursor: pointer; background-image: url('{{ asset("assets/img/Factory/Type A-Single Storey Terrace.webp") }}'); background-size: cover; background-position: center;">
              <div class="content w-100">
                <h4 class="mb-1"><a href="{{ url('/factory/type-a') }}" class="stretched-link text-white">TYPE A</a></h4>
                <p class="small mb-0 opacity-75 text-white">Single Storey Terrace</p>
              </div>
            </div>
          </div>
          
          <!-- TYPE B -->
          <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200">
            <div class="service-item image-bg-card position-relative w-100 shadow" id="card-B" onclick="switchModel('B', event)" style="cursor: pointer; background-image: url('{{ asset('assets/img/Factory/Tipe B-Detached-Single-Storey-with-Mezzanine-Floor-copy.webp') }}'); background-size: cover; background-position: center;">
              <div class="content w-100">
                <h4 class="mb-1"><a href="{{ url('/factory/type-b') }}" class="stretched-link text-white">TYPE B</a></h4>
                <p class="small mb-0 opacity-75 text-white">Detached Single Storey</p>
              </div>
            </div>
          </div>
          
          <!-- TYPE C -->
          <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
            <div class="service-item image-bg-card position-relative w-100 shadow" id="card-C" onclick="switchModel('C', event)" style="cursor: pointer; background-image: url('{{ asset('assets/img/Factory/Tipe C-Single-Storey-Semi-Detached-copy.webp') }}'); background-size: cover; background-position: center;">
              <div class="content w-100">
                <h4 class="mb-1"><a href="{{ url('/factory/type-c') }}" class="stretched-link text-white">TYPE C</a></h4>
                <p class="small mb-0 opacity-75 text-white">Semi-Detached Factory</p>
              </div>
            </div>
          </div>
          
          <!-- CUSTOM BUILD -->
          <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="400">
            <div class="service-item image-bg-card position-relative w-100 shadow" style="background-image: url('{{ asset('assets/img/Factory/Custom Build.jpg') }}'); background-size: cover; background-position: center;">
              <div class="content w-100">
                <h4 class="mb-1"><a href="{{ url('/factory/custom-details') }}" class="stretched-link text-white">Custom Build</a></h4>
                <p class="small mb-0 opacity-75 text-white">Tailored to Your Needs</p>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- Scripts -->
    <script src="https://unpkg.com/three@0.128.0/build/three.min.js"></script>
    <script src="https://unpkg.com/three@0.128.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://unpkg.com/three@0.128.0/examples/js/loaders/RGBELoader.js"></script>
    <script src="https://unpkg.com/three@0.128.0/examples/js/controls/OrbitControls.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <script>
        window.__factoryAssetBase = "{{ asset('assets/img/3d_Factory') }}";
    </script>
    <script src="{{ asset('assets/js/pages/experiments-3d-simulation.js') }}"></script>
@endsection
