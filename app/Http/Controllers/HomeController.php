<?php

namespace App\Http\Controllers;

use App\Helper\MenuNavbarHelper;
use App\Helper\TimHelper;
use App\Models\Artikel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private function heroSection(){
        $data = [
            [
                'image' => asset('landing/img/hero/hero-1.png'),
                'title' => 'Selamat Datang di Website Resmi SMPN 20 Jakarta',
                'deskripsi' => '"Membangun Generasi Cerdas, Berkarakter, dan Siap Masa Depan"',
                'link' => 'https://google.com',
                'tombol_text' => 'Segera Hubungi'
           ],
           [
                'image' => asset('landing/img/hero/hero-2.png'),
                'title' => 'Ini Judul Hero',
                'deskripsi' => 'Ini Dekripsi',
                'link' => 'https://google.com',
                 'tombol_text' => 'Segera Hubungi'
           ],
           [
                'image' => asset('landing/img/hero/hero-3.png'),
                'title' => 'Ini Judul Hero',
                'deskripsi' => 'Ini Dekripsi',
                'link' => 'https://google.com',
                 'tombol_text' => 'Segera Hubungi'
           ],
           [
                'image' => asset('landing/img/hero/hero-4.png'),
                'title' => 'Ini Judul Hero',
                'deskripsi' => 'Ini Dekripsi',
                'link' => 'https://google.com',
                 'tombol_text' => 'Segera Hubungi'
           ]
        ];
        return $data;
    }

    public function getIndex(){
        // Ambil artikel terbaru untuk ditampilkan di landing page
        $beritaTerbaru = Artikel::berita()
            ->publish()
            ->latest('tanggal_publish')
            ->take(3)
            ->get();

        $pengumumanTerbaru = Artikel::pengumuman()
            ->publish()
            ->latest('tanggal_publish')
            ->take(3)
            ->get();

        $params = [
            'title' => 'Selamat Datang di SMP 20 Jakarta',
            'heroSection' => self::heroSection(),
            'beritaTerbaru' => $beritaTerbaru,
            'pengumumanTerbaru' => $pengumumanTerbaru
        ];
        return view('landing.index', $params);
    }

    public function getBerita(){
        $berita = Artikel::berita()
            ->publish()
            ->with('penulis')
            ->latest('tanggal_publish')
            ->paginate(9);

        $params = [
            'title' => 'Berita Sekolah',
            'berita' => $berita
        ];
        return view('landing.berita', $params);
    }

    public function getPengumuman(){
        $pengumuman = Artikel::pengumuman()
            ->publish()
            ->with('penulis')
            ->latest('tanggal_publish')
            ->paginate(9);

        $params = [
            'title' => 'Pengumuman Sekolah',
            'pengumuman' => $pengumuman
        ];
        return view('landing.pengumuman', $params);
    }

    public function getArtikel($id){
        $artikel = Artikel::publish()->with('penulis')->findOrFail($id);
        
        // Increment views
        $artikel->increment('views');

        // Ambil artikel terkait berdasarkan jenis yang sama
        $artikelTerkait = Artikel::where('jenis', $artikel->jenis)
            ->where('id', '!=', $artikel->id)
            ->publish()
            ->latest('tanggal_publish')
            ->take(3)
            ->get();

        $params = [
            'title' => $artikel->judul,
            'artikel' => $artikel,
            'artikelTerkait' => $artikelTerkait
        ];
        return view('landing.artikel-detail', $params);
    }

}
