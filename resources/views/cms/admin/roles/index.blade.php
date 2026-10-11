@extends('layouts.main')

@section('title', 'Roles - Admin Panel - BIIE CMS')

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
        <li class="current">Roles</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-4 py-md-5 mt-2">

    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="fa-solid fa-user-shield text-primary me-2"></i> Roles
            </h2>
            <p class="text-muted mb-0">A role is a group of permissions. Each user gets one role.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('cms.admin.index') }}" class="btn btn-secondary rounded-pill px-4 fw-bold">
                <i class="fa-solid fa-arrow-left me-2"></i> Back
            </a>
            <a href="{{ route('cms.roles.create') }}" class="btn btn-success rounded-pill px-4 shadow-sm fw-bold">
                <i class="fa-solid fa-plus me-2"></i> New Role
            </a>
        </div>
    </div>

    @include('cms.admin.partials.nav', ['active' => 'roles'])

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted" style="font-size: 0.85rem; letter-spacing: 1px;">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase">Role</th>
                            <th class="py-3 text-uppercase">Permissions</th>
                            <th class="py-3 text-uppercase text-center">Users</th>
                            <th class="pe-4 py-3 text-uppercase text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                        @php $isSuperAdmin = $role->name === \App\Support\CmsPermissions::SUPER_ADMIN_ROLE; @endphp
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="fw-bold text-dark">{{ $role->name }}</div>
                                @if($isSuperAdmin)
                                    <span class="badge bg-dark rounded-pill mt-1">Super Admin</span>
                                @endif
                            </td>
                            <td class="py-3" style="max-width: 520px;">
                                @if($isSuperAdmin)
                                    <span class="text-muted small"><i class="fa-solid fa-infinity me-1"></i> Every permission, always</span>
                                @elseif($role->permissions->isEmpty())
                                    <span class="text-muted small fst-italic">No permissions — users with this role see an empty dashboard</span>
                                @else
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach($role->permissions->sortBy('name') as $permission)
                                            <span class="badge bg-success-subtle text-success rounded-pill fw-semibold">{{ \App\Support\CmsPermissions::label($permission->name) }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </td>
                            <td class="py-3 text-center">
                                <span class="badge bg-light text-dark border rounded-pill px-3">{{ $role->users_count }}</span>
                            </td>
                            <td class="pe-4 py-3 text-end">
                                @if($isSuperAdmin)
                                    <span class="text-muted small"><i class="fa-solid fa-lock me-1"></i> Locked</span>
                                @else
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('cms.roles.edit', $role) }}" class="btn btn-sm btn-light text-primary rounded-circle shadow-sm" title="Edit role">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        @if($role->users_count > 0)
                                            <button type="button" class="btn btn-sm btn-light text-muted rounded-circle shadow-sm" disabled
                                                title="Assigned to {{ $role->users_count }} user(s) — move them to another role first">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        @else
                                            <form action="{{ route('cms.roles.destroy', $role) }}" method="POST" data-confirm="Delete the role &quot;{{ $role->name }}&quot;?">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light text-danger rounded-circle shadow-sm" title="Delete role">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">No roles yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
