@extends('errors.page')

@section('code', 'Error 429')
@section('title', 'Too many requests')
@section('message', 'You have made too many requests in a short time. Please wait a moment and try again.')

@section('icon')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2h12"/><path d="M6 22h12"/><path d="M6 2c0 6 6 6 6 10S6 16 6 22"/><path d="M18 2c0 6-6 6-6 10s6 4 6 10"/></svg>
@endsection

@section('actions')
<button type="button" class="btn btn-primary" onclick="location.reload()"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-2.64-6.36"/><path d="M21 3v6h-6"/></svg> Try Again</button>
<a href="{{ url('/') }}" class="btn btn-primary"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 10.5 12 3l9 7.5"/><path d="M5 9.5V21h14V9.5"/></svg> Back to Home</a>
@endsection

