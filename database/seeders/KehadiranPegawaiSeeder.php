<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\KehadiranPegawai;
use Carbon\Carbon;

class KehadiranPegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua guru
        $guru = User::whereHas('roles', function($query) {
            $query->where('name', 'Guru');
        })->get();
        
        if ($guru->isEmpty()) {
            $this->command->info('Tidak ada guru yang ditemukan. Silakan jalankan UserSeeder terlebih dahulu.');
            return;
        }
        
        // Buat data kehadiran untuk 14 hari terakhir
        $tanggalMulai = Carbon::now()->subDays(13);
        $tanggalSelesai = Carbon::now();
        
        $statusKehadiran = ['hadir', 'izin', 'sakit', 'tanpa_keterangan'];
        $probabilitas = [70, 10, 15, 5]; // Probabilitas untuk masing-masing status dalam persen
        
        $tanggal = Carbon::parse($tanggalMulai);
        
        while ($tanggal->lte($tanggalSelesai)) {
            // Lewati hari Sabtu dan Minggu
            if ($tanggal->isWeekend()) {
                $tanggal->addDay();
                continue;
            }
            
            foreach ($guru as $pegawai) {
                // Tentukan status kehadiran berdasarkan probabilitas
                $rand = mt_rand(1, 100);
                $status = 'hadir';
                
                $cumulativeProbability = 0;
                for ($i = 0; $i < count($statusKehadiran); $i++) {
                    $cumulativeProbability += $probabilitas[$i];
                    if ($rand <= $cumulativeProbability) {
                        $status = $statusKehadiran[$i];
                        break;
                    }
                }
                
                // Tentukan jam masuk dan keluar
                $jamMasuk = null;
                $jamKeluar = null;
                
                if ($status === 'hadir') {
                    // Jam masuk antara 07:00 - 08:00
                    $jamMasuk = Carbon::parse($tanggal->format('Y-m-d') . ' 07:' . str_pad(mt_rand(0, 59), 2, '0', STR_PAD_LEFT) . ':00');
                    
                    // Jam keluar antara 15:00 - 16:00
                    $jamKeluar = Carbon::parse($tanggal->format('Y-m-d') . ' 15:' . str_pad(mt_rand(0, 59), 2, '0', STR_PAD_LEFT) . ':00');
                }
                
                // Buat keterangan
                $keterangan = null;
                if ($status === 'izin') {
                    $alasanIzin = ['Urusan keluarga', 'Acara penting', 'Keperluan pribadi', 'Izin khusus'];
                    $keterangan = $alasanIzin[array_rand($alasanIzin)];
                } elseif ($status === 'sakit') {
                    $alasanSakit = ['Demam', 'Flu', 'Sakit kepala', 'Sakit perut', 'Tidak enak badan'];
                    $keterangan = $alasanSakit[array_rand($alasanSakit)];
                }
                
                // Simpan data kehadiran
                KehadiranPegawai::create([
                    'pegawai_id' => $pegawai->id,
                    'tanggal' => $tanggal->format('Y-m-d'),
                    'status' => $status,
                    'jam_masuk' => $jamMasuk,
                    'jam_keluar' => $jamKeluar,
                    'keterangan' => $keterangan,
                ]);
            }
            
            $tanggal->addDay();
        }
        
        $this->command->info('Data kehadiran pegawai berhasil dibuat!');
    }
}