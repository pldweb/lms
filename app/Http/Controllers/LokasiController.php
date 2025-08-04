<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helper\LokasiHelper;

class LokasiController extends Controller
{
    public function getKota($provinsiId)
    {
        $kota = LokasiHelper::getKota($provinsiId);
        return response()->json($kota['data']);
    }

    public function getKecamatan($kotaId)
    {
        $kecamatan = LokasiHelper::getKecamatan($kotaId);
        return response()->json($kecamatan['data']);
    }

    public function getKelurahan($kecamatanId)
    {
        $desa = LokasiHelper::getKelurahan($kecamatanId);
        return response()->json($desa['data']);
    }
}
