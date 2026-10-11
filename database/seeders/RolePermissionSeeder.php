<?php

namespace Database\Seeders;

use App\Support\CmsPermissions;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // 1. Permissions (defined in App\Support\CmsPermissions)
        CmsPermissions::sync();

        // 2. Roles + their default permissions. IT is the super admin and gets every permission via Gate::before.
        Role::firstOrCreate(['name' => CmsPermissions::SUPER_ADMIN_ROLE, 'guard_name' => 'web']);

        foreach (CmsPermissions::DEFAULT_ROLE_PERMISSIONS as $roleName => $permissions) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web'])->syncPermissions($permissions);
        }

        // 3. Memberikan Role ke User (Contoh: Admin utama kita)
        $user = User::where('email', 'admin@bintanindustrial.com')->first();
        if ($user) {
            $user->assignRole(CmsPermissions::SUPER_ADMIN_ROLE); // Admin kita sekarang adalah IT Admin
        }

        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
