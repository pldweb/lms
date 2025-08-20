<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\LogAktivitas;


class LogAktivitasController extends Controller
{
    public function getIndex()
    {
        $logAktivitas = LogAktivitas::all();
        $params = [
            'logAktivitas' => $logAktivitas
        ];
        return view('admin.log-aktivitas.index', $params);
    }
}
