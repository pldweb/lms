<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'nama'          => 'admin_lms',
            'email'         => 'admin@lms.test',
            'password'      => Hash::make('password'),
            'nama_lengkap'  => 'Admin Utama',
        ]);
        $admin->assignRole('Admin');

        $guru = User::create([
            'nama'          => 'guru_tes',
            'email'         => 'guru@lms.test',
            'password'      => Hash::make('password'),
            'nama_lengkap'  => 'Budi Guru',
        ]);
        $guru->assignRole('Guru');

        $siswa = User::create([
            'nama'          => 'siswa_tes',
            'email'         => 'siswa@lms.test',
            'password'      => Hash::make('password'),
            'nama_lengkap'  => 'Siti Siswa',
        ]);
        $siswa->assignRole('Siswa');

        $wali = User::create([
            'nama'          => 'wali_tes',
            'email'         => 'wali@lms.test',
            'password'      => Hash::make('password'),
            'nama_lengkap'  => 'Rahmat Wali',
        ]);
        $wali->assignRole('Wali Murid');

        // Setelah itu, baru buat pengguna dummy lainnya menggunakan factory
        User::factory(10)->create()->each(function ($user) {
            $user->assignRole('Guru');
        });

        User::factory(50)->create()->each(function ($user) {
            $user->assignRole('Siswa');
        });
        
        User::factory(40)->create()->each(function ($user) {
            $user->assignRole('Wali Murid');
        });
    }
}
