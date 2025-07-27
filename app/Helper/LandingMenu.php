<?php

namespace App\Helper;

class LandingMenu 
{

    public static function setContactMenu(){
        return [
            [
                'icon' => 'fas fa-phone-alt',
                'text' => '021 8002033',
                'link' => '+440076897888',
            ],
            [
                'icon' => 'fas fa-envelope',
                'text' => 'smpn20jakarta@gmail.com',
                'link' => 'mailto:smpn20jakarta@gmail.com',
            ],
        ];
    }

    public static function setLandingMenu(){
    $menu = [
        [
            'title' => 'Home',
            'url' => '#',
        ],
        [
            'title' => 'Berita',
            'url' => '#',
            'children' => [
                ['title' => 'Pemindahan/Mutasi', 'url' => 'course.html'],
                ['title' => 'Pengumuman', 'url' => 'courses-2.html'],
                ['title' => 'Ekskul', 'url' => 'courses-2.html'],
                ['title' => 'SPMB 2025', 'url' => 'courses-2.html'],
                ['title' => 'Olahraga', 'url' => 'courses-2.html'],
            ],
        ],
        [
            'title' => 'Galeri',
            'url' => '#',
            'children' => [
                ['title' => 'Album Foto', 'url' => 'course.html'],
                ['title' => 'Koleksi Video', 'url' => 'courses-2.html'],
            ],
        ],
        [
            'title' => 'PPID',
            'url' => '#',
            'children' => [
                ['title' => 'PPID SMPN 20 Jakarta', 'url' => 'academic.html'],
            ],
        ],
        [
            'title' => 'Perpustakaan',
            'url' => '#',
            'children' => [
                ['title' => 'Administrasi', 'url' => 'academic.html'],
                ['title' => 'Aktivitas', 'url' => 'academic.html'],
                ['title' => 'Klinik', 'url' => 'academic.html'],
                ['title' => 'Studi Club', 'url' => 'academic.html'],

            ],
        ],
        [
            'title' => 'Lainnya',
            'url' => '#',
            'children' => [
                ['title' => 'Administrasi', 'url' => 'academic.html'],
                ['title' => 'Aktivitas', 'url' => 'academic.html'],
                ['title' => 'Klinik', 'url' => 'academic.html'],
                ['title' => 'Studi Club', 'url' => 'academic.html'],

            ],
        ],
    ];
        return $menu;
    }
}