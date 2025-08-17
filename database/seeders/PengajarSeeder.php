<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;

class PengajarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua guru
        $gurus = User::role('Guru')->get();
        
        // Ambil semua kelas
        $kelases = Kelas::all();
        
        // Untuk setiap guru, tetapkan beberapa kelas untuk diajar
        foreach ($gurus as $guru) {
            // Pilih beberapa kelas secara acak (2-5 kelas per guru)
            $kelasUntukGuru = $kelases->random(rand(2, 5));
            
            foreach ($kelasUntukGuru as $kelas) {
                // Tambahkan ke tabel pengajar
                DB::table('pengajar')->insert([
                    'guru_id' => $guru->id,
                    'kelas_id' => $kelas->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}