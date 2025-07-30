<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Gunakan metode create() dari model Spatie
        \Spatie\Permission\Models\Role::create(['name' => 'Admin', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Role::create(['name' => 'Guru', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Role::create(['name' => 'Siswa', 'guard_name' => 'web']);
        \Spatie\Permission\Models\Role::create(['name' => 'Wali Murid', 'guard_name' => 'web']);
    }
}
