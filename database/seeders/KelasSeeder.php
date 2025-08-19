<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $guruIds = User::role('Guru')->pluck('id');
        $tahunAjaran = TahunAjaran::first();
        $mataPelajaranIds = MataPelajaran::pluck('id');
        $jenjangSMP = ['7', '8', '9']; // Sesuai untuk SMP

        for ($i=0; $i < 15; $i++) { 
            $tingkat = $jenjangSMP[array_rand($jenjangSMP)];
            
            Kelas::create([
                'guru_id' => $guruIds->random(),
                'tahun_ajaran_id' => $tahunAjaran ? $tahunAjaran->id : null,
                'mata_pelajaran_id' => $mataPelajaranIds->random(),
                'nama' => 'Kelas ' . $tingkat . fake()->randomLetter(),
                'kode_kelas' => 'KLS-' . fake()->unique()->numerify('#####'),
                'deskripsi' => fake()->paragraph(),
                'jenjang' => 'SMP',
                'tingkat' => (int)$tingkat,
                'semester' => fake()->numberBetween(1, 2),
                'kapasitas_siswa' => 30,
                'status' => 'aktif',
            ]);
        }
    }
}
