{{-- Admin Panel tab menu. Pass $active: overview | users | roles | permissions --}}
@php
    $adminTabs = array_filter([
        ['key' => 'overview', 'label' => 'Overview', 'icon' => 'fa-gauge-high', 'route' => 'cms.admin.index', 'can' => 'users.manage|roles.manage'],
        ['key' => 'users', 'label' => 'Users', 'icon' => 'fa-users', 'route' => 'cms.users.index', 'can' => 'users.manage'],
        ['key' => 'roles', 'label' => 'Roles', 'icon' => 'fa-user-shield', 'route' => 'cms.roles.index', 'can' => 'roles.manage'],
        ['key' => 'permissions', 'label' => 'Permissions', 'icon' => 'fa-key', 'route' => 'cms.permissions.index', 'can' => 'roles.manage'],
    ], fn ($tab) => auth()->user()->canAny(explode('|', $tab['can'])));
@endphp

<nav class="admin-nav mb-4" aria-label="Admin panel sections">
    @foreach($adminTabs as $tab)
        <a href="{{ route($tab['route']) }}" class="admin-nav-link {{ ($active ?? '') === $tab['key'] ? 'active' : '' }}"
           @if(($active ?? '') === $tab['key']) aria-current="page" @endif>
            <i class="fa-solid {{ $tab['icon'] }} me-2"></i>{{ $tab['label'] }}
        </a>
    @endforeach
    @can('activity-logs.view')
        <a href="{{ route('cms.logs.index') }}" class="admin-nav-link">
            <i class="fa-solid fa-clock-rotate-left me-2"></i>Activity Log
        </a>
    @endcan
</nav>
