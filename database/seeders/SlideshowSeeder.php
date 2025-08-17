<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Slideshow;
use Illuminate\Support\Facades\File;

class SlideshowSeeder extends Seeder
{
    
    public function run()
    {
        // Hapus data slideshow yang ada
        Slideshow::truncate();
        
        // Data awal untuk slideshow
        $slideshows = [
            [
                'image' => 'img/hero/hero-1.jpg',
                'title' => 'Selamat Datang di SMP Negeri 20 Jakarta',
                'deskripsi' => 'Mewujudkan Generasi Unggul, Berkarakter, dan Berwawasan Lingkungan',
                'link' => 'tentang-kami',
                'tombol_text' => 'Tentang Kami',
                'urutan' => 1,
                'aktif' => true,
            ],
            [
                'image' => 'img/hero/hero-2.jpg',
                'title' => 'Program Unggulan Sekolah',
                'deskripsi' => 'Mengembangkan Potensi Siswa Melalui Berbagai Program Unggulan',
                'link' => 'program',
                'tombol_text' => 'Lihat Program',
                'urutan' => 2,
                'aktif' => true,
            ],
            [
                'image' => 'img/hero/hero-3.jpg',
                'title' => 'Fasilitas Lengkap',
                'deskripsi' => 'Mendukung Kegiatan Belajar Mengajar dengan Fasilitas Modern',
                'link' => 'fasilitas',
                'tombol_text' => 'Lihat Fasilitas',
                'urutan' => 3,
                'aktif' => true,
            ],
        ];
        
        // Masukkan data ke database
        foreach ($slideshows as $slideshow) {
            Slideshow::create($slideshow);
        }
    }
}