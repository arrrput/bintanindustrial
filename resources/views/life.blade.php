@extends('layouts.main')

@section('title', 'Life - Bintan Industrial Estate')

@push('styles')
    <link href="{{ asset('assets/css/puu.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/life.css') }}">

    <style>
        .life-parallax-divider {
            background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.5)), url('{{ asset('assets/img/Bintan/condo.jpg') }}');
        }
    </style>
@endpush

@section('content')
  <div class="page-title" data-aos="fade">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <nav class="breadcrumbs">
        <ol>
          <li><a href="{{ url('/') }}">Home</a></li>
          <li class="current">Life</li>
        </ol>
      </nav>
    </div>
  </div>

  <link rel="stylesheet" href="{{ asset('assets/css/pages/life-2.css') }}">

  <section class="life-header">
    <div class="life-bg-container" id="lifeBgSlideshow">
      @if($setting && $setting->background_images && count($setting->background_images) > 0)
        @foreach($setting->background_images as $index => $img)
          <div class="life-bg-layer {{ $index === 0 ? 'active' : '' }}" style="background-image: url('{{ asset('storage/' . $img) }}');"></div>
        @endforeach
      @else
        <div class="life-bg-layer active" style="background-image: url('{{ asset('assets/img/Bintan/villa.webp') }}');"></div>
      @endif
    </div>
    <div class="life-bg-overlay"></div>
    <div class="container position-relative" style="z-index: 3;" data-aos="fade-up">
      <h2 class="section-title-custom text-white fw-bold mx-auto">{{ $setting->title ?? 'Life at BIE' }}</h2>
    </div>
  </section>

  @if($setting && $setting->background_images && count($setting->background_images) > 1)
  <script src="{{ asset('assets/js/pages/life.js') }}"></script>
  @endif

  <section class="page-content section pb-0">
    <div class="container">
      
      @forelse($workLife as $index => $item)
      <div class="row align-items-center mb-5" data-aos="{{ $index % 2 == 0 ? 'fade-right' : 'fade-left' }}" data-aos-duration="1000">
        <div class="col-lg-6 {{ $index % 2 != 0 ? 'order-lg-2' : '' }}">
          <div class="position-relative">
            @if($item->image)
              <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid rounded shadow-lg" alt="{{ $item->title }}">
            @else
              <img src="{{ asset('assets/img/Bintan/image8.jpeg') }}" class="img-fluid rounded shadow-lg" alt="Life at Work">
            @endif
            <div class="position-absolute top-0 start-0 translate-middle z-n1 d-none d-lg-block">
               <i class="fa-solid fa-leaf text-primary" style="font-size: 6rem; opacity: 0.08;"></i>
            </div>
          </div>
        </div>
        <div class="col-lg-6 {{ $index % 2 != 0 ? 'order-lg-1 pe-lg-5' : 'ps-lg-5' }} mt-4 mt-lg-0">
          <h2 class="text-primary fw-bold mb-3">{{ $item->title }}</h2>
          @if($item->subtitle)
            <p class="lead text-muted fst-italic border-start border-3 border-success ps-3 mb-4">{{ $item->subtitle }}</p>
          @endif
          <div class="description-content">
            {!! nl2br(e($item->description)) !!}
          </div>
        </div>
      </div>
      @empty
        <!-- Fallback jika data kosong -->
        <div class="row align-items-center mb-5" data-aos="fade-right" data-aos-duration="1000">
            <div class="col-lg-6">
            <div class="position-relative">
                <img src="{{ asset('assets/img/Bintan/image8.jpeg') }}" class="img-fluid rounded shadow-lg" alt="Life at Work">
                <div class="position-absolute top-0 start-0 translate-middle z-n1 d-none d-lg-block">
                <i class="fa-solid fa-leaf text-primary" style="font-size: 6rem; opacity: 0.08;"></i>
                </div>
            </div>
            </div>
            <div class="col-lg-6 ps-lg-5 mt-4 mt-lg-0">
            <h2 class="text-primary fw-bold mb-3">LIFE AT WORK</h2>
            <p class="lead text-muted fst-italic border-start border-3 border-success ps-3 mb-4">"A lush, tranquil environment with all modern conveniences."</p>
            <p>As a self-contained development, Bintan Industrial Estate offers full lifestyle facilities from accommodation and amenities to recreational and leisure options. Much thought has been put into ensuring that its tenants enjoy all the modern conveniences while living in a lush, tranquil environment.</p>
            <p>Within Bintan Industrial Estate is the <strong>Bintan Inti Executive Village</strong>, an exclusive enclave for tenants. Housing options include well-appointed bungalows, studio apartments and modern condominiums, all of which come with full clubhouse facilities, tennis courts and golfing facilities. There are also generous worker dormitories and a bustling town centre with dining options, retail shops, housing, banking facilities and more, located within its premises.</p>
            </div>
        </div>
      @endforelse

    </div>
  </section>

  <section class="life-parallax-divider">
    <i class="fa-solid fa-water floating-ornament text-white" style="font-size: 10rem; top: -5%; left: 5%;"></i>
    <i class="fa-solid fa-spa floating-ornament text-white" style="font-size: 8rem; bottom: -5%; right: 8%; animation-delay: 2s;"></i>
    
    <div class="container life-parallax-content" data-aos="zoom-in" data-aos-duration="1200">
      <h3>Experience The Balance</h3>
      <p>“Where demanding professional goals meet absolute tranquility. Elevate your lifestyle in a complete, self-sustained ecosystem designed exclusively for excellence and comfort.”</p>
    </div>
  </section>

  <section class="page-content section pt-0">
    <div class="container">
      
      @forelse($relaxationLife as $index => $item)
      <div class="row align-items-center mt-5 pt-4" data-aos="{{ $index % 2 == 0 ? 'fade-left' : 'fade-right' }}" data-aos-duration="1000">
        <div class="col-lg-6 {{ $index % 2 == 0 ? 'order-lg-2' : '' }}">
          <div class="position-relative">
            @if($item->image)
              <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid rounded shadow-lg" alt="{{ $item->title }}">
            @else
              <img src="{{ asset('assets/img/Bintan/image9.jpeg') }}" class="img-fluid rounded shadow-lg" alt="Resort-Style Relaxation">
            @endif
            <div class="position-absolute bottom-0 {{ $index % 2 == 0 ? 'end-0' : 'start-0' }} translate-middle-y z-n1 d-none d-lg-block" style="{{ $index % 2 == 0 ? 'margin-right: -40px;' : 'margin-left: -40px;' }}">
               <i class="fa-solid fa-umbrella-beach text-primary" style="font-size: 6rem; opacity: 0.08;"></i>
            </div>
          </div>
        </div>
        <div class="col-lg-6 {{ $index % 2 == 0 ? 'order-lg-1 pe-lg-5' : 'ps-lg-5' }} mt-4 mt-lg-0">
          <h3 class="fw-bold mb-3">{{ $item->title }}</h3>
          @if($item->subtitle)
            <p class="lead text-muted fst-italic border-start border-3 border-success ps-3 mb-4">{{ $item->subtitle }}</p>
          @endif
          <div class="description-content mb-4">
            {!! nl2br(e($item->description)) !!}
          </div>
          
          @if($loop->first)
          <div class="mt-4">
            <a href="https://www.bintan-resorts.com" target="_blank" class="btn btn-outline-success fw-bold rounded-pill px-4 py-2 shadow-sm" style="transition: 0.3s; border-color: var(--accent-color); color: var(--accent-color);">
                Explore Bintan Resorts <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i>
            </a>
          </div>
          @endif
        </div>
      </div>
      @empty
        <!-- Fallback jika data kosong -->
        <div class="row align-items-center mt-5 pt-4" data-aos="fade-left" data-aos-duration="1000">
            <div class="col-lg-6 order-lg-2">
            <div class="position-relative">
                <img src="{{ asset('assets/img/Bintan/image9.jpeg') }}" class="img-fluid rounded shadow-lg" alt="Resort-Style Relaxation">
                <div class="position-absolute bottom-0 end-0 translate-middle-y z-n1 d-none d-lg-block" style="margin-right: -40px;">
                <i class="fa-solid fa-umbrella-beach text-primary" style="font-size: 6rem; opacity: 0.08;"></i>
                </div>
            </div>
            </div>
            <div class="col-lg-6 order-lg-1 pe-lg-5 mt-4 mt-lg-0">
            <h3 class="fw-bold mb-3">Resort-Style <span class="text-primary">RELAXATION</span></h3>
            <p>The sun, sand and sea beckon at Bintan International Resorts, an award-winning integrated tropical beach resort destination. Situated on the northern coast of the island, the destination is home to a collection of beautiful beach resorts, designer golf courses and a multitude of recreational facilities and leisure attractions.</p>
            <p>From sunbathing on endless stretches of white, sandy beaches to exhilarating water sports and everything in between, time away from work at Bintan Industrial Estate is best spent in the relaxing embrace of the resorts.</p>
            
            <a href="https://www.bintan-resorts.com" target="_blank" class="btn btn-outline-success mt-4 fw-bold rounded-pill px-4 py-2 shadow-sm" style="transition: 0.3s; border-color: var(--accent-color); color: var(--accent-color);">
                Explore Bintan Resorts <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i>
            </a>
            </div>
        </div>
      @endforelse

    </div>
  </section>
@endsection