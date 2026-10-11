@extends('layouts.main')

@section('title', 'Permissions - Admin Panel - BIIE CMS')

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
        <li class="current">Permissions</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-4 py-md-5 mt-2">

    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="fa-solid fa-key text-warning me-2"></i> Permissions
            </h2>
            <p class="text-muted mb-0">Tick what each role may do. Changes apply to every user with that role.</p>
        </div>
        <a href="{{ route('cms.admin.index') }}" class="btn btn-secondary rounded-pill px-4 fw-bold">
            <i class="fa-solid fa-arrow-left me-2"></i> Back
        </a>
    </div>

    @include('cms.admin.partials.nav', ['active' => 'permissions'])

    <form action="{{ route('cms.permissions.update') }}" method="POST">
        @csrf
        @method('PUT')
        @foreach($roles as $role)
            <input type="hidden" name="roles_in_form[]" value="{{ $role->id }}">
        @endforeach

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="table-responsive">
                <table class="table align-middle mb-0 permission-matrix">
                    <thead class="bg-light text-muted" style="font-size: 0.85rem;">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase" style="letter-spacing: 1px; min-width: 260px;">Permission</th>
                            @foreach($roles as $role)
                                <th class="py-3 text-center role-col">
                                    <div class="fw-bold text-dark">{{ $role->name }}</div>
                                    <div class="small fw-normal">{{ $role->users_count }} user(s)</div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Support\CmsPermissions::GROUPS as $group => $permissions)
                            <tr class="group-row">
                                <td colspan="{{ $roles->count() + 1 }}" class="ps-4 py-2">{{ $group }}</td>
                            </tr>
                            @foreach($permissions as $name => [$label, $description])
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="fw-bold text-dark">{{ $label }}</div>
                                    <div class="text-muted small">{{ $description }}</div>
                                </td>
                                @foreach($roles as $role)
                                    <td class="text-center">
                                        @if($role->name === \App\Support\CmsPermissions::SUPER_ADMIN_ROLE)
                                            <input type="checkbox" class="form-check-input" checked disabled
                                                   title="{{ $role->name }} is the super admin role and always has every permission"
                                                   aria-label="{{ $label }} for {{ $role->name }} (always on)">
                                        @else
                                            <input type="checkbox" class="form-check-input" name="matrix[{{ $role->id }}][]" value="{{ $name }}"
                                                   aria-label="{{ $label }} for {{ $role->name }}"
                                                   {{ in_array($name, $matrix[$role->id] ?? []) ? 'checked' : '' }}>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <p class="text-muted small mb-0">
                <i class="fa-solid fa-lock me-1"></i> {{ \App\Support\CmsPermissions::SUPER_ADMIN_ROLE }} is the super admin role and always has every permission.
            </p>
            <button type="submit" class="btn btn-success rounded-pill px-5 fw-bold shadow-sm">
                <i class="fa-solid fa-floppy-disk me-2"></i> Save Permissions
            </button>
        </div>
    </form>

</div>
@endsection
