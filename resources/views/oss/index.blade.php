@extends('layouts.main')

@section('title', 'OSS - Bintan Industrial Estate')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/puu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/program.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/program-2.css') }}">
    <style>
        .program-parallax-divider {
            background-image: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.5)), url('{{ asset('assets/img/Bintan/condo.jpg') }}');
        }
    </style>
@endpush

@section('content')
    @include('partials.page-title', ['current' => 'OSS'])

    {{-- Hidden for now — uncomment to show again
    @include('partials.page-header', [
        'prefix' => 'program',
        'slideshowId' => 'programBgSlideshow',
        'setting' => $setting,
        'fallbackImage' => 'assets/img/Bintan/villa.webp',
        'fallbackTitle' => 'Programs at BIE',
        'script' => 'assets/js/pages/program.js',
        'aos' => 'data-aos="fade-up"',
    ])
    --}}

    @include('oss.sections.service-suite')
    @include('oss.sections.facilities')
    @include('oss.sections.infrastructure')

    {{-- Hidden for now — uncomment to show again
    @include('oss.sections.events')

    <section class="program-parallax-divider">
        <div class="container program-parallax-content" data-aos="zoom-in" data-aos-duration="1200">
            <h3>Beyond The Workplace</h3>
            <p>"Where meaningful celebrations, leisure and community care come together. A complete, self-sustained ecosystem designed to enrich the lives of everyone within Bintan Industrial Estate."</p>
        </div>
    </section>

    @include('oss.sections.entertainment')
    @include('oss.sections.csr')
    --}}
@endsection
