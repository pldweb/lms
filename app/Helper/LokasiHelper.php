<?php

namespace App\Helper;

class LokasiHelper 
{
    public static function getProvinsi()
    {
        $provinsiApi = @file_get_contents('https://api.nusakita.yuefii.site/v2/provinsi?pagination=false');
        if ($provinsiApi === FALSE) {
            return ['data' => []]; 
        }
        $provinsi = json_decode($provinsiApi, true);
        return $provinsi;
    }

    public static function getKota($provinsiId)
    {
        $kotaApi = @file_get_contents("https://api.nusakita.yuefii.site/v2/{$provinsiId}/kab-kota");
        if ($kotaApi === FALSE) {
            return ['data' => []];
        }
        $kota = json_decode($kotaApi, true);
        return $kota;
    }

    public static function getKecamatan($kotaId)
    {
        $kecamatanApi = @file_get_contents("https://api.nusakita.yuefii.site/v2/{$kotaId}/kecamatan");
        if ($kecamatanApi === FALSE) {
            return ['data' => []];
        }
        $kecamatan = json_decode($kecamatanApi, true);
        return $kecamatan;
    }

    public static function getDesa($kecamatanId)
    {
        // Sekarang memanggil method static, ini sudah benar.
        $desaApi = @file_get_contents("https://api.nusakita.yuefii.site/v2/{$kecamatanId}/desa-kel");
        if ($desaApi === FALSE) {
            return ['data' => []];
        }
        $desa = json_decode($desaApi, true);
        return $desa;
    }
}