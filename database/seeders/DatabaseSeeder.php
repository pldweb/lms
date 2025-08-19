<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            TahunAjaranSeeder::class,
            MataPelajaranSeeder::class,
            UserSeeder::class,
            WaliSiswaSeeder::class,
            KelasSeeder::class,
            KeanggotaanKelasSeeder::class,
            PengaturanSistemSeeder::class,
            PengajarSeeder::class,
            KontakSeeder::class,
            SocialMediaSeeder::class,
        ]);
    }
}
