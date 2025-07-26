<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KeanggotaanKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $siswas = User::where('role_id', 3)->get();
        $kelases = Kelas::all();

        foreach ($siswas as $siswa) {
            $kelasUntukSiswa = $kelases->random(rand(3, 5));
            foreach ($kelasUntukSiswa as $kelas) {
                DB::table('keanggotaan_kelas')->insert([
                    'kelas_id' => $kelas->id,
                    'siswa_id' => $siswa->id,
                    'tanggal_pendaftaran' => now()->subDays(rand(10, 30)),
                ]);
            }
        }
    }
}
