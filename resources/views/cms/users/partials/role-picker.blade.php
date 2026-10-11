{{-- Role selector for the user forms. Expects $roles, $selected (role name) and optional $locked (bool). --}}
<div class="mb-5">
    <label class="form-label fw-bold text-dark d-block">Assign Role <span class="text-danger">*</span></label>

    @if(!empty($locked))
        <input type="hidden" name="role" value="{{ $selected }}">
        <div class="alert alert-light border rounded-4 small mb-0">
            <i class="fa-solid fa-lock me-1"></i> Your role is <strong>{{ $selected }}</strong>. You cannot change your own role — ask another administrator.
        </div>
    @else
        <div class="row g-3 mt-1">
            @foreach($roles as $role)
            @php $isSuperAdmin = $role->name === \App\Support\CmsPermissions::SUPER_ADMIN_ROLE; @endphp
            <div class="col-sm-6 col-lg-4">
                <label class="permission-option" for="role_{{ $role->id }}">
                    <input class="form-check-input" type="radio" name="role" value="{{ $role->name }}" id="role_{{ $role->id }}"
                           {{ $selected === $role->name ? 'checked' : '' }} required>
                    <span>
                        <span class="d-block fw-bold text-dark">{{ $role->name }}</span>
                        <span class="d-block text-muted small">
                            @if($isSuperAdmin)
                                Super admin · every permission
                            @else
                                {{ $role->permissions_count }} permission(s)
                            @endif
                        </span>
                    </span>
                </label>
            </div>
            @endforeach
        </div>
        @can('roles.manage')
            <div class="form-text mt-2">Need different access? <a href="{{ route('cms.roles.index') }}" target="_blank">Manage roles</a>.</div>
        @endcan
    @endif

    @error('role')
        <div class="text-danger small mt-2">{{ $message }}</div>
    @enderror
</div>
