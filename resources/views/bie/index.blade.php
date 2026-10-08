@extends('layouts.main')

@section('title', 'BIE - Bintan Industrial Estate')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/puu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/bie-unified.css') }}">
@endpush

@section('content')
    @include('partials.page-title', ['current' => 'BIE'])

    @include('bie.sections.intro')
    @include('bie.sections.bintan')
    @include('bie.sections.service-suite')
    @include('bie.sections.facilities')
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/pages/bie-unified.js') }}"></script>
@endpush
