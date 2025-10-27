<?php

namespace App\Http\Controllers\landing;

use App\Http\Controllers\Controller;
use App\Models\SejarahSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SejarahSekolahController extends Controller
{
    public function getIndex()
    {
        $sejarahs = SejarahSekolah::published()
            ->orderBy('tanggal_publish', 'desc')
            ->paginate(10);
            
        return view('landing.sejarah-sekolah', [
            'sejarahs' => $sejarahs,
            'title' => 'Sejarah Sekolah'
        ]);
    }
    
    public function getDetail($slug)
    {
        $sejarah = SejarahSekolah::where('slug', $slug)
            ->published()
            ->firstOrFail();
            
        // Increment view count
        DB::table('sejarah_sekolah')
            ->where('id', $sejarah->id)
            ->increment('views');
            
        return view('landing.sejarah-sekolah-detail', [
            'sejarah' => $sejarah,
            'title' => $sejarah->judul
        ]);
    }
}
