@extends('layouts.main')

@php
    $isEdit = $role->exists;
    $isSuperAdmin = $isEdit && $role->name === \App\Support\CmsPermissions::SUPER_ADMIN_ROLE;
    $checked = old('permissions', $assigned);
@endphp

@section('title', ($isEdit ? 'Edit Role' : 'New Role') . ' - Admin Panel - BIIE CMS')

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
        <li><a href="{{ route('cms.roles.index') }}">Roles</a></li>
        <li class="current">{{ $isEdit ? 'Edit Role' : 'New Role' }}</li>
      </ol>
    </nav>
  </div>
</div>

<div class="container py-4 py-md-5 mt-2">

    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="fa-solid fa-user-shield text-primary me-2"></i> {{ $isEdit ? 'Edit Role: ' . $role->name : 'New Role' }}
            </h2>
            <p class="text-muted mb-0">Choose which parts of the CMS users with this role can manage.</p>
        </div>
        <a href="{{ route('cms.roles.index') }}" class="btn btn-secondary rounded-pill px-4 fw-bold">
            <i class="fa-solid fa-arrow-left me-2"></i> Back
        </a>
    </div>

    @if($isSuperAdmin)
        <div class="alert alert-dark border-0 rounded-4">
            <i class="fa-solid fa-lock me-2"></i> <strong>{{ $role->name }}</strong> is the super admin role. It always has every permission and cannot be renamed or deleted.
        </div>
    @else
    <form action="{{ $isEdit ? route('cms.roles.update', $role) : route('cms.roles.store') }}" method="POST">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <label class="form-label fw-bold text-dark" for="roleName">Role Name <span class="text-danger">*</span></label>
                <input type="text" id="roleName" name="name" maxlength="50" required
                       class="form-control rounded-pill @error('name') is-invalid @enderror"
                       value="{{ old('name', $role->name) }}" placeholder="e.g. Marketing, HR Staff">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                @if($isEdit && $role->users()->count() > 0)
                    <div class="form-text">This role is assigned to {{ $role->users()->count() }} user(s). Changes apply to them immediately.</div>
                @endif
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                    <h5 class="fw-bold text-dark mb-0">Permissions</h5>
                    <div class="d-flex gap-3 small">
                        <a href="#" class="text-decoration-none fw-bold text-success js-check-all" data-check="1">Select all</a>
                        <a href="#" class="text-decoration-none fw-bold text-muted js-check-all" data-check="0">Clear</a>
                    </div>
                </div>
                @error('permissions') <div class="text-danger small mb-2">{{ $message }}</div> @enderror
                @error('permissions.*') <div class="text-danger small mb-2">{{ $message }}</div> @enderror

                @foreach(\App\Support\CmsPermissions::GROUPS as $group => $permissions)
                    <div class="text-uppercase text-muted fw-bold small mt-4 mb-2" style="letter-spacing: 1px;">{{ $group }}</div>
                    <div class="row g-3">
                        @foreach($permissions as $name => [$label, $description])
                        <div class="col-md-6 col-lg-4">
                            <label class="permission-option" for="perm_{{ $loop->parent->index }}_{{ $loop->index }}">
                                <input class="form-check-input js-permission" type="checkbox" name="permissions[]" value="{{ $name }}"
                                       id="perm_{{ $loop->parent->index }}_{{ $loop->index }}" {{ in_array($name, $checked) ? 'checked' : '' }}>
                                <span>
                                    <span class="d-block fw-bold text-dark">{{ $label }}</span>
                                    <span class="d-block text-muted small">{{ $description }}</span>
                                </span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('cms.roles.index') }}" class="btn btn-light rounded-pill px-4 fw-bold">Cancel</a>
            <button type="submit" class="btn btn-success rounded-pill px-5 fw-bold shadow-sm">
                <i class="fa-solid fa-floppy-disk me-2"></i> {{ $isEdit ? 'Save Changes' : 'Create Role' }}
            </button>
        </div>
    </form>
    @endif

</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/pages/cms-admin-role-form.js') }}"></script>
@endpush
