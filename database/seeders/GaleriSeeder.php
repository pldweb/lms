<?php

namespace Database\Seeders;

use App\Models\Galeri;
use App\Models\KategoriGaleri;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GaleriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil kategori yang sudah dibuat
        $kategoriKegiatan = KategoriGaleri::where('slug', 'kegiatan-sekolah')->first();
        $kategoriPrestasi = KategoriGaleri::where('slug', 'prestasi-siswa')->first();
        $kategoriUpacara = KategoriGaleri::where('slug', 'upacara-peringatan')->first();
        $kategoriEkskul = KategoriGaleri::where('slug', 'ekstrakurikuler')->first();
        $kategoriFasilitas = KategoriGaleri::where('slug', 'fasilitas-sekolah')->first();

        $galeri = [
            // Kegiatan Sekolah - Video YouTube
            [
                'kategori_galeri_id' => $kategoriKegiatan->id,
                'judul' => 'Penerimaan Peserta Didik Baru 2024',
                'deskripsi' => 'Suasana pendaftaran dan seleksi siswa baru tahun ajaran 2024/2025',
                'tipe' => 'video',
                'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'youtube_thumbnail' => 'https://img.youtube.com/vi/dQw4w9WgXcQ/maxresdefault.jpg',
                'tanggal_foto' => '2024-06-15',
                'fotografer' => 'Tim Dokumentasi SMPN 20',
                'urutan' => 1,
                'status' => 'aktif'
            ],
            [
                'kategori_galeri_id' => $kategoriKegiatan->id,
                'judul' => 'Orientasi Siswa Baru 2024',
                'deskripsi' => 'Kegiatan pengenalan lingkungan sekolah untuk siswa baru',
                'tipe' => 'video',
                'youtube_url' => 'https://youtu.be/jNQXAC9IVRw',
                'youtube_thumbnail' => 'https://img.youtube.com/vi/jNQXAC9IVRw/maxresdefault.jpg',
                'tanggal_foto' => '2024-07-15',
                'fotografer' => 'Tim Dokumentasi SMPN 20',
                'urutan' => 2,
                'status' => 'aktif'
            ],

            // Prestasi Siswa
            [
                'kategori_galeri_id' => $kategoriPrestasi->id,
                'judul' => 'Juara 1 Olimpiade Matematika Tingkat Kota',
                'deskripsi' => 'Siswa SMPN 20 meraih juara 1 dalam Olimpiade Matematika tingkat kota Jakarta',
                'tipe' => 'foto',
                'file_path' => 'prestasi-matematika-2024.jpg',
                'tanggal_foto' => '2024-08-01',
                'fotografer' => 'Budi Santoso',
                'urutan' => 1,
                'status' => 'aktif'
            ],
            [
                'kategori_galeri_id' => $kategoriPrestasi->id,
                'judul' => 'Lomba Debat Bahasa Inggris',
                'deskripsi' => 'Tim debat SMPN 20 berhasil masuk semifinal lomba debat tingkat provinsi',
                'tipe' => 'foto',
                'file_path' => 'debat-inggris-2024.jpg',
                'tanggal_foto' => '2024-07-20',
                'fotografer' => 'Sari Dewi',
                'urutan' => 2,
                'status' => 'aktif'
            ],

            // Upacara & Peringatan
            [
                'kategori_galeri_id' => $kategoriUpacara->id,
                'judul' => 'Upacara HUT RI ke-79',
                'deskripsi' => 'Upacara memperingati HUT Kemerdekaan RI ke-79 di halaman sekolah',
                'tipe' => 'foto',
                'file_path' => 'upacara-hut-ri-79.jpg',
                'tanggal_foto' => '2024-08-17',
                'fotografer' => 'Tim Dokumentasi SMPN 20',
                'urutan' => 1,
                'status' => 'aktif'
            ],
            [
                'kategori_galeri_id' => $kategoriUpacara->id,
                'judul' => 'Peringatan Hari Kartini',
                'deskripsi' => 'Peringatan Hari Kartini dengan berbagai lomba dan penampilan',
                'tipe' => 'video',
                'youtube_url' => 'https://www.youtube.com/watch?v=oHg5SJYRHA0',
                'youtube_thumbnail' => 'https://img.youtube.com/vi/oHg5SJYRHA0/maxresdefault.jpg',
                'tanggal_foto' => '2024-04-21',
                'fotografer' => 'Ahmad Rahman',
                'urutan' => 2,
                'status' => 'aktif'
            ],

            // Ekstrakurikuler
            [
                'kategori_galeri_id' => $kategoriEkskul->id,
                'judul' => 'Latihan Pramuka',
                'deskripsi' => 'Kegiatan latihan rutin ekstrakurikuler Pramuka',
                'tipe' => 'foto',
                'file_path' => 'pramuka-latihan.jpg',
                'tanggal_foto' => '2024-08-05',
                'fotografer' => 'Eko Prasetyo',
                'urutan' => 1,
                'status' => 'aktif'
            ],
            [
                'kategori_galeri_id' => $kategoriEkskul->id,
                'judul' => 'Pertunjukan Tari Tradisional',
                'deskripsi' => 'Penampilan ekstrakurikuler tari dalam acara pentas seni sekolah',
                'tipe' => 'foto',
                'file_path' => 'tari-tradisional.jpg',
                'tanggal_foto' => '2024-07-25',
                'fotografer' => 'Maya Sari',
                'urutan' => 2,
                'status' => 'aktif'
            ],

            // Fasilitas Sekolah
            [
                'kategori_galeri_id' => $kategoriFasilitas->id,
                'judul' => 'Perpustakaan Modern',
                'deskripsi' => 'Fasilitas perpustakaan yang telah direnovasi dengan koleksi buku terlengkap',
                'tipe' => 'foto',
                'file_path' => 'perpustakaan-modern.jpg',
                'tanggal_foto' => '2024-08-01',
                'fotografer' => 'Tim Dokumentasi SMPN 20',
                'urutan' => 1,
                'status' => 'aktif'
            ],
            [
                'kategori_galeri_id' => $kategoriFasilitas->id,
                'judul' => 'Laboratorium Komputer',
                'deskripsi' => 'Laboratorium komputer dengan perangkat terbaru untuk mendukung pembelajaran IT',
                'tipe' => 'foto',
                'file_path' => 'lab-komputer.jpg',
                'tanggal_foto' => '2024-08-01',
                'fotografer' => 'Tim Dokumentasi SMPN 20',
                'urutan' => 2,
                'status' => 'aktif'
            ]
        ];

        foreach ($galeri as $item) {
            Galeri::create($item);
        }

        echo "Berhasil membuat " . count($galeri) . " item galeri sample\n";
    }
}
