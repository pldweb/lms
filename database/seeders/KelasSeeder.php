<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guruIds = User::where('role_id', 2)->pluck('id');
        $mapel = ['Matematika', 'Fisika', 'Biologi', 'Kimia', 'Bahasa Indonesia', 'Bahasa Inggris', 'Sejarah'];
        $jenjang = ['10', '11', '12'];

        for ($i=0; $i < 15; $i++) { 
            Kelas::create([
                'guru_id' => $guruIds->random(),
                'nama_kelas' => $mapel[array_rand($mapel)] . ' ' . $jenjang[array_rand($jenjang)] . '-' . fake()->randomLetter(),
                'kode_kelas' => 'KLS-' . fake()->unique()->numerify('#####'),
                'deskripsi' => fake()->paragraph(),
                'jenjang' => $jenjang[array_rand($jenjang)],
                'tahun_ajaran' => '2025/2026',
                'semester' => fake()->numberBetween(1, 2),
            ]);
        }
    }
}
