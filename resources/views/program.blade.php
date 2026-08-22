@extends('layouts.main')

@section('title', 'Program - Bintan Industrial Estate')

@push('styles')
    <link href="{{ asset('assets/css/puu.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/program.css') }}">

    <style>
        .program-parallax-divider {
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
          <li class="current">Program</li>
        </ol>
      </nav>
    </div>
  </div>

  <link rel="stylesheet" href="{{ asset('assets/css/pages/program-2.css') }}">

  <section class="program-header">
    <div class="program-bg-container" id="programBgSlideshow">
      @if($setting && $setting->background_images && count($setting->background_images) > 0)
        @foreach($setting->background_images as $index => $img)
          <div class="program-bg-layer {{ $index === 0 ? 'active' : '' }}" style="background-image: url('{{ asset('storage/' . $img) }}');"></div>
        @endforeach
      @else
        <div class="program-bg-layer active" style="background-image: url('{{ asset('assets/img/Bintan/villa.webp') }}');"></div>
      @endif
    </div>
    <div class="program-bg-overlay"></div>
    <div class="container position-relative" style="z-index: 3;" data-aos="fade-up">
      <h2 class="section-title-custom text-white fw-bold mx-auto">{{ $setting->title ?? 'Programs at BIE' }}</h2>
    </div>
  </section>

  @if($setting && $setting->background_images && count($setting->background_images) > 1)
  <script src="{{ asset('assets/js/pages/program.js') }}"></script>
  @endif

  <!-- Event -->
  <section class="page-content section pb-0">
    <div class="container">

      @forelse($eventProgram as $index => $item)
      <div class="row align-items-center mb-5" data-aos="{{ $index % 2 == 0 ? 'fade-right' : 'fade-left' }}" data-aos-duration="1000">
        <div class="col-lg-6 {{ $index % 2 != 0 ? 'order-lg-2' : '' }}">
          <div class="position-relative">
            @if($item->image)
              <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid rounded shadow-lg" alt="{{ $item->title }}">
            @else
              <img src="{{ asset('assets/img/Bintan/image8.jpeg') }}" class="img-fluid rounded shadow-lg" alt="Event at BIE">
            @endif
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
                <img src="{{ asset('assets/img/Bintan/image8.jpeg') }}" class="img-fluid rounded shadow-lg" alt="Event at BIE">
            </div>
            </div>
            <div class="col-lg-6 ps-lg-5 mt-4 mt-lg-0">
            <h2 class="text-primary fw-bold mb-3">EVENTS AT BIE</h2>
            <p class="lead text-muted fst-italic border-start border-3 border-success ps-3 mb-4">"Bringing our community of tenants and partners together."</p>
            <p>Each year, Bintan Industrial Estate hosts gatherings and celebrations that bring together tenants, employees and partners across the estate. From cultural festivities to milestone celebrations, these events strengthen the sense of community within our self-contained industrial township.</p>
            <p>These occasions are also an opportunity to recognize the contributions of our tenants and workforce, reinforcing the collaborative spirit that has helped BIE grow into a thriving industrial hub.</p>
            </div>
        </div>
      @endforelse

    </div>
  </section>

  <section class="program-parallax-divider">
    <i class="fa-solid fa-music floating-ornament text-white" style="font-size: 10rem; top: -5%; left: 5%;"></i>
    <i class="fa-solid fa-hands-holding-circle floating-ornament text-white" style="font-size: 8rem; bottom: -5%; right: 8%; animation-delay: 2s;"></i>

    <div class="container program-parallax-content" data-aos="zoom-in" data-aos-duration="1200">
      <h3>Beyond The Workplace</h3>
      <p>"Where meaningful celebrations, leisure and community care come together. A complete, self-sustained ecosystem designed to enrich the lives of everyone within Bintan Industrial Estate."</p>
    </div>
  </section>

  <!-- Entertainment -->
  <section class="page-content section pt-0 pb-0">
    <div class="container">

      @forelse($entertainmentProgram as $index => $item)
      <div class="row align-items-center mt-5 pt-4" data-aos="{{ $index % 2 == 0 ? 'fade-left' : 'fade-right' }}" data-aos-duration="1000">
        <div class="col-lg-6 {{ $index % 2 == 0 ? 'order-lg-2' : '' }}">
          <div class="position-relative">
            @if($item->image)
              <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid rounded shadow-lg" alt="{{ $item->title }}">
            @else
              <img src="{{ asset('assets/img/Bintan/image9.jpeg') }}" class="img-fluid rounded shadow-lg" alt="Resort-Style Entertainment">
            @endif
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
                <img src="{{ asset('assets/img/Bintan/image9.jpeg') }}" class="img-fluid rounded shadow-lg" alt="Resort-Style Entertainment">
            </div>
            </div>
            <div class="col-lg-6 order-lg-1 pe-lg-5 mt-4 mt-lg-0">
            <h3 class="fw-bold mb-3">Resort-Style <span class="text-primary">ENTERTAINMENT</span></h3>
            <p>The sun, sand and sea beckon at Bintan International Resorts, an award-winning integrated tropical beach resort destination. Situated on the northern coast of the island, the destination is home to a collection of beautiful beach resorts, designer golf courses and a multitude of recreational facilities and leisure attractions.</p>
            <p>From sunbathing on endless stretches of white, sandy beaches to exhilarating water sports and everything in between, tenants and employees of Bintan Industrial Estate can unwind in the relaxing embrace of the resorts just minutes away.</p>

            <a href="https://www.bintan-resorts.com" target="_blank" class="btn btn-outline-success mt-4 fw-bold rounded-pill px-4 py-2 shadow-sm" style="transition: 0.3s; border-color: var(--accent-color); color: var(--accent-color);">
                Explore Bintan Resorts <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i>
            </a>
            </div>
        </div>
      @endforelse

    </div>
  </section>

  <!-- CSR -->
  <section class="page-content section pt-0">
    <div class="container">

      @forelse($csrProgram as $index => $item)
      <div class="row align-items-center mt-5 pt-4" data-aos="{{ $index % 2 == 0 ? 'fade-right' : 'fade-left' }}" data-aos-duration="1000">
        <div class="col-lg-6 {{ $index % 2 != 0 ? 'order-lg-2' : '' }}">
          <div class="position-relative">
            @if($item->image)
              <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid rounded shadow-lg" alt="{{ $item->title }}">
            @else
              <img src="{{ asset('assets/img/Bintan/image10.jpeg') }}" class="img-fluid rounded shadow-lg" alt="Corporate Social Responsibility">
            @endif
          </div>
        </div>
        <div class="col-lg-6 {{ $index % 2 != 0 ? 'order-lg-1 pe-lg-5' : 'ps-lg-5' }} mt-4 mt-lg-0">
          <h3 class="fw-bold mb-3">{{ $item->title }}</h3>
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
        <div class="row align-items-center mt-5 pt-4" data-aos="fade-right" data-aos-duration="1000">
            <div class="col-lg-6">
            <div class="position-relative">
                <img src="{{ asset('assets/img/Bintan/image10.jpeg') }}" class="img-fluid rounded shadow-lg" alt="Corporate Social Responsibility">
            </div>
            </div>
            <div class="col-lg-6 ps-lg-5 mt-4 mt-lg-0">
            <h3 class="fw-bold mb-3">Corporate Social <span class="text-primary">RESPONSIBILITY</span></h3>
            <p class="lead text-muted fst-italic border-start border-3 border-success ps-3 mb-4">"Giving back to the community and environment we grow in."</p>
            <p>Bintan Industrial Estate is committed to supporting the local community through education, environmental sustainability and social welfare initiatives. Our CSR programs include scholarship support for local students, environmental conservation efforts and partnerships with nearby villages.</p>
            <p>We believe that sustainable business growth goes hand in hand with the wellbeing of the communities and environment surrounding our estate.</p>
            </div>
        </div>
      @endforelse

    </div>
  </section>
@endsection
