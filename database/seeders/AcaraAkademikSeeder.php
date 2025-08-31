<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AcaraAkademik;
use App\Models\TahunAjaran;
use Carbon\Carbon;

class AcaraAkademikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil tahun ajaran aktif
        $tahunAjaran = TahunAjaran::where('status', 'aktif')->first();
        
        if (!$tahunAjaran) {
            $this->command->info('Tidak ada tahun ajaran aktif. Silakan jalankan TahunAjaranSeeder terlebih dahulu.');
            return;
        }
        
        $tanggalMulai = Carbon::parse($tahunAjaran->tanggal_mulai);
        $tanggalSelesai = Carbon::parse($tahunAjaran->tanggal_selesai);
        
        // Acara akademik untuk tahun ajaran aktif
        $acaraAkademik = [
            // Ujian
            [
                'judul' => 'Ujian Tengah Semester Ganjil',
                'deskripsi' => 'Ujian tengah semester untuk semester ganjil',
                'tanggal_mulai' => $tanggalMulai->copy()->addMonths(2),
                'tanggal_selesai' => $tanggalMulai->copy()->addMonths(2)->addDays(5),
                'sepanjang_hari' => true,
                'warna_latar' => '#FF9800',
                'warna_teks' => '#FFFFFF',
                'tipe' => 'ujian',
            ],
            [
                'judul' => 'Ujian Akhir Semester Ganjil',
                'deskripsi' => 'Ujian akhir semester untuk semester ganjil',
                'tanggal_mulai' => $tanggalMulai->copy()->addMonths(5)->subDays(10),
                'tanggal_selesai' => $tanggalMulai->copy()->addMonths(5)->subDays(5),
                'sepanjang_hari' => true,
                'warna_latar' => '#FF9800',
                'warna_teks' => '#FFFFFF',
                'tipe' => 'ujian',
            ],
            [
                'judul' => 'Ujian Tengah Semester Genap',
                'deskripsi' => 'Ujian tengah semester untuk semester genap',
                'tanggal_mulai' => $tanggalMulai->copy()->addMonths(8),
                'tanggal_selesai' => $tanggalMulai->copy()->addMonths(8)->addDays(5),
                'sepanjang_hari' => true,
                'warna_latar' => '#FF9800',
                'warna_teks' => '#FFFFFF',
                'tipe' => 'ujian',
            ],
            [
                'judul' => 'Ujian Akhir Semester Genap',
                'deskripsi' => 'Ujian akhir semester untuk semester genap',
                'tanggal_mulai' => $tanggalSelesai->copy()->subDays(15),
                'tanggal_selesai' => $tanggalSelesai->copy()->subDays(10),
                'sepanjang_hari' => true,
                'warna_latar' => '#FF9800',
                'warna_teks' => '#FFFFFF',
                'tipe' => 'ujian',
            ],
            
            // Libur
            [
                'judul' => 'Libur Semester Ganjil',
                'deskripsi' => 'Libur akhir semester ganjil',
                'tanggal_mulai' => $tanggalMulai->copy()->addMonths(5),
                'tanggal_selesai' => $tanggalMulai->copy()->addMonths(6)->subDays(1),
                'sepanjang_hari' => true,
                'warna_latar' => '#F44336',
                'warna_teks' => '#FFFFFF',
                'tipe' => 'libur',
            ],
            
            // Kegiatan
            [
                'judul' => 'Upacara Bendera Hari Kemerdekaan',
                'deskripsi' => 'Upacara bendera memperingati hari kemerdekaan',
                'tanggal_mulai' => Carbon::create(Carbon::now()->year, 8, 17),
                'tanggal_selesai' => Carbon::create(Carbon::now()->year, 8, 17),
                'sepanjang_hari' => true,
                'warna_latar' => '#4CAF50',
                'warna_teks' => '#FFFFFF',
                'tipe' => 'kegiatan',
            ],
            [
                'judul' => 'Rapat Guru',
                'deskripsi' => 'Rapat evaluasi kinerja guru',
                'tanggal_mulai' => Carbon::now()->addDays(7),
                'tanggal_selesai' => Carbon::now()->addDays(7),
                'sepanjang_hari' => false,
                'warna_latar' => '#2196F3',
                'warna_teks' => '#FFFFFF',
                'tipe' => 'rapat',
            ],
            [
                'judul' => 'Workshop Pengembangan Kurikulum',
                'deskripsi' => 'Workshop untuk pengembangan kurikulum sekolah',
                'tanggal_mulai' => Carbon::now()->addDays(14),
                'tanggal_selesai' => Carbon::now()->addDays(15),
                'sepanjang_hari' => true,
                'warna_latar' => '#9C27B0',
                'warna_teks' => '#FFFFFF',
                'tipe' => 'workshop',
            ],
        ];
        
        foreach ($acaraAkademik as $acara) {
            AcaraAkademik::create([
                'judul' => $acara['judul'],
                'deskripsi' => $acara['deskripsi'],
                'tanggal_mulai' => $acara['tanggal_mulai'],
                'tanggal_selesai' => $acara['tanggal_selesai'],
                'sepanjang_hari' => $acara['sepanjang_hari'],
                'warna_latar' => $acara['warna_latar'],
                'warna_teks' => $acara['warna_teks'],
                'tahun_ajaran_id' => $tahunAjaran->id,
                'tipe' => $acara['tipe'],
            ]);
        }
        
        $this->command->info('Data acara akademik berhasil dibuat!');
    }
}