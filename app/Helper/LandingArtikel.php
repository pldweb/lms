<?php

namespace App\Helper;

class LandingArtikel 
{
    public static function setArtikel(){
        $data = [
            [
                'image' => asset('landing/img/berita-1.png'),
                'title' => 'SMPN 20 Jakarta Gelar Kegiatan Koordinasi Dewan Guru Persiapan Projek P5',
                'description' => "Jakarta, 3 Februari 2025 – SMPN 20 Jakarta menggelar kegiatan koordinasi Dewan Guru dalam rangka persiapan Projek Penguatan Profil Pelajar Pancasila (P5) dengan tema Bhinneka Tunggal Ika. Kegiatan ini berlangsung pada tanggal 3 hingga 7 Februari 2025 dan melibatkan seluruh guru yang mengajar di kelas 7, 8, dan 9.",
                'url' => url('berita/1'),
                'tanggal' => '12',
                'bulan' => 'Juli',
                'tahun' => '2025'
            ],
            [
                'image' => asset('landing/img/berita-2.png'),
                'title' => 'SMPN 20 Jakarta Gelar Kegiatan Koordinasi Dewan Guru Persiapan Projek P5',
                'description' => "Jakarta, 3 Februari 2025 – SMPN 20 Jakarta menggelar kegiatan koordinasi Dewan Guru dalam rangka persiapan Projek Penguatan Profil Pelajar Pancasila (P5) dengan tema Bhinneka Tunggal Ika. Kegiatan ini berlangsung pada tanggal 3 hingga 7 Februari 2025 dan melibatkan seluruh guru yang mengajar di kelas 7, 8, dan 9.",
                'url' => url('berita/1'),
                'tanggal' => '12',
                'bulan' => 'Juli',
                'tahun' => '2025'
            ],
            [
                'image' => asset('landing/img/berita-3.png'),
                'title' => 'SMPN 20 Jakarta Gelar Kegiatan Koordinasi Dewan Guru Persiapan Projek P5',
                'description' => "Jakarta, 3 Februari 2025 – SMPN 20 Jakarta menggelar kegiatan koordinasi Dewan Guru dalam rangka persiapan Projek Penguatan Profil Pelajar Pancasila (P5) dengan tema Bhinneka Tunggal Ika. Kegiatan ini berlangsung pada tanggal 3 hingga 7 Februari 2025 dan melibatkan seluruh guru yang mengajar di kelas 7, 8, dan 9.",
                'url' => url('berita/1'),
                'tanggal' => '12',
                'bulan' => 'Juli',
                'tahun' => '2025'
            ],
        ];
        return $data;
    }

}