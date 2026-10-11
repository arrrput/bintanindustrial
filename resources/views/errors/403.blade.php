@extends('errors.page')

@section('code', 'Error 403')
@section('title', 'Access denied')
@section('message', 'You do not have permission to open this page. If you believe you should, please ask an administrator to update your role.')

@section('icon')
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
@endsection

@section('actions')
<a href="{{ url('/') }}" class="btn btn-primary"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 10.5 12 3l9 7.5"/><path d="M5 9.5V21h14V9.5"/></svg> Back to Home</a>
<button type="button" class="btn btn-outline" onclick="history.length > 1 ? history.back() : (location.href = '{{ url('/') }}')"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><path d="m12 19-7-7 7-7"/></svg> Go Back</button>
@endsection

