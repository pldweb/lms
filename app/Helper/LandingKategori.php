<?php

namespace App\Helper;

class LandingKategori
{
    public static function setLandingKategori(){
        $data = [
            [
                'title' => 'Program Sekolah',
                'subtitle' => 'Kegiatan unggulan & pengembangan karakter',
                'icon' => 'fas fa-chalkboard-teacher',
                'image' => asset('landing/img/berita-2.png'),
                'link'  => url('program-sekolah'), 
            ],
            [
                'title' => 'Prestasi Sekolah',
                'subtitle' => 'Akademik & non-akademik tingkat kota hingga nasional',
                'icon' => 'fas fa-trophy',
                'image' => asset('landing/img/berita-3.png'),
                'link'  => url('prestasi-sekolah'),
            ],
            [
                'title' => 'Sejarah Sekolah',
                'subtitle' => 'Perjalanan panjang SMPN 20 Jakarta',
                'icon' => 'fas fa-history',
                'image' => asset('landing/img/berita-1.png'),
                'link'  => url('sejarah-sekolah'),
            ],
            [
                'title' => 'Media Sosial',
                'subtitle' => '@smpn20jakarta (IG, FB, YouTube)',
                'icon' => 'fas fa-share-alt',
                'image' => asset('landing/img/berita-2.png'),
                'link'  => 'https://instagram.com/smpn20jakarta',
            ],
        ];
        return $data;
    }
}