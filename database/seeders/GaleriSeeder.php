<?php

namespace Database\Seeders;

use App\Models\Galeri;
use App\Models\KategoriGaleri;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class GaleriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan direktori untuk menyimpan gambar galeri ada
        $this->createDirectories();
        
        // Ambil kategori yang sudah dibuat
        $kategoriKegiatan = KategoriGaleri::where('slug', 'kegiatan-sekolah')->first();
        $kategoriPrestasi = KategoriGaleri::where('slug', 'prestasi-siswa')->first();
        $kategoriUpacara = KategoriGaleri::where('slug', 'upacara-peringatan')->first();
        $kategoriEkskul = KategoriGaleri::where('slug', 'ekstrakurikuler')->first();
        $kategoriFasilitas = KategoriGaleri::where('slug', 'fasilitas-sekolah')->first();

        // Jika kategori belum ada, buat kategori terlebih dahulu
        if (!$kategoriKegiatan) {
            echo "Kategori galeri belum dibuat. Jalankan KategoriGaleriSeeder terlebih dahulu.\n";
            return;
        }

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
            [
                'kategori_galeri_id' => $kategoriKegiatan->id,
                'judul' => 'Rapat Komite Sekolah',
                'deskripsi' => 'Rapat koordinasi antara pihak sekolah dengan komite sekolah',
                'tipe' => 'foto',
                'file_path' => 'kegiatan-rapat-komite.jpg',
                'tanggal_foto' => '2024-07-10',
                'fotografer' => 'Hadi Santoso',
                'urutan' => 3,
                'status' => 'aktif'
            ],

            // Prestasi Siswa
            [
                'kategori_galeri_id' => $kategoriPrestasi->id,
                'judul' => 'Juara 1 Olimpiade Matematika Tingkat Kota',
                'deskripsi' => 'Siswa SMPN 20 meraih juara 1 dalam Olimpiade Matematika tingkat kota',
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
            [
                'kategori_galeri_id' => $kategoriPrestasi->id,
                'judul' => 'Juara 2 Kompetisi Sains Nasional',
                'deskripsi' => 'Tim KSN SMPN 20 berhasil meraih juara 2 dalam Kompetisi Sains Nasional bidang Fisika',
                'tipe' => 'video',
                'youtube_url' => 'https://www.youtube.com/watch?v=9bZkp7q19f0',
                'youtube_thumbnail' => 'https://img.youtube.com/vi/9bZkp7q19f0/maxresdefault.jpg',
                'tanggal_foto' => '2024-06-25',
                'fotografer' => 'Tim Dokumentasi SMPN 20',
                'urutan' => 3,
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
            [
                'kategori_galeri_id' => $kategoriUpacara->id,
                'judul' => 'Upacara Hari Pendidikan Nasional',
                'deskripsi' => 'Upacara memperingati Hari Pendidikan Nasional dengan pemberian penghargaan kepada guru berprestasi',
                'tipe' => 'foto',
                'file_path' => 'upacara-hardiknas.jpg',
                'tanggal_foto' => '2024-05-02',
                'fotografer' => 'Dina Pratiwi',
                'urutan' => 3,
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
            [
                'kategori_galeri_id' => $kategoriEkskul->id,
                'judul' => 'Latihan Futsal',
                'deskripsi' => 'Tim futsal SMPN 20 berlatih untuk persiapan turnamen antar sekolah',
                'tipe' => 'foto',
                'file_path' => 'futsal-latihan.jpg',
                'tanggal_foto' => '2024-07-18',
                'fotografer' => 'Rudi Hartono',
                'urutan' => 3,
                'status' => 'aktif'
            ],
            [
                'kategori_galeri_id' => $kategoriEkskul->id,
                'judul' => 'Klub Robotik',
                'deskripsi' => 'Kegiatan klub robotik dalam mempersiapkan robot untuk kompetisi nasional',
                'tipe' => 'video',
                'youtube_url' => 'https://www.youtube.com/watch?v=8ybW48rKBME',
                'youtube_thumbnail' => 'https://img.youtube.com/vi/8ybW48rKBME/maxresdefault.jpg',
                'tanggal_foto' => '2024-06-30',
                'fotografer' => 'Tim Dokumentasi SMPN 20',
                'urutan' => 4,
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
            ],
            [
                'kategori_galeri_id' => $kategoriFasilitas->id,
                'judul' => 'Lapangan Olahraga',
                'deskripsi' => 'Lapangan olahraga multifungsi yang baru direnovasi',
                'tipe' => 'foto',
                'file_path' => 'lapangan-olahraga.jpg',
                'tanggal_foto' => '2024-07-28',
                'fotografer' => 'Agus Widodo',
                'urutan' => 3,
                'status' => 'aktif'
            ],
            [
                'kategori_galeri_id' => $kategoriFasilitas->id,
                'judul' => 'Laboratorium IPA',
                'deskripsi' => 'Laboratorium IPA lengkap dengan peralatan praktikum terbaru',
                'tipe' => 'foto',
                'file_path' => 'lab-ipa.jpg',
                'tanggal_foto' => '2024-07-15',
                'fotografer' => 'Siti Aminah',
                'urutan' => 4,
                'status' => 'aktif'
            ]
        ];

        // Buat sample gambar untuk galeri foto
        $this->createSampleImages($galeri);

        // Simpan data galeri ke database
        foreach ($galeri as $item) {
            Galeri::create($item);
        }

        echo "Berhasil membuat " . count($galeri) . " item galeri sample\n";
    }

    /**
     * Buat direktori yang diperlukan jika belum ada
     */
    private function createDirectories(): void
    {
        $paths = [
            public_path('img/galeri'),
            public_path('img/galeri/kategori')
        ];

        foreach ($paths as $path) {
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
                echo "Direktori {$path} berhasil dibuat\n";
            }
        }
    }

    /**
     * Buat sample gambar untuk galeri foto
     */
    private function createSampleImages(array $galeri): void
    {
        // Buat sample gambar untuk item galeri dengan tipe foto
        foreach ($galeri as $item) {
            if ($item['tipe'] === 'foto' && !empty($item['file_path'])) {
                $imagePath = public_path('img/galeri/' . $item['file_path']);
                
                // Jika file belum ada, buat file gambar sample
                if (!File::exists($imagePath)) {
                    // Buat gambar sample dengan text judul galeri
                    $this->createSampleImage($imagePath, $item['judul']);
                    echo "Sample image created: {$item['file_path']}\n";
                }
            }
        }
    }

    /**
     * Buat gambar sample dengan text
     */
    private function createSampleImage(string $path, string $text): void
    {
        // Buat gambar sample dengan ukuran 800x600
        $width = 800;
        $height = 600;
        $image = imagecreatetruecolor($width, $height);

        // Warna background dan text
        $bgColor = imagecolorallocate($image, rand(0, 100), rand(0, 100), rand(100, 200));
        $textColor = imagecolorallocate($image, 255, 255, 255);

        // Isi background
        imagefill($image, 0, 0, $bgColor);

        // Tambahkan text
        $fontSize = 5;
        $text = wordwrap($text, 30, "\n");
        $lines = explode("\n", $text);
        $lineHeight = imagefontheight($fontSize) + 5;
        $totalHeight = count($lines) * $lineHeight;
        $startY = ($height - $totalHeight) / 2;

        foreach ($lines as $i => $line) {
            $textWidth = imagefontwidth($fontSize) * strlen($line);
            $x = ($width - $textWidth) / 2;
            $y = $startY + ($i * $lineHeight);
            imagestring($image, $fontSize, $x, $y, $line, $textColor);
        }

        // Tambahkan text "Sample Image"
        $sampleText = "Sample Image - SMPN 20";
        $sampleTextWidth = imagefontwidth($fontSize) * strlen($sampleText);
        $sampleX = ($width - $sampleTextWidth) / 2;
        $sampleY = $height - 30;
        imagestring($image, $fontSize, $sampleX, $sampleY, $sampleText, $textColor);

        // Simpan gambar
        imagejpeg($image, $path, 90);
        imagedestroy($image);
    }
}
