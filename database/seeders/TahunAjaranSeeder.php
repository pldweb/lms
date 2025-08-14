<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TahunAjaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tahunAjaranData = [
            [
                'nama' => '2023/2024',
                'tanggal_mulai' => '2023-07-01',
                'tanggal_selesai' => '2024-06-30',
                'status' => 'non-aktif',
                'keterangan' => 'Tahun ajaran sebelumnya',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => '2025/2026',
                'tanggal_mulai' => '2025-07-01',
                'tanggal_selesai' => '2026-06-30',
                'status' => 'non-aktif',
                'keterangan' => 'Tahun ajaran mendatang',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        // Gunakan query builder langsung
        foreach ($tahunAjaranData as $data) {
            DB::table('tahun_ajaran')->insert($data);
        }
    }
}
