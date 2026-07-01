@extends('layouts.main')

@section('title', 'Edit User - BIIE CMS')

@section('content')
<div class="page-title" data-aos="fade">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <nav class="breadcrumbs">
      <ol>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ route('cms.dashboard') }}">CMS</a></li>
        <li><a href="{{ route('cms.users.index') }}">Users</a></li>
        <li class="current">Edit User</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-5 mt-2">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-primary py-3 border-0">
                    <h5 class="mb-0 text-white fw-bold"><i class="fa-solid fa-user-pen me-2"></i> Edit User: {{ $user->name }}</h5>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('cms.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control rounded-pill @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" placeholder="Enter full name" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control rounded-pill @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" placeholder="Enter email address" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="card border-0 bg-light rounded-4 p-4 mb-4">
                            <h6 class="fw-bold text-muted mb-3"><i class="fa-solid fa-lock me-2"></i> Change Password (Optional)</h6>
                            <p class="small text-muted mb-3">Leave blank if you don't want to change the password.</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">New Password</label>
                                    <input type="password" class="form-control rounded-pill @error('password') is-invalid @enderror" name="password" placeholder="Enter new password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">Confirm New Password</label>
                                    <input type="password" class="form-control rounded-pill" name="password_confirmation" placeholder="Repeat new password">
                                </div>
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-bold text-dark d-block">Assign Role <span class="text-danger">*</span></label>
                            <div class="d-flex flex-wrap gap-4 mt-2">
                                @foreach($roles as $role)
                                <div class="form-check custom-radio">
                                    <input class="form-check-input" type="radio" name="role" value="{{ $role->name }}" id="role_{{ $role->id }}" 
                                        {{ (old('role') == $role->name) || $user->hasRole($role->name) ? 'checked' : '' }} required>
                                    <label class="form-check-label fw-semibold" for="role_{{ $role->id }}">
                                        {{ $role->name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            @error('role')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center border-top pt-4">
                            <a href="{{ route('cms.users.index') }}" class="btn btn-light rounded-pill px-4 fw-bold">
                                <i class="fa-solid fa-arrow-left me-2"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                                <i class="fa-solid fa-save me-2"></i> Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
