@extends('errors.page')

@section('code', 'Error 419')
@section('title', 'Page expired')
@section('message', 'Your session has expired for security reasons. Please go back, refresh the page and try again.')

@section('icon')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
@endsection

@section('actions')
<button type="button" class="btn btn-outline" onclick="history.length > 1 ? history.back() : (location.href = '{{ url('/') }}')"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><path d="m12 19-7-7 7-7"/></svg> Go Back</button>
<a href="{{ url('/') }}" class="btn btn-primary"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 10.5 12 3l9 7.5"/><path d="M5 9.5V21h14V9.5"/></svg> Back to Home</a>
@endsection

