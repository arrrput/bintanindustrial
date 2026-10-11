@extends('layouts.main')

@section('title', 'Users - Admin Panel - BIIE CMS')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/pages/cms-admin.css') }}">
@endpush

@section('content')

<div class="page-title" data-aos="fade">
  <div class="container d-lg-flex justify-content-between align-items-center">
    <nav class="breadcrumbs">
      <ol>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ route('cms.dashboard') }}">CMS</a></li>
        <li><a href="{{ route('cms.admin.index') }}">Admin Panel</a></li>
        <li class="current">Users</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-4 py-md-5 mt-2">

    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="fa-solid fa-users text-success me-2"></i> User Management
            </h2>
            <p class="text-muted mb-0">Manage who can sign in to the CMS and which role they have.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('cms.admin.index') }}" class="btn btn-secondary rounded-pill px-4 fw-bold">
                <i class="fa-solid fa-arrow-left me-2"></i> Back
            </a>
            <a href="{{ route('cms.users.create') }}" class="btn btn-success rounded-pill px-4 shadow-sm fw-bold">
                <i class="fa-solid fa-plus me-2"></i> Add User
            </a>
        </div>
    </div>

    @include('cms.admin.partials.nav', ['active' => 'users'])

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted" style="font-size: 0.85rem; letter-spacing: 1px;">
                        <tr>
                            <th class="ps-4 py-3">NAME</th>
                            <th class="py-3">EMAIL</th>
                            <th class="py-3">ROLE</th>
                            <th class="py-3 text-center">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="admin-avatar me-3">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $user->name }}</div>
                                        @if(auth()->id() === $user->id)
                                            <span class="badge bg-success-subtle text-success rounded-pill">You</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 text-muted">{{ $user->email }}</td>
                            <td class="py-3">
                                @forelse($user->roles as $role)
                                    <span class="badge rounded-pill px-3 py-2 small fw-bold {{ $role->name === \App\Support\CmsPermissions::SUPER_ADMIN_ROLE ? 'bg-dark text-white' : 'bg-light text-success border border-success-subtle' }}">
                                        {{ $role->name }}
                                    </span>
                                @empty
                                    <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-3 py-2 small fw-bold" title="Users without a role cannot sign in to the CMS">
                                        <i class="fa-solid fa-triangle-exclamation me-1"></i> No role
                                    </span>
                                @endforelse
                            </td>
                            <td class="py-3 text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('cms.users.edit', $user->id) }}" class="btn btn-outline-primary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;" data-bs-toggle="tooltip" title="Edit User">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    @if(auth()->id() !== $user->id)
                                    <form action="{{ route('cms.users.destroy', $user->id) }}" method="POST" class="d-inline" data-confirm="Are you sure you want to delete this user?">
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
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">No users yet.</td>
                        </tr>
                        @endforelse
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
