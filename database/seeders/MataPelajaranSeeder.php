<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MataPelajaran;

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
                'kode' => 'SD-MTK-1',
                'nama' => 'Matematika',
                'deskripsi' => 'Mata pelajaran matematika untuk jenjang SD',
                'jenjang' => 'SD',
                'semester' => 1,
                'sks' => 4,
                'urutan' => 1,
                'aktif' => true,
            ],
            [
                'kode' => 'SD-IPA-1',
                'nama' => 'Ilmu Pengetahuan Alam',
                'deskripsi' => 'Mata pelajaran IPA untuk jenjang SD',
                'jenjang' => 'SD',
                'semester' => 1,
                'sks' => 3,
                'urutan' => 2,
                'aktif' => true,
            ],
            [
                'kode' => 'SD-BIN-1',
                'nama' => 'Bahasa Indonesia',
                'deskripsi' => 'Mata pelajaran Bahasa Indonesia untuk jenjang SD',
                'jenjang' => 'SD',
                'semester' => 1,
                'sks' => 4,
                'urutan' => 3,
                'aktif' => true,
            ],
            [
                'kode' => 'SD-IPS-1',
                'nama' => 'Ilmu Pengetahuan Sosial',
                'deskripsi' => 'Mata pelajaran IPS untuk jenjang SD',
                'jenjang' => 'SD',
                'semester' => 1,
                'sks' => 3,
                'urutan' => 4,
                'aktif' => true,
            ],
            [
                'kode' => 'SD-PKN-1',
                'nama' => 'Pendidikan Kewarganegaraan',
                'deskripsi' => 'Mata pelajaran PKN untuk jenjang SD',
                'jenjang' => 'SD',
                'semester' => 1,
                'sks' => 2,
                'urutan' => 5,
                'aktif' => true,
            ],
            
            // Mata Pelajaran SMP
            [
                'kode' => 'SMP-MTK-1',
                'nama' => 'Matematika',
                'deskripsi' => 'Mata pelajaran matematika untuk jenjang SMP',
                'jenjang' => 'SMP',
                'semester' => 1,
                'sks' => 4,
                'urutan' => 1,
                'aktif' => true,
            ],
            [
                'kode' => 'SMP-IPA-1',
                'nama' => 'Ilmu Pengetahuan Alam',
                'deskripsi' => 'Mata pelajaran IPA untuk jenjang SMP',
                'jenjang' => 'SMP',
                'semester' => 1,
                'sks' => 4,
                'urutan' => 2,
                'aktif' => true,
            ],
            [
                'kode' => 'SMP-BIN-1',
                'nama' => 'Bahasa Indonesia',
                'deskripsi' => 'Mata pelajaran Bahasa Indonesia untuk jenjang SMP',
                'jenjang' => 'SMP',
                'semester' => 1,
                'sks' => 4,
                'urutan' => 3,
                'aktif' => true,
            ],
            [
                'kode' => 'SMP-ENG-1',
                'nama' => 'Bahasa Inggris',
                'deskripsi' => 'Mata pelajaran Bahasa Inggris untuk jenjang SMP',
                'jenjang' => 'SMP',
                'semester' => 1,
                'sks' => 3,
                'urutan' => 4,
                'aktif' => true,
            ],
            [
                'kode' => 'SMP-IPS-1',
                'nama' => 'Ilmu Pengetahuan Sosial',
                'deskripsi' => 'Mata pelajaran IPS untuk jenjang SMP',
                'jenjang' => 'SMP',
                'semester' => 1,
                'sks' => 3,
                'urutan' => 5,
                'aktif' => true,
            ],
            [
                'kode' => 'SMP-PKN-1',
                'nama' => 'Pendidikan Kewarganegaraan',
                'deskripsi' => 'Mata pelajaran PKN untuk jenjang SMP',
                'jenjang' => 'SMP',
                'semester' => 1,
                'sks' => 2,
                'urutan' => 6,
                'aktif' => true,
            ],
            
            // Mata Pelajaran SMA
            [
                'kode' => 'SMA-MTK-1',
                'nama' => 'Matematika Wajib',
                'deskripsi' => 'Mata pelajaran matematika wajib untuk jenjang SMA',
                'jenjang' => 'SMA',
                'semester' => 1,
                'sks' => 4,
                'urutan' => 1,
                'aktif' => true,
            ],
            [
                'kode' => 'SMA-FIS-1',
                'nama' => 'Fisika',
                'deskripsi' => 'Mata pelajaran Fisika untuk jenjang SMA',
                'jenjang' => 'SMA',
                'semester' => 1,
                'sks' => 3,
                'urutan' => 2,
                'aktif' => true,
            ],
            [
                'kode' => 'SMA-KIM-1',
                'nama' => 'Kimia',
                'deskripsi' => 'Mata pelajaran Kimia untuk jenjang SMA',
                'jenjang' => 'SMA',
                'semester' => 1,
                'sks' => 3,
                'urutan' => 3,
                'aktif' => true,
            ],
            [
                'kode' => 'SMA-BIO-1',
                'nama' => 'Biologi',
                'deskripsi' => 'Mata pelajaran Biologi untuk jenjang SMA',
                'jenjang' => 'SMA',
                'semester' => 1,
                'sks' => 3,
                'urutan' => 4,
                'aktif' => true,
            ],
            [
                'kode' => 'SMA-BIN-1',
                'nama' => 'Bahasa Indonesia',
                'deskripsi' => 'Mata pelajaran Bahasa Indonesia untuk jenjang SMA',
                'jenjang' => 'SMA',
                'semester' => 1,
                'sks' => 4,
                'urutan' => 5,
                'aktif' => true,
            ],
            [
                'kode' => 'SMA-ENG-1',
                'nama' => 'Bahasa Inggris',
                'deskripsi' => 'Mata pelajaran Bahasa Inggris untuk jenjang SMA',
                'jenjang' => 'SMA',
                'semester' => 1,
                'sks' => 3,
                'urutan' => 6,
                'aktif' => true,
            ],
            [
                'kode' => 'SMA-SEJ-1',
                'nama' => 'Sejarah',
                'deskripsi' => 'Mata pelajaran Sejarah untuk jenjang SMA',
                'jenjang' => 'SMA',
                'semester' => 1,
                'sks' => 2,
                'urutan' => 7,
                'aktif' => true,
            ],
            [
                'kode' => 'SMA-GEO-1',
                'nama' => 'Geografi',
                'deskripsi' => 'Mata pelajaran Geografi untuk jenjang SMA',
                'jenjang' => 'SMA',
                'semester' => 1,
                'sks' => 2,
                'urutan' => 8,
                'aktif' => true,
            ],
            [
                'kode' => 'SMA-EKO-1',
                'nama' => 'Ekonomi',
                'deskripsi' => 'Mata pelajaran Ekonomi untuk jenjang SMA',
                'jenjang' => 'SMA',
                'semester' => 1,
                'sks' => 2,
                'urutan' => 9,
                'aktif' => true,
            ],
            [
                'kode' => 'SMA-SOS-1',
                'nama' => 'Sosiologi',
                'deskripsi' => 'Mata pelajaran Sosiologi untuk jenjang SMA',
                'jenjang' => 'SMA',
                'semester' => 1,
                'sks' => 2,
                'urutan' => 10,
                'aktif' => true,
            ],
        ];

        // Insert data menggunakan model
        foreach ($mataPelajaranData as $data) {
            MataPelajaran::create($data);
        }
    }
}
