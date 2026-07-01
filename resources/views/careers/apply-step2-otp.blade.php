@extends('layouts.main')

@section('title', 'Enter OTP - Apply for ' . $career->title)

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/pages/careers-apply-step2-otp.css') }}">
@endpush

@section('content')
<div class="apply-header">
    <div class="container" data-aos="fade-up">
        <h2 class="fw-bold mb-2">Step 2: Enter OTP</h2>
        <p class="mb-0 text-white-50">Applying for: <span class="text-white fw-bold">{{ $career->title }}</span></p>
    </div>
</div>

<div class="container mb-5 pb-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card form-card" data-aos="fade-up" data-aos-delay="100">
                <div class="card-body p-4 p-md-5 text-center">
                    
                    <div class="mb-4">
                        <div class="bg-success-subtle rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="fa-solid fa-shield-halved text-success fs-2"></i>
                        </div>
                        <h4 class="fw-bold text-dark">Enter Verification Code</h4>
                        <p class="text-muted small">We've sent a 6-character code to <strong>{{ session('apply_email') }}</strong>. Please enter it below to proceed.</p>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success rounded-4 mb-4 text-start">
                            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger rounded-4 mb-4 text-start">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('careers.apply.verify', $career->slug) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <input type="text" name="otp" class="form-control form-control-lg rounded-pill px-4 otp-input @error('otp') is-invalid @enderror" maxlength="6" placeholder="XXXXXX" required autocomplete="off">
                        </div>

                        <div class="d-grid gap-3">
                            <button type="submit" class="btn btn-apply-submit border-0">Verify & Continue</button>
                        </div>
                    </form>

                    <div class="mt-4 border-top pt-3">
                        <p class="small text-muted mb-2">Didn't receive the code?</p>
                        <form action="{{ route('careers.apply.send-otp', $career->slug) }}" method="POST">
                            @csrf
                            <input type="hidden" name="email" value="{{ session('apply_email') }}">
                            <button type="submit" class="btn btn-link text-success p-0 fw-bold text-decoration-none">Resend Code</button>
                        </form>
                        <div class="mt-3">
                            <a href="{{ route('careers.apply.email', $career->slug) }}" class="text-muted text-decoration-none small">Change Email Address</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
