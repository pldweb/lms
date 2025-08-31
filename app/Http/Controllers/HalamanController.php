<?php

namespace App\Http\Controllers;

use App\Models\Halaman;
use Illuminate\Http\Request;

class HalamanController extends Controller
{
    public function getDetail($slug)
    {
        $halaman = Halaman::where('slug', $slug)
            ->where('status', 'publish')
            ->firstOrFail();
        
        // Increment view count
        $halaman->increment('views');
        
        $params = [
            'halaman' => $halaman,
        ];
        
        return view('landing.halaman', $params);
    }
}