<?php

namespace App\Http\Controllers;

use App\Helper\MenuNavbarHelper;
use App\Helper\TimHelper;
use App\Models\Artikel;
use App\Models\KategoriGaleri;
use App\Models\Galeri;
use App\Models\Kontak;
use App\Models\SocialMedia;
use App\Models\Slideshow;
use App\Models\Halaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\admin\SlideshowController;
use App\Http\Controllers\admin\KontakController;
use App\Http\Controllers\admin\SocialMediaController;


class HomeController extends Controller
{
    private function heroSection(){
        $slideshow = Slideshow::aktif()
            ->urutan()
            ->get()
            ->toArray();
            
        if (empty($slideshow)) {
            $slideshow = SlideshowController::getSlideshow();
        }
        
        return $slideshow;
    }
    
    private function kontakSection(){
        $kontak = Kontak::aktif()->urutan()->get()->toArray();
            
        if (empty($kontak)) {
            $kontak = KontakController::getKontak();
        }
        
        return $kontak;
    }
    
    private function socialMediaSection(){
        $socialMedia = SocialMedia::aktif()->urutan()->get()->toArray();
            
        if (empty($socialMedia)) {
            $socialMedia = SocialMediaController::getSocialMedia();
        }
        
        return $socialMedia;
    }

    public function getIndex(){
        $beritaTerbaru = Artikel::berita()
            ->published()
            ->latest('tanggal_publish')
            ->take(3)
            ->get();

        $pengumumanTerbaru = Artikel::pengumuman()
            ->published()
            ->latest('tanggal_publish')
            ->take(3)
            ->get();

        $galeriTerbaru = Galeri::aktif()
            ->with('kategori')
            ->latest()
            ->take(6)
            ->get();
            
        // Ambil data guru dan pegawai
        $guruPegawai = \App\Models\User::role(['Guru'])
            ->select('id', 'nama', 'foto_profile')
            ->take(4)
            ->get();

        $params = [
            'title' => 'Selamat Datang di SMP 20 Jakarta',
            'heroSection' => self::heroSection(),
            'beritaTerbaru' => $beritaTerbaru,
            'pengumumanTerbaru' => $pengumumanTerbaru,
            'galeriTerbaru' => $galeriTerbaru,
            'guruPegawai' => $guruPegawai,
            'kontak' => self::kontakSection(),
            'socialMedia' => self::socialMediaSection()
        ];
        return view('landing.index', $params);
    }

    public function getBerita(){
        $berita = Artikel::berita()
            ->published()
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
            ->published()
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
        $artikel = Artikel::published()->with('penulis')->findOrFail($id);
        
        $artikel->increment('views');

        $artikelTerkait = Artikel::where('jenis', $artikel->jenis)
            ->where('id', '!=', $artikel->id)
            ->published()
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

    public function getGaleri()
    {
        $kategori = KategoriGaleri::aktif()
            ->withCount(['galeriAktif'])
            ->orderBy('urutan')
            ->get();

        $galeriTerbaru = Galeri::aktif()
            ->with('kategori')
            ->latest()
            ->take(6)
            ->get();

        $params = [
            'title' => 'Galeri Sekolah',
            'kategori' => $kategori,
            'galeriTerbaru' => $galeriTerbaru
        ];
        return view('landing.galeri', $params);
    }
    
    public function getGuruPegawai()
    {
        $guruPegawai = \App\Models\User::role(['Guru'])
            ->select('id', 'nama', 'foto_profile')
            ->paginate(12);
            
        $params = [
            'title' => 'Guru dan Pegawai',
            'guruPegawai' => $guruPegawai
        ];
        return view('landing.guru-pegawai', $params);
    }

    public function getGaleriKategori($slug)
    {
        $kategori = KategoriGaleri::where('slug', $slug)->aktif()->firstOrFail();
        
        $galeri = Galeri::where('kategori_galeri_id', $kategori->id)
            ->aktif()
            ->orderBy('urutan')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $params = [
            'title' => $kategori->nama_kategori,
            'kategori' => $kategori,
            'galeri' => $galeri
        ];
        return view('landing.galeri-kategori', $params);
    }

    public function getGaleriDetail($id)
    {
        $galeri = Galeri::aktif()->with('kategori')->findOrFail($id);
        $galeriTerkait = Galeri::where('kategori_galeri_id', $galeri->kategori_galeri_id)
            ->where('id', '!=', $galeri->id)
            ->aktif()
            ->latest()
            ->take(6)
            ->get();

        $params = [
            'title' => $galeri->judul,
            'galeri' => $galeri,
            'galeriTerkait' => $galeriTerkait
        ];
        return view('landing.galeri-detail', $params);
    }

    public function getHalaman($slug){
        $halaman = Halaman::where('slug', $slug)->published()->firstOrFail();
        $params = [
            'title' => $halaman->judul,
            'halaman' => $halaman
        ];
        return view('landing.halaman', $params);
    }

}
