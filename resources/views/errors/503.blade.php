@extends('errors.page')

@section('code', 'Under Maintenance')
@section('title', 'We’ll be back soon')
@section('message', 'Our website is undergoing scheduled maintenance to serve you better. Please check back in a few minutes — this page will refresh automatically.')
@section('refresh', '60')

@section('icon')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a4 4 0 0 0-5.4 5.4L3 18l3 3 6.3-6.3a4 4 0 0 0 5.4-5.4l-2.6 2.6-2.4-.6-.6-2.4z"/></svg>
@endsection

@section('actions')
<button type="button" class="btn btn-primary" onclick="location.reload()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-2.64-6.36"/><path d="M21 3v6h-6"/></svg> Try Again</button>
@endsection

@section('extra')
Thank you for your patience.
@endsection
