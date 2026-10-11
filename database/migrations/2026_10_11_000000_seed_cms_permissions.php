<?php

use App\Support\CmsPermissions;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;

/**
 * Introduces permission-based access for the CMS.
 * Creates the CMS permissions and gives the existing roles the same access
 * they had through the old hard-coded role middleware.
 */
return new class extends Migration
{
    public function up(): void
    {
        CmsPermissions::sync();

        Role::firstOrCreate(['name' => CmsPermissions::SUPER_ADMIN_ROLE, 'guard_name' => 'web']);

        foreach (CmsPermissions::DEFAULT_ROLE_PERMISSIONS as $roleName => $permissions) {
            $role = Role::where('name', $roleName)->where('guard_name', 'web')->first();
            // Only fill roles that have no permissions yet, never overwrite admin choices
            if ($role && $role->permissions()->count() === 0) {
                $role->givePermissionTo($permissions);
            }
        }

        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function down(): void
    {
        \Spatie\Permission\Models\Permission::whereIn('name', CmsPermissions::all())->delete();
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }
};
