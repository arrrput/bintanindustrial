@extends('layouts.main')

@section('title', 'Home - Bintan Industrial Estate')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/index.css') }}?v={{ filemtime(public_path('assets/css/pages/index.css')) }}">
@endpush

@section('content')
    @include('home.sections.hero')
    @include('home.sections.industrial-estate')
    @include('home.sections.global-partnership')

    {{-- Hidden for now — uncomment to show again --}}
    {{-- @include('home.sections.news') --}}
    {{-- @include('home.sections.contact') --}}
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/Draggable.min.js"></script>
    <script src="{{ asset('assets/js/pages/index.js') }}?v={{ filemtime(public_path('assets/js/pages/index.js')) }}"></script>
@endpush
