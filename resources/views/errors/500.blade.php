@extends('errors.page')

@section('code', 'Error 500')
@section('title', 'Something went wrong')
@section('message', 'We hit an unexpected problem on our side. Our team has been notified — please try again in a few minutes.')

@section('icon')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
@endsection

@section('actions')
<button type="button" class="btn btn-primary" onclick="location.reload()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-2.64-6.36"/><path d="M21 3v6h-6"/></svg> Try Again</button>
<a href="{{ url('/') }}" class="btn btn-primary"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 10.5 12 3l9 7.5"/><path d="M5 9.5V21h14V9.5"/></svg> Back to Home</a>
@endsection

@section('extra')
If the problem persists, please <a href="{{ url('/') }}#contact">contact us</a>.
@endsection
