<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;

class PengaturanSistemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disesuaikan dengan struktur tabel `pengaturan_sistem` Anda
        DB::table('pengaturan_sistem')->insert([
            [
                'kunci_pengaturan' => 'nama_sekolah',
                'nilai_pengaturan' => 'SMP Negeri 20 Jakarta'
            ],
            [
                'kunci_pengaturan' => 'logo_sekolah_url',
                'nilai_pengaturan' => '/images/logo.png'
            ],
        ]);
    }
}
