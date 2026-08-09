<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Pastikan semua Role tersedia
        $roles = ['HRGA', 'BDD', 'CRS', 'IT'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // 2. Buat (atau perbarui) user admin utama
        //    Catatan: 'IT' adalah role dengan hak akses tertinggi di aplikasi ini
        //    (manajemen user & activity logs), sehingga berperan sebagai admin.
        $admin = User::updateOrCreate(
            ['email' => 'admin@bintanindustrial.co.id'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
            ]
        );

        // 3. Berikan role IT (admin) ke user tersebut
        $admin->syncRoles(['IT']);
    }
}
