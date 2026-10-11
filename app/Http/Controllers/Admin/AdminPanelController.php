<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use App\Support\CmsPermissions;
use Spatie\Permission\Models\Role;

class AdminPanelController extends Controller
{
    public function index()
    {
        $stats = [
            'users'       => User::count(),
            'roles'       => Role::count(),
            'permissions' => count(CmsPermissions::all()),
            'no_role'     => User::doesntHave('roles')->count(),
        ];

        $roles = Role::withCount(['users', 'permissions'])->orderBy('name')->get();

        $recentActivity = ActivityLog::with('user')
            ->whereIn('module', ['User Management', 'Role Management'])
            ->latest()
            ->take(6)
            ->get();

        return view('cms.admin.index', compact('stats', 'roles', 'recentActivity'));
    }
}
