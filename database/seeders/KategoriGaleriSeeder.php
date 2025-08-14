<?php

namespace Database\Seeders;

use App\Models\KategoriGaleri;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriGaleriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = [
            [
                'nama_kategori' => 'Kegiatan Sekolah',
                'slug' => 'kegiatan-sekolah',
                'deskripsi' => 'Dokumentasi berbagai kegiatan dan acara yang diselenggarakan di sekolah',
                'status' => 'aktif',
                'urutan' => 1
            ],
            [
                'nama_kategori' => 'Prestasi Siswa',
                'slug' => 'prestasi-siswa',
                'deskripsi' => 'Foto dan video pencapaian siswa dalam berbagai kompetisi dan olimpiade',
                'status' => 'aktif',
                'urutan' => 2
            ],
            [
                'nama_kategori' => 'Upacara & Peringatan',
                'slug' => 'upacara-peringatan',
                'deskripsi' => 'Dokumentasi upacara bendera dan peringatan hari-hari besar',
                'status' => 'aktif',
                'urutan' => 3
            ],
            [
                'nama_kategori' => 'Ekstrakurikuler',
                'slug' => 'ekstrakurikuler',
                'deskripsi' => 'Aktivitas dan prestasi dalam kegiatan ekstrakurikuler sekolah',
                'status' => 'aktif',
                'urutan' => 4
            ],
            [
                'nama_kategori' => 'Fasilitas Sekolah',
                'slug' => 'fasilitas-sekolah',
                'deskripsi' => 'Foto-foto fasilitas dan lingkungan sekolah',
                'status' => 'aktif',
                'urutan' => 5
            ]
        ];

        foreach ($kategori as $item) {
            KategoriGaleri::create($item);
        }

        echo "Berhasil membuat " . count($kategori) . " kategori galeri sample\n";
    }
}
