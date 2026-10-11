@extends('errors.page')

@section('code', 'Error 404')
@section('title', 'Page not found')
@section('message', 'The page you are looking for may have been moved, renamed or is no longer available.')

@section('icon')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/><path d="M8.5 11h5"/></svg>
@endsection

@section('actions')
<a href="{{ url('/') }}" class="btn btn-primary"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 10.5 12 3l9 7.5"/><path d="M5 9.5V21h14V9.5"/></svg> Back to Home</a>
<button type="button" class="btn btn-outline" onclick="history.length > 1 ? history.back() : (location.href = '{{ url('/') }}')"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><path d="m12 19-7-7 7-7"/></svg> Go Back</button>
@endsection

@section('extra')
Think this is a mistake? <a href="{{ url('/') }}#contact">Let us know</a>.
@endsection
