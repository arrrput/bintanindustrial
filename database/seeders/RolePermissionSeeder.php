<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    // 1. Buat Roles
    $hrga = Role::create(['name' => 'HRGA']);
    $bdd = Role::create(['name' => 'BDD']);
    $crs = Role::create(['name' => 'CRS']);
    $it = Role::create(['name' => 'IT']); // Role baru

    // 2. Memberikan Role ke User (Contoh: Admin utama kita)
    $user = User::where('email', 'admin@bintanindustrial.com')->first();
    if($user) {
        $user->assignRole('IT'); // Admin kita sekarang adalah IT Admin
    }
    }
}