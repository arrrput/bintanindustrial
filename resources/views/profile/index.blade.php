@extends('layouts.main')

@section('title', 'Profile - Bintan Industrial Estate')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/puu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/bie-unified.css') }}">
@endpush

@section('content')
    @include('partials.page-title', ['current' => 'Profile'])

    @include('profile.sections.bintan')
    @include('profile.sections.industrial-solutions')
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/pages/bie-unified.js') }}"></script>
@endpush
