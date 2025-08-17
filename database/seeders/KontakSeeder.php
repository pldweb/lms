<?php

namespace Database\Seeders;

use App\Models\Kontak;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KontakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kontak = [
            [
                'nama' => 'Kepala Sekolah',
                'jabatan' => 'Kepala Sekolah',
                'email' => 'kepsek@smp20jakarta.sch.id',
                'telepon' => '021-12345678',
                'alamat' => 'Jl. Contoh No. 123, Jakarta',
                'icon' => 'fas fa-user-tie',
                'urutan' => 1,
                'aktif' => true,
            ],
            [
                'nama' => 'Tata Usaha',
                'jabatan' => 'Tata Usaha',
                'email' => 'tu@smp20jakarta.sch.id',
                'telepon' => '021-87654321',
                'alamat' => 'Jl. Contoh No. 123, Jakarta',
                'icon' => 'fas fa-envelope',
                'urutan' => 2,
                'aktif' => true,
            ],
            [
                'nama' => 'Bagian Kesiswaan',
                'jabatan' => 'Wakil Kepala Sekolah Bidang Kesiswaan',
                'email' => 'kesiswaan@smp20jakarta.sch.id',
                'telepon' => '021-13579246',
                'alamat' => 'Jl. Contoh No. 123, Jakarta',
                'icon' => 'fas fa-users',
                'urutan' => 3,
                'aktif' => true,
            ]
        ];

        foreach ($kontak as $item) {
            Kontak::create($item);
        }
    }
}