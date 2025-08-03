<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;    
use App\Helper\LokasiHelper;

class ProfileController extends Controller
{

    public function getIndex()
    {
        $provinsi = LokasiHelper::getProvinsi();
        $provinsi = $provinsi['data'];

        $params = ['provinsi' => $provinsi];
        return view('admin.profile.index', $params);
    }

    public function getDailyAktivitas()
    {
        return view('admin.profile.daily-aktivitas');
    }

    
}
