<?php

namespace App\Http\Controllers\landing;

use App\Http\Controllers\Controller;
use App\Models\ProgramSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgramSekolahController extends Controller
{
    public function getIndex()
    {
        $programs = ProgramSekolah::published()
            ->orderBy('tanggal_publish', 'desc')
            ->paginate(10);
            
        return view('landing.program-sekolah', [
            'programs' => $programs,
            'title' => 'Program Sekolah'
        ]);
    }
    
    public function getDetail($slug)
    {
        $program = ProgramSekolah::where('slug', $slug)
            ->published()
            ->firstOrFail();
            
        // Increment view count
        DB::table('program_sekolah')
            ->where('id', $program->id)
            ->increment('views');
            
        return view('landing.program-sekolah-detail', [
            'program' => $program,
            'title' => $program->judul
        ]);
    }
}
