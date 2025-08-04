<?php

namespace App\Helper;

use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Kabupaten;
use App\Models\Provinsi;

class LokasiHelper 
{
    public static function getProvinsi()
    {
        $provinsis = Provinsi::orderBy('nama', 'asc')->get();
        return ['data' => $provinsis];
    }

   
    public static function getKota($provinsiKode)
    {
        // Ganti panggilan API dengan query Eloquent ke tabel 'kabupatens'
        $kabupatens = Kabupaten::where('kode_provinsi', $provinsiKode)
                               ->orderBy('nama', 'asc')
                               ->get();

        return ['data' => $kabupatens];
    }

    public static function getKecamatan($kabupatenKode)
    {
        // Ganti panggilan API dengan query Eloquent ke tabel 'kecamatans'
        $kecamatans = Kecamatan::where('kode_kabupaten', $kabupatenKode)
                               ->orderBy('nama', 'asc')
                               ->get();
        
        return ['data' => $kecamatans];
    }

    public static function getKelurahan($kecamatanKode)
    {
        // Ganti panggilan API dengan query Eloquent ke tabel 'kelurahans'
        $kelurahans = Kelurahan::where('kode_kecamatan', $kecamatanKode)
                               ->orderBy('nama', 'asc')
                               ->get();

        return ['data' => $kelurahans];
    }

}