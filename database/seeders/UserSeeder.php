<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Buat Roles
        $roles = ['HRGA', 'BDD', 'CRS', 'IT'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // 2. Berikan Role ke User (pastikan user sudah ada)
        $user = User::where('email', 'admin@bintanindustrial.com')->first();
        if($user) {
            $user->assignRole('IT');
        }
    }
}