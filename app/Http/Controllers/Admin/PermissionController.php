<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Support\CmsPermissions;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

/**
 * Role × permission matrix: every permission in one table, one column per role.
 */
class PermissionController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->withCount('users')->orderBy('name')->get();

        // [role id => [permission names]]
        $matrix = $roles->mapWithKeys(fn ($role) => [$role->id => $role->permissions->pluck('name')->all()]);

        return view('cms.admin.permissions.index', compact('roles', 'matrix'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'roles_in_form'   => ['required', 'array'],
            'roles_in_form.*' => ['integer'],
            'matrix'          => ['nullable', 'array'],
            'matrix.*'        => ['array'],
            'matrix.*.*'      => ['string', Rule::in(CmsPermissions::all())],
        ]);

        $matrix = $request->input('matrix', []);
        $changed = [];

        // Only touch roles that were shown in the form, so a role created meanwhile is not wiped
        $roles = Role::with('permissions')->whereIn('id', $request->input('roles_in_form'))->get();

        foreach ($roles as $role) {
            if ($role->name === CmsPermissions::SUPER_ADMIN_ROLE) {
                continue; // always has everything
            }

            $new = array_values(array_unique($matrix[$role->id] ?? []));
            $old = $role->permissions->pluck('name')->all();

            sort($new);
            sort($old);
            if ($new === $old) {
                continue;
            }

            $role->syncPermissions($new);
            $changed[] = $role->name;
        }

        if (empty($changed)) {
            return back()->with('info', 'No changes to save.');
        }

        LogHelper::log('UPDATE', 'Role Management', 'Updated permissions for role(s): ' . implode(', ', $changed));

        return back()->with('success', 'Permissions updated for ' . implode(', ', $changed) . '.');
    }
}
