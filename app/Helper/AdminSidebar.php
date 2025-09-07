<?php

namespace App\Helper;

use Illuminate\Support\Facades\Auth;

class AdminSidebar 
{
    public static function setSidebarMenu()
    {
        $user = Auth::user();
        $menu = [];

        if (!$user) {
            return [];
        }

        if ($user->hasAnyRole(['Admin', 'Guru'])) {
            $menu = [
                [
                    'text' => 'Dashboard',
                    'icon' => 'ph ph-squares-four',
                    'link' => 'admin/dashboard/',
                ],
                ['type' => 'label', 'text' => 'Manajemen Pengguna'],
                [
                    'text' => 'Data User',
                    'icon' => 'ph ph-users-three',
                    'submenu' => [
                        ['text' => 'Data Admin', 'link' => 'admin/user/admin/'],
                        ['text' => 'Data Guru', 'link' => 'admin/user/guru/'],
                        ['text' => 'Data Siswa', 'link' => 'admin/user/siswa/'],
                    ],
                ],
                // ['type' => 'label', 'text' => 'Akademik'],
                // [
                //     'text' => 'Kelola Kelas',
                //     'icon' => 'ph ph-graduation-cap',
                //     'link' => 'admin/kelas',
                // ],
                // [
                //     'text' => 'Tahun Ajaran',
                //     'icon' => 'ph ph-graduation-cap',
                //     'link' => 'admin/tahun-ajaran',
                // ],
                // [
                //     'text' => 'Mata Pelajaran',
                //     'icon' => 'ph ph-graduation-cap',
                //     'link' => 'admin/mata-pelajaran',
                // ],
                // ['type' => 'label', 'text' => 'Laporan & Raport'],
                // [
                //     'text' => 'E-Raport',
                //     'icon' => 'ph ph-file-pdf',
                //     'link' => 'admin/e-raport',
                // ],
            ];
        }

        elseif ($user->hasRole('Siswa')) {
            $menu = [
                [
                    'text' => 'Dashboard',
                    'icon' => 'ph ph-squares-four',
                    'link' => 'siswa/dashboard',
                ],
                ['type' => 'label', 'text' => 'Aktivitas Belajar'],
                [
                    'text' => 'Kelas & Materi',
                    'icon' => 'ph ph-books',
                    'link' => 'siswa/kelas',
                ],
                [
                    'text' => 'Tugas & Nilai',
                    'icon' => 'ph ph-clipboard-text',
                    'submenu' => [
                        ['text' => 'Daftar Tugas', 'link' => 'siswa/tugas'],
                        ['text' => 'Daftar Nilai', 'link' => 'siswa/nilai'],
                    ],
                ],
            ];
        }

        if ($user->hasRole('Admin')) {
            $menu[] = ['type' => 'label', 'text' => 'Tentang Sekolah'];
            $menu[] = [
                    'text' => 'Informasi Sekolah',
                    'icon' => 'ph ph-clipboard-text',
                    'link' => 'admin/informasi-sekolah',
                ];
                
            $menu[] = [
                    'text' => 'Artikel',
                    'icon' => 'ph ph-globe',
                    'submenu' => [
                        ['text' => 'Berita', 'link' => 'admin/artikel/berita'],
                        ['text' => 'Pengumuman', 'link' => 'admin/artikel/pengumuman'],
                        ['text' => 'Kategori Artikel', 'link' => 'admin/kategori-artikel'],
                    ],
                ];

                $menu[] = [
                    'text' => 'Galeri',
                    'icon' => 'ph ph-image',
                    'submenu' => [
                        ['text' => 'Galeri', 'link' => 'admin/galeri'],
                        ['text' => 'Kategori Galeri', 'link' => 'admin/galeri/kategori'],
                    ],
                ];

                $menu[] = [
                    'text' => 'Slideshow',
                    'icon' => 'ph ph-image',
                    'link' => 'admin/slideshow',
                ];

                $menu[] = [
                    'text' => 'Kontak',
                    'icon' => 'ph ph-clipboard-text',
                    'link' => 'admin/kontak',
                ];

                $menu[] = [
                    'text' => 'Sosial Media',
                    'icon' => 'ph ph-gear',
                    'link' => 'admin/social-media',
                ];

                $menu[] = [
                    'text' => 'Menu Website',
                    'icon' => 'ph ph-gear',
                    'link' => 'admin/menu',
                ];
            }

        $menu[] = ['type' => 'label', 'text' => 'Pengaturan'];
        $menu[] = [
            'text' => 'Log Aktivitas',
            'icon' => 'ph ph-clock',
            'link' => 'admin/log-aktivitas',
        ];
        return $menu;
    }
}