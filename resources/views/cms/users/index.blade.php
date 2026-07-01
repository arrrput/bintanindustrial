@extends('layouts.main') 

@section('title', 'Manage Users - BIIE CMS')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/pages/cms-users-index.css') }}">
@endpush

@section('content')

  @if(session('success'))
      <div id="adminSuccessToast" class="custom-success-toast">
          <i class="fa-solid fa-circle-check fs-5"></i> {{ session('success') }}
      </div>
  @endif

  @if(session('error'))
      <div id="adminErrorToast" class="custom-error-toast">
          <i class="fa-solid fa-circle-xmark fs-5"></i> {{ session('error') }}
      </div>
  @endif

<div class="page-title" data-aos="fade">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <nav class="breadcrumbs">
      <ol>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ route('cms.dashboard') }}">CMS</a></li>
        <li class="current">Users</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-4 py-md-5 mt-2">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0 fs-3">
                <i class="fa-solid fa-users text-success me-2"></i> User Management
            </h2>
            <p class="text-muted small mb-0 mt-1">Manage system administrators and their roles.</p>
        </div>
        <div>
            <a href="{{ route('cms.users.create') }}" class="btn btn-success rounded-pill px-4 shadow-sm fw-bold">
                <i class="fa-solid fa-plus me-2"></i> Add User
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive"> 
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted" style="font-size: 0.85rem; letter-spacing: 1px;">
                        <tr>
                            <th class="ps-4 py-3">NAME</th>
                            <th class="py-3">EMAIL</th>
                            <th class="py-3">ROLES</th>
                            <th class="py-3 text-center">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-3" style="width: 40px; height: 40px; background: var(--accent-color); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div class="fw-bold text-dark">{{ $user->name }}</div>
                                </div>
                            </td>
                            <td class="py-3 text-muted">{{ $user->email }}</td>
                            <td class="py-3">
                                @foreach($user->roles as $role)
                                    <span class="badge bg-light text-success border border-success-subtle rounded-pill px-3 py-2 small fw-bold">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="py-3 text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('cms.users.edit', $user->id) }}" class="btn btn-outline-primary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;" data-bs-toggle="tooltip" title="Edit User">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    
                                    @if(auth()->id() !== $user->id)
                                    <form action="{{ route('cms.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;" data-bs-toggle="tooltip" title="Delete User">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('assets/js/pages/cms-users-index.js') }}"></script>
@endpush
