@extends('layouts.main')

@section('title', 'Career - Bintan Industrial Estate')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/puu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/careers.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/careers-2.css') }}">
@endpush

@section('content')
    @include('partials.page-title', ['current' => 'Career'])

    @include('partials.page-header', [
        'prefix' => 'career',
        'slideshowId' => 'careerBgSlideshow',
        'setting' => $setting,
        'fallbackImage' => 'assets/img/Bintan/Villa3.jpg',
        'fallbackTitle' => 'Join Our Team',
        'script' => 'assets/js/pages/careers.js',
        'containerClass' => 'text-center',
    ])

    <section class="page-content section">
        {{-- Decorative background icons --}}
        <i class="fa-solid fa-briefcase careers-bg-ornament" style="font-size: 15rem; top: 8%; right: -2%;"></i>
        <i class="fa-solid fa-graduation-cap careers-bg-ornament" style="font-size: 13rem; top: 45%; left: -3%; animation-delay: 3s;"></i>
        <i class="fa-solid fa-award careers-bg-ornament" style="font-size: 14rem; bottom: 12%; right: -1%; animation-delay: 6s;"></i>

        <div class="container position-relative" style="z-index: 1;">
            <div class="row align-items-center mb-5 pb-4" data-aos="fade-up" data-aos-duration="1000">
                <div class="col-lg-8 mx-auto text-center">
                    <span class="badge bg-success-subtle text-success mb-2 px-3 py-2 rounded-pill fw-bold"
                        style="background: rgba(51,86,66,0.1);">Grow With Us</span>
                    <p class="lead text-muted">KERJA KERJA KERJA !!!.</p>
                </div>
            </div>

            <div class="row g-4 mt-2">
                @forelse ($careers as $job)
                    @include('career.partials.job-card', ['job' => $job])
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
