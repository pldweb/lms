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
        // === DI SINI TEMPATNYA ===
        // Membuat Admin Utama yang spesifik untuk Anda
        $admin = User::create([
            'nama'          => 'admin_lms', // atau username yang Anda inginkan
            'email'         => 'admin@lms.test', // email spesifik Anda
            'password'      => Hash::make('12345678'), // password spesifik Anda
            'nama_lengkap'  => 'Admin LMS SMPN20',
            'alamat'        => 'Jalan Admin No. 123',
        ]);
        
        // Menentukan perannya secara spesifik
        $admin->assignRole('Admin');
        // === SELESAI ===

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
