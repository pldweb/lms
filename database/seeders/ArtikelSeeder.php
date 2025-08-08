<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Artikel;
use App\Models\User;

class ArtikelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user pertama sebagai penulis (biasanya admin)
        $penulis = User::first();
        
        if (!$penulis) {
            $this->command->info('Tidak ada user yang ditemukan. Silakan buat user terlebih dahulu.');
            return;
        }

        $artikel = [
            [
                'penulis_id' => $penulis->id,
                'jenis' => 'berita',
                'judul' => 'Penerimaan Siswa Baru Tahun Ajaran 2025/2026',
                'ringkasan' => 'Sekolah membuka pendaftaran siswa baru untuk tahun ajaran 2025/2026 dengan berbagai program unggulan.',
                'isi' => 'Dalam rangka menyambut tahun ajaran baru 2025/2026, sekolah kami dengan bangga mengumumkan pembukaan pendaftaran siswa baru. Tahun ini, kami menawarkan berbagai program unggulan yang dirancang untuk mengembangkan potensi siswa secara maksimal.

Program-program yang ditawarkan meliputi:
1. Program Akademik Regular dengan kurikulum terbaru
2. Program Unggulan Sains dan Teknologi
3. Program Bahasa Internasional
4. Program Seni dan Olahraga

Persyaratan pendaftaran:
- Mengisi formulir pendaftaran
- Fotokopi ijazah terakhir
- Pas foto terbaru
- Surat keterangan sehat

Pendaftaran dibuka mulai tanggal 15 Januari 2025 hingga 15 Maret 2025. Informasi lebih lanjut dapat menghubungi bagian administrasi sekolah.',
                'status' => 'publish',
                'tanggal_publish' => now(),
                'views' => 150,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'penulis_id' => $penulis->id,
                'jenis' => 'pengumuman',
                'judul' => 'Jadwal Ujian Tengah Semester Gasal 2024/2025',
                'ringkasan' => 'Pengumuman jadwal pelaksanaan ujian tengah semester gasal untuk seluruh siswa.',
                'isi' => 'Dengan hormat,

Bersama ini kami sampaikan jadwal pelaksanaan Ujian Tengah Semester (UTS) Gasal Tahun Ajaran 2024/2025:

Tanggal Pelaksanaan: 15 Oktober - 25 Oktober 2024
Waktu Pelaksanaan: 07.30 - 10.30 WIB

Jadwal per kelas:
- Kelas X: 15-18 Oktober 2024
- Kelas XI: 19-22 Oktober 2024  
- Kelas XII: 23-25 Oktober 2024

Ketentuan:
1. Siswa wajib hadir 15 menit sebelum ujian dimulai
2. Membawa alat tulis yang diperlukan
3. Dilarang membawa HP dan alat komunikasi lainnya
4. Memakai seragam sekolah lengkap

Demikian pengumuman ini disampaikan untuk diketahui dan dipatuhi.

Terima kasih.',
                'status' => 'publish',
                'tanggal_publish' => now()->subDays(3),
                'views' => 89,
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],
            [
                'penulis_id' => $penulis->id,
                'jenis' => 'berita',
                'judul' => 'Prestasi Siswa dalam Olimpiade Matematika Tingkat Provinsi',
                'ringkasan' => 'Siswa-siswi sekolah berhasil meraih prestasi gemilang dalam Olimpiade Matematika tingkat provinsi.',
                'isi' => 'Kebanggaan tersendiri bagi keluarga besar sekolah kami karena siswa-siswi telah berhasil meraih prestasi gemilang dalam Olimpiade Matematika Tingkat Provinsi yang diselenggarakan pada bulan Oktober 2024.

Prestasi yang diraih:
1. Juara 1: Ahmad Rizki (Kelas XI IPA 1)
2. Juara 2: Siti Nurhaliza (Kelas XI IPA 2)  
3. Juara 3: Budi Santoso (Kelas X IPA 1)

Olimpiade ini diikuti oleh lebih dari 200 siswa dari seluruh sekolah di provinsi. Prestasi ini tentu tidak lepas dari kerja keras siswa, dukungan orang tua, dan bimbingan guru-guru yang berkualitas.

Kepala sekolah menyampaikan apresiasi tinggi atas pencapaian ini dan berharap dapat memotivasi siswa lain untuk terus berprestasi di berbagai bidang.

Selamat kepada para pemenang!',
                'status' => 'publish',
                'tanggal_publish' => now()->subDays(7),
                'views' => 234,
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(7),
            ],
            [
                'penulis_id' => $penulis->id,
                'jenis' => 'pengumuman',
                'judul' => 'Libur Nasional Hari Pahlawan',
                'ringkasan' => 'Pemberitahuan libur sekolah dalam rangka memperingati Hari Pahlawan.',
                'isi' => 'Kepada Yth.
Seluruh siswa, guru, dan karyawan

Dalam rangka memperingati Hari Pahlawan yang jatuh pada tanggal 10 November 2024, maka sekolah DILIBURKAN pada:

Hari/Tanggal: Minggu, 10 November 2024

Kegiatan belajar mengajar akan kembali normal pada hari Senin, 11 November 2024.

Mari kita gunakan momen ini untuk mengenang jasa para pahlawan yang telah berjuang demi kemerdekaan Indonesia.

Demikian pengumuman ini disampaikan.

Terima kasih.',
                'status' => 'draft',
                'tanggal_publish' => null,
                'views' => 0,
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'penulis_id' => $penulis->id,
                'jenis' => 'berita',
                'judul' => 'Kerjasama dengan Universitas Ternama dalam Program Beasiswa',
                'ringkasan' => 'Sekolah menjalin kerjasama strategis dengan universitas ternama untuk memberikan program beasiswa kepada siswa berprestasi.',
                'isi' => 'Sekolah kami dengan bangga mengumumkan kerjasama strategis dengan beberapa universitas ternama di Indonesia dalam program pemberian beasiswa untuk siswa-siswi berprestasi.

Universitas mitra:
1. Universitas Indonesia (UI)
2. Institut Teknologi Bandung (ITB)
3. Universitas Gadjah Mada (UGM)
4. Institut Teknologi Sepuluh Nopember (ITS)

Program beasiswa yang ditawarkan:
- Beasiswa penuh untuk 3 siswa terbaik per tahun
- Beasiswa parsial untuk 10 siswa berprestasi
- Program bimbingan khusus untuk persiapan SNBT

Kriteria penerima beasiswa:
1. Ranking 10 besar di kelasnya
2. Aktif dalam kegiatan ekstrakurikuler
3. Memiliki prestasi akademik atau non-akademik
4. Lulus seleksi wawancara

Pendaftaran program ini akan dibuka pada bulan Januari 2025. Informasi lengkap akan disampaikan melalui wali kelas masing-masing.

Ini merupakan kesempatan emas bagi siswa-siswi untuk melanjutkan pendidikan ke jenjang yang lebih tinggi.',
                'status' => 'draft',
                'tanggal_publish' => null,
                'views' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($artikel as $data) {
            Artikel::create($data);
        }

        $this->command->info('Berhasil membuat 5 artikel sample (3 berita, 2 pengumuman)');
    }
}
