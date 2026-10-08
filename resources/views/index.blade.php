@extends('layouts.main')

@section('title', 'Home - Bintan Industrial Estate')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/index.css') }}">
@endpush

@section('content')
    @include('home.sections.hero')
    @include('home.sections.industrial-solutions')
    @include('home.sections.global-partnership')
    @include('home.sections.infrastructure')
    @include('home.sections.news')
    @include('home.sections.contact')
@endsection
