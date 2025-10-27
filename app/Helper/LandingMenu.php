<?php

namespace App\Helper;

use App\Models\InformasiSekolah;
use App\Models\Menu;

class LandingMenu
{
    public static function setContactMenu(){

        $informasiSekolah = InformasiSekolah::first();

        return [
            [
                'icon' => 'fas fa-phone-alt',
                'text' => $informasiSekolah->nomor_telepon ?? '',
                'link' => "tel:$informasiSekolah->nomor_telepon" ?? '',
            ],
            [
                'icon' => 'fas fa-envelope',
                'text' => $informasiSekolah->email ?? '',
                'link' => "mailto:$informasiSekolah->email" ?? '',
            ],
        ];
    }

    public static function setLandingMenu(){
        // Coba ambil dari database
        $menuItems = Menu::whereNull('parent_id')
            ->where('active', true)
            ->orderBy('order')
            ->with(['children' => function($query) {
                $query->where('active', true)->orderBy('order');
            }])
            ->get();

        // Jika ada data di database, gunakan itu
        if ($menuItems->count() > 0) {
            $menu = [];
            foreach ($menuItems as $item) {
                $menuItem = [
                    'title' => $item->title,
                    'url' => $item->url,
                ];

                // Tambahkan icon jika ada
                if ($item->icon) {
                    $menuItem['icon'] = $item->icon;
                }

                // Tambahkan children jika ada
                if ($item->children->count() > 0) {
                    $menuItem['children'] = [];
                    foreach ($item->children as $child) {
                        $childItem = [
                            'title' => $child->title,
                            'url' => $child->url,
                        ];

                        // Tambahkan icon jika ada
                        if ($child->icon) {
                            $childItem['icon'] = $child->icon;
                        }

                        $menuItem['children'][] = $childItem;
                    }
                }

                $menu[] = $menuItem;
            }
            return $menu;
        }

        // Fallback ke menu statis jika database kosong
        $menu = [
            [
                'title' => 'Home',
                'url' => url('/'),
            ],
            [
                'title' => 'Profil',
                'url' => '#',
                'children' => [
                    ['title' => 'Sejarah Sekolah', 'url' => url('/sejarah-sekolah')],
                    ['title' => 'Program Sekolah', 'url' => url('/program-sekolah')],
                    ['title' => 'Prestasi Sekolah', 'url' => url('/prestasi-sekolah')],
                ],
            ],
            [
                'title' => 'Informasi',
                'url' => '#',
                'children' => [
                    ['title' => 'Berita Sekolah', 'url' => url('/berita')],
                    ['title' => 'Pengumuman', 'url' => url('/pengumuman')],
                ],
            ],
            [
                'title' => 'Galeri',
                'url' => url('/galeri'),
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
