@extends('layouts.main')

@section('title', 'Admin Panel - BIIE CMS')

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
        <li class="current">Admin Panel</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-4 py-md-5 mt-2">

    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="fa-solid fa-user-gear text-success me-2"></i> Admin Panel
            </h2>
            <p class="text-muted mb-0">Manage who can sign in to the CMS and what each role is allowed to do.</p>
        </div>
        <a href="{{ route('cms.dashboard') }}" class="btn btn-secondary rounded-pill px-4 fw-bold">
            <i class="fa-solid fa-arrow-left me-2"></i> Back
        </a>
    </div>

    @include('cms.admin.partials.nav', ['active' => 'overview'])

    {{-- Stats --}}
    <div class="row g-4 mb-4">
        @php
            $statCards = [
                ['label' => 'Users', 'value' => $stats['users'], 'icon' => 'fa-users', 'class' => 'bg-success-subtle text-success', 'route' => 'cms.users.index', 'can' => 'users.manage'],
                ['label' => 'Roles', 'value' => $stats['roles'], 'icon' => 'fa-user-shield', 'class' => 'bg-primary-subtle text-primary', 'route' => 'cms.roles.index', 'can' => 'roles.manage'],
                ['label' => 'Permissions', 'value' => $stats['permissions'], 'icon' => 'fa-key', 'class' => 'bg-warning-subtle text-warning', 'route' => 'cms.permissions.index', 'can' => 'roles.manage'],
            ];
        @endphp
        @foreach($statCards as $card)
        <div class="col-md-4">
            @can($card['can'])
            <a href="{{ route($card['route']) }}" class="card border-0 shadow-sm rounded-4 p-4 h-100 text-decoration-none cms-card">
            @else
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
            @endcan
                <div class="d-flex align-items-center gap-3">
                    <div class="admin-stat-icon {{ $card['class'] }}"><i class="fa-solid {{ $card['icon'] }}"></i></div>
                    <div>
                        <div class="fs-2 fw-bold text-dark lh-1">{{ $card['value'] }}</div>
                        <div class="text-muted small mt-1">{{ $card['label'] }}</div>
                    </div>
                </div>
            @can($card['can'])
            </a>
            @else
            </div>
            @endcan
        </div>
        @endforeach
    </div>

    @if($stats['no_role'] > 0)
    <div class="alert alert-warning border-0 rounded-4 d-flex align-items-center gap-2 mb-4">
        <i class="fa-solid fa-triangle-exclamation"></i>
        <span><strong>{{ $stats['no_role'] }}</strong> user(s) have no role and cannot sign in to the CMS.</span>
        @can('users.manage')
            <a href="{{ route('cms.users.index') }}" class="ms-auto fw-bold text-decoration-none">Review users</a>
        @endcan
    </div>
    @endif

    <div class="row g-4">
        {{-- Roles summary --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-dark mb-0">Roles at a glance</h5>
                        @can('roles.manage')
                            <a href="{{ route('cms.roles.create') }}" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-bold">
                                <i class="fa-solid fa-plus me-1"></i> New Role
                            </a>
                        @endcan
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="text-muted small text-uppercase">
                                <tr>
                                    <th class="fw-semibold">Role</th>
                                    <th class="fw-semibold text-center">Users</th>
                                    <th class="fw-semibold text-center">Permissions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td class="fw-bold text-dark">
                                        {{ $role->name }}
                                        @if($role->name === \App\Support\CmsPermissions::SUPER_ADMIN_ROLE)
                                            <span class="badge bg-dark rounded-pill ms-1">Super Admin</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $role->users_count }}</td>
                                    <td class="text-center">
                                        @if($role->name === \App\Support\CmsPermissions::SUPER_ADMIN_ROLE)
                                            <span class="text-muted small">All</span>
                                        @else
                                            {{ $role->permissions_count }} / {{ $stats['permissions'] }}
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent admin activity --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-dark mb-0">Recent admin activity</h5>
                        @can('activity-logs.view')
                            <a href="{{ route('cms.logs.index') }}" class="small fw-bold text-decoration-none text-success">View all</a>
                        @endcan
                    </div>
                    @forelse($recentActivity as $log)
                        <div class="d-flex gap-3 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div class="admin-avatar" style="width: 32px; height: 32px; font-size: 0.8rem;">{{ strtoupper(substr($log->user->name ?? '?', 0, 1)) }}</div>
                            <div class="small">
                                <div class="text-dark">{{ $log->description }}</div>
                                <div class="text-muted" style="font-size: 0.75rem;">{{ $log->user->name ?? 'Unknown' }} · {{ $log->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted small mb-0">No user or role changes yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
