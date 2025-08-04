<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DailyAktivitasController extends Controller
{
    public function getIndex()
    {
        return view('admin.daily-aktivitas.index');
    }
}
