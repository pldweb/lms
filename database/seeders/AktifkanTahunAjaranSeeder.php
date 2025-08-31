<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AktifkanTahunAjaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tambahkan tahun ajaran aktif (2024/2025)
        $tahunAjaranAktif = [
            'nama' => '2024/2025',
            'tanggal_mulai' => '2024-07-01',
            'tanggal_selesai' => '2025-06-30',
            'status' => 'aktif',
            'keterangan' => 'Tahun ajaran saat ini',
            'created_at' => now(),
            'updated_at' => now()
        ];

        // Pastikan tidak ada tahun ajaran aktif lainnya
        DB::table('tahun_ajaran')->where('status', 'aktif')->update(['status' => 'non-aktif']);
        
        // Masukkan tahun ajaran aktif
        DB::table('tahun_ajaran')->insert($tahunAjaranAktif);
        
        $this->command->info('Tahun ajaran 2024/2025 telah diaktifkan.');
    }
}