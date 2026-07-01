@extends('layouts.main')

@section('title', 'Verify Email - Apply for ' . $career->title)

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/pages/careers-apply-step1-email.css') }}">
@endpush

@section('content')
<div class="apply-header">
    <div class="container" data-aos="fade-up">
        <h2 class="fw-bold mb-2">You don't Need to Login</h2>
        <p class="mb-0 text-white-50">Applying for: <span class="text-white fw-bold">{{ $career->title }}</span></p>
    </div>
</div>

<div class="container mb-5 pb-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card form-card" data-aos="fade-up" data-aos-delay="100">
                <div class="card-body p-4 p-md-5 text-center">
                    
                    <div class="mb-4">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="fa-solid fa-envelope-circle-check text-success fs-2"></i>
                        </div>
                        <h4 class="fw-bold text-dark">Verify Your Email</h4>
                        <p class="text-muted small">We will send a One-Time Password (OTP) to your email address to verify your identity before proceeding to the application form.</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger rounded-4 mb-4 text-start">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger rounded-4 mb-4 text-start">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('careers.apply.send-otp', $career->slug) }}" method="POST">
                        @csrf
                        <div class="mb-4 text-start">
                            <label class="form-label fw-bold text-dark">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control form-control-lg rounded-pill px-4 @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="name@domain.com" required>
                        </div>

                        <div class="d-grid gap-3">
                            <button type="submit" class="btn btn-apply-submit border-0">Send Verification Code</button>
                            <a href="{{ route('careers.detail', $career->slug) }}" class="text-muted text-decoration-none small fw-bold">Cancel and go back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
