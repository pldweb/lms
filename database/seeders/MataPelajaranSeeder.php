<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MataPelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mataPelajaranData = [
            // Mata Pelajaran SD
            [
                'kode' => 'MTK001',
                'nama' => 'Matematika',
                'deskripsi' => 'Mata pelajaran matematika untuk jenjang SD',
                'kategori' => 'wajib',
                'jenjang' => 'SD',
                'tingkat' => null,
                'bobot_sks' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode' => 'IPA001',
                'nama' => 'Ilmu Pengetahuan Alam',
                'deskripsi' => 'Mata pelajaran IPA untuk jenjang SD',
                'kategori' => 'wajib',
                'jenjang' => 'SD',
                'tingkat' => null,
                'bobot_sks' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode' => 'BIN001',
                'nama' => 'Bahasa Indonesia',
                'deskripsi' => 'Mata pelajaran Bahasa Indonesia',
                'kategori' => 'wajib',
                'jenjang' => 'SD',
                'tingkat' => null,
                'bobot_sks' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode' => 'IPS001',
                'nama' => 'Ilmu Pengetahuan Sosial',
                'deskripsi' => 'Mata pelajaran IPS untuk jenjang SD',
                'kategori' => 'wajib',
                'jenjang' => 'SD',
                'tingkat' => null,
                'bobot_sks' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            
            // Mata Pelajaran SMP
            [
                'kode' => 'MTK002',
                'nama' => 'Matematika',
                'deskripsi' => 'Mata pelajaran matematika untuk jenjang SMP',
                'kategori' => 'wajib',
                'jenjang' => 'SMP',
                'tingkat' => null,
                'bobot_sks' => 5,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode' => 'IPA002',
                'nama' => 'Ilmu Pengetahuan Alam',
                'deskripsi' => 'Mata pelajaran IPA untuk jenjang SMP',
                'kategori' => 'wajib',
                'jenjang' => 'SMP',
                'tingkat' => null,
                'bobot_sks' => 5,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode' => 'BIN002',
                'nama' => 'Bahasa Indonesia',
                'deskripsi' => 'Mata pelajaran Bahasa Indonesia untuk SMP',
                'kategori' => 'wajib',
                'jenjang' => 'SMP',
                'tingkat' => null,
                'bobot_sks' => 6,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode' => 'IPS002',
                'nama' => 'Ilmu Pengetahuan Sosial',
                'deskripsi' => 'Mata pelajaran IPS untuk jenjang SMP',
                'kategori' => 'wajib',
                'jenjang' => 'SMP',
                'tingkat' => null,
                'bobot_sks' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode' => 'ENG001',
                'nama' => 'Bahasa Inggris',
                'deskripsi' => 'Mata pelajaran Bahasa Inggris',
                'kategori' => 'wajib',
                'jenjang' => 'SMP',
                'tingkat' => null,
                'bobot_sks' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            
            // Mata Pelajaran SMA
            [
                'kode' => 'FIS001',
                'nama' => 'Fisika',
                'deskripsi' => 'Mata pelajaran Fisika untuk SMA IPA',
                'kategori' => 'wajib',
                'jenjang' => 'SMA',
                'tingkat' => null,
                'bobot_sks' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode' => 'KIM001',
                'nama' => 'Kimia',
                'deskripsi' => 'Mata pelajaran Kimia untuk SMA IPA',
                'kategori' => 'wajib',
                'jenjang' => 'SMA',
                'tingkat' => null,
                'bobot_sks' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode' => 'BIO001',
                'nama' => 'Biologi',
                'deskripsi' => 'Mata pelajaran Biologi untuk SMA IPA',
                'kategori' => 'wajib',
                'jenjang' => 'SMA',
                'tingkat' => null,
                'bobot_sks' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode' => 'MTK003',
                'nama' => 'Matematika',
                'deskripsi' => 'Mata pelajaran matematika untuk jenjang SMA',
                'kategori' => 'wajib',
                'jenjang' => 'SMA',
                'tingkat' => null,
                'bobot_sks' => 5,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode' => 'BIN003',
                'nama' => 'Bahasa Indonesia',
                'deskripsi' => 'Mata pelajaran Bahasa Indonesia untuk SMA',
                'kategori' => 'wajib',
                'jenjang' => 'SMA',
                'tingkat' => null,
                'bobot_sks' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'kode' => 'ENG002',
                'nama' => 'Bahasa Inggris',
                'deskripsi' => 'Mata pelajaran Bahasa Inggris untuk SMA',
                'kategori' => 'wajib',
                'jenjang' => 'SMA',
                'tingkat' => null,
                'bobot_sks' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        // Gunakan query builder langsung
        foreach ($mataPelajaranData as $data) {
            DB::table('mata_pelajaran')->insert($data);
        }
    }
}
