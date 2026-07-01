@extends('layouts.main')

@section('title', 'Admin Login - BIIE')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/pages/auth-login.css') }}">
@endpush

@section('content')
<div class="login-wrapper mt-2">
    
    <i class="fa-solid fa-building floating-ornament ornament-1"></i>
    <i class="fa-solid fa-ship floating-ornament ornament-2"></i>
    <i class="fa-solid fa-leaf floating-ornament ornament-3"></i>
    <i class="fa-solid fa-gears floating-ornament ornament-4"></i>

    <div class="container position-relative">
        <div class="row justify-content-center">
            <div class="col-11 col-sm-8 col-md-6 col-lg-4" data-aos="zoom-in" data-aos-duration="600">
                
                <div class="card login-card border-0 shadow-lg rounded-4">
                    <div class="card-header bg-success p-4 text-center border-0" style="border-radius: 1rem 1rem 0 0;">
                        <h4 class="fw-bold text-white mb-0"><i class="fa-solid fa-user-shield me-2"></i> BIIE CMS</h4>
                        <p class="text-white-50 small mb-0 mt-1" style="letter-spacing: 1px;">Authorized Personnel</p>
                    </div>
                    
                    <div class="card-body p-4">
                        
                        @if($errors->any())
                            <div class="alert alert-danger rounded-3 small fw-bold">
                                <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ $errors->first() }}
                            </div>
                        @endif

                        <form action="{{ route('login.post') }}" method="POST">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="email" name="email" class="form-control rounded-3 border-light shadow-sm" id="email" placeholder="name@example.com" required value="{{ old('email') }}">
                                <label for="email" class="text-muted"><i class="fa-solid fa-envelope me-2"></i> Email address</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" name="password" class="form-control rounded-3 border-light shadow-sm" id="password" placeholder="Password" required>
                                <label for="password" class="text-muted"><i class="fa-solid fa-key me-2"></i> Password</label>
                            </div>
                            <button type="submit" class="btn btn-success w-100 py-2 rounded-pill fw-bold shadow-sm d-flex justify-content-center align-items-center gap-2">
                                Login to Dashboard <i class="fa-solid fa-arrow-right-to-bracket"></i>
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection