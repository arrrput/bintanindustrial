@extends('layouts.main')

@section('title', 'OSS - Bintan Industrial Estate')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/puu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/program-2.css') }}">
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
@endsection
