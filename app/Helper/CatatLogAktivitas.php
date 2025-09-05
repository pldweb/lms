<?php

namespace App\Helper;

use Illuminate\Support\Facades\Auth;
use App\Models\LogAktivitas;

class CatatLogAktivitas
{
    public static function catatAktivitas($aktivitas, $tipe = null)
    {
        $user = Auth::user()->nama;
        try {
            LogAktivitas::create([
                'aktivitas' => $user . ' ' . $aktivitas,
                'waktu' => now(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
                'tipe' => $tipe,
            ]);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}