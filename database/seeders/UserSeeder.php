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
        // Membuat Admin Utama
        User::create([
            'nama' => 'Admin LMS',
            'email' => 'admin@lms.test',
            'password' => Hash::make('password'),
            'role_id' => 1, // Asumsi ID 1 adalah Admin
        ]);

        // Membuat Guru (10)
        User::factory(10)->create(['role_id' => 2]); // Asumsi ID 2 adalah Guru

        // Membuat Siswa (50)
        User::factory(50)->create(['role_id' => 3]); // Asumsi ID 3 adalah Siswa
        
        // Membuat Wali Murid (40)
        User::factory(40)->create(['role_id' => 4]); // Asumsi ID 4 adalah Wali
    }
}
