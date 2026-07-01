@extends('layouts.main')

@section('title', 'Custom Build Factory - Bintan Industrial Estate')

@section('content')

  <div class="page-title" data-aos="fade">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">Factory Specifications</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="{{ url('/') }}">Home</a></li>
          <li><a href="{{ url('/#factype') }}">Factory Types</a></li>
          <li class="current">Custom Build</li>
        </ol>
      </nav>
    </div>
  </div><section id="factory-details" class="portfolio-details section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row gy-4">

        <div class="col-lg-8">
          <div class="portfolio-details-slider swiper init-swiper">
            <div class="swiper-wrapper align-items-center">
              <div class="swiper-slide">
                <img src="{{ asset('assets/img/Factory/Custom Build.jpg') }}" class="img-fluid rounded" alt="Custom Build Factory">
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="portfolio-info" data-aos="fade-up" data-aos-delay="200">
            <h3>Factory Building Info</h3>
            <ul>
              <li><strong>Building Type</strong>: Custom Build</li>
              <li><strong>Design</strong>: Base On Requirements</li>
              <li><strong>Structure</strong>: Tailor-made Factory</li>
              <li><strong>Availability</strong>: Contact Us for Details</li>
            </ul>
          </div>
          <div class="portfolio-description" data-aos="fade-up" data-aos-delay="300">
            <h2>Layanan Custom Build</h2>
            <p>
              Fasilitas *Custom Build* kami tawarkan bagi Anda yang memiliki kebutuhan standar industri khusus. Kami akan bekerjasama merancang dan membangun pabrik dari nol yang 100% disesuaikan (*Tailor-made*) dengan dimensi, kebutuhan alat berat, hingga standar utilitas dari perusahaan Anda.
            </p>
          </div>
        </div>

      </div>
    </div>
  </section>

@endsection