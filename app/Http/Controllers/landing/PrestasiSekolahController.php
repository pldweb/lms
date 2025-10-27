<?php

namespace App\Http\Controllers\landing;

use App\Http\Controllers\Controller;
use App\Models\PrestasiSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrestasiSekolahController extends Controller
{
    public function getIndex()
    {
        $prestasis = PrestasiSekolah::published()
            ->orderBy('tanggal_publish', 'desc')
            ->paginate(10);
            
        return view('landing.prestasi-sekolah', [
            'prestasis' => $prestasis,
            'title' => 'Prestasi Sekolah'
        ]);
    }
    
    public function getDetail($slug)
    {
        $prestasi = PrestasiSekolah::where('slug', $slug)
            ->published()
            ->firstOrFail();
            
        // Increment view count
        DB::table('prestasi_sekolah')
            ->where('id', $prestasi->id)
            ->increment('views');
            
        return view('landing.prestasi-sekolah-detail', [
            'prestasi' => $prestasi,
            'title' => $prestasi->judul
        ]);
    }
}
