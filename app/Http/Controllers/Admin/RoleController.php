<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Support\CmsPermissions;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('users')->with('permissions')->orderBy('name')->get();

        return view('cms.admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('cms.admin.roles.form', ['role' => new Role(), 'assigned' => []]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        $role = Role::create(['name' => $data['name'], 'guard_name' => 'web']);
        $role->syncPermissions($data['permissions']);

        LogHelper::log('CREATE', 'Role Management', "Created role: {$role->name} with " . count($data['permissions']) . ' permission(s)');

        return redirect()->route('cms.roles.index')->with('success', "Role \"{$role->name}\" created successfully.");
    }

    public function edit(Role $role)
    {
        $assigned = $role->permissions->pluck('name')->all();

        return view('cms.admin.roles.form', compact('role', 'assigned'));
    }

    public function update(Request $request, Role $role)
    {
        // The super admin role always has every permission and keeps its name (it is referenced in code)
        if ($this->isSuperAdmin($role)) {
            return back()->with('error', 'The super admin role cannot be changed.');
        }

        $data = $this->validated($request, $role);
        $oldName = $role->name;

        $role->update(['name' => $data['name']]);
        $role->syncPermissions($data['permissions']);

        $renamed = $oldName !== $role->name ? " (renamed from {$oldName})" : '';
        LogHelper::log('UPDATE', 'Role Management', "Updated role: {$role->name}{$renamed}, " . count($data['permissions']) . ' permission(s)');

        return redirect()->route('cms.roles.index')->with('success', "Role \"{$role->name}\" updated successfully.");
    }

    public function destroy(Role $role)
    {
        if ($this->isSuperAdmin($role)) {
            return back()->with('error', 'The super admin role cannot be deleted.');
        }

        $userCount = $role->users()->count();
        if ($userCount > 0) {
            return back()->with('error', "Role \"{$role->name}\" is still assigned to {$userCount} user(s). Move them to another role first.");
        }

        $name = $role->name;
        $role->delete();

        LogHelper::log('DELETE', 'Role Management', "Deleted role: {$name}");

        return redirect()->route('cms.roles.index')->with('success', "Role \"{$name}\" deleted successfully.");
    }

    private function validated(Request $request, ?Role $role = null): array
    {
        $data = $request->validate([
            'name' => [
                'required', 'string', 'max:50', 'regex:/^[\pL\pN][\pL\pN \-_&.]*$/u',
                Rule::unique('roles', 'name')->where('guard_name', 'web')->ignore($role?->id),
            ],
            'permissions'   => ['nullable', 'array'],
            'permissions.*' => ['string', Rule::in(CmsPermissions::all())],
        ], [
            'name.regex' => 'The role name may only contain letters, numbers, spaces and - _ & . characters.',
        ]);

        $data['name'] = trim($data['name']);
        $data['permissions'] = $data['permissions'] ?? [];

        return $data;
    }

    private function isSuperAdmin(Role $role): bool
    {
        return $role->name === CmsPermissions::SUPER_ADMIN_ROLE;
    }
}
