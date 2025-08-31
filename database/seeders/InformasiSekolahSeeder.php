<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InformasiSekolah;

class InformasiSekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InformasiSekolah::create([
            'nama_sekolah' => 'SMP NEGERI 20 JAKARTA',
            'alamat' => 'Jl. Taman Sari Raya No.25, RT.2/RW.3, Kota Bambu Sel., Kecamatan Palmerah, Kota Jakarta Barat, DKI Jakarta 11420',
            'nomor_telepon' => '(021) 5600422',
            'email' => 'smpn20jakarta@gmail.com',
            'nomor_handphone' => '081234567890',
            'latitude' => '-6.1967222',
            'longitude' => '106.8036111',
            'tagline' => 'Mewujudkan mutu lulusan yang berkarakter, Berprestasi, dan Berkompetitif',
            'logo' => 'Logo-SMPN20.png'
        ]);
    }
}
