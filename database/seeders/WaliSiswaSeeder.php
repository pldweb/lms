<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class WaliSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wali = User::where('role_id', 4)->pluck('id');
        $siswa = User::where('role_id', 3)->pluck('id');

        foreach ($siswa as $siswa_id) {
            DB::table('wali_siswa')->insert([
                'wali_id' => $wali->random(),
                'siswa_id' => $siswa_id,
            ]);
        }
    }
}
