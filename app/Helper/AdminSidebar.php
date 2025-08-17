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

        if ($user->hasRole('Admin') || $user->hasRole('Guru')) {
            $menu = [
                [
                    'text' => 'Dashboard',
                    'icon' => 'ph ph-squares-four',
                    'link' => 'admin/dashboard/',
                ],
                ['type' => 'label', 'text' => 'Manajemen'],
                [
                    'text' => 'Pengguna',
                    'icon' => 'ph ph-users-three',
                    'submenu' => [
                        ['text' => 'Data Admin', 'link' => 'admin/user/admin/'],
                        ['text' => 'Data Guru', 'link' => 'admin/user/guru/'],
                        ['text' => 'Data Siswa', 'link' => 'admin/user/siswa/'],
                    ],
                ],
                [
                    'text' => 'Akademik',
                    'icon' => 'ph ph-books',
                    'submenu' => [
                        ['text' => 'Tahun Ajaran', 'link' => 'admin/tahun-ajaran/'],
                        ['text' => 'Mata Pelajaran', 'link' => 'admin/mata-pelajaran/'],
                        ['text' => 'Daftar Kelas', 'link' => 'admin/kelas/'],
                    ],
                ],
                [
                    'text' => 'Pembelajaran',
                    'icon' => 'ph ph-graduation-cap',
                    'submenu' => [
                        ['text' => 'Jadwal Pelajaran', 'link' => 'admin/jadwal-pelajaran/'],
                        ['text' => 'Keanggotaan Kelas', 'link' => 'admin/keanggotaan-kelas/'],
                        ['text' => 'Nilai Siswa', 'link' => 'admin/nilai-siswa/'],
                    ],
                ],
                ['type' => 'label', 'text' => 'Laporan & Raport'],
                [
                    'text' => 'E-Raport',
                    'icon' => 'ph ph-file-pdf',
                    'link' => 'admin/e-raport/',
                ],
                ['type' => 'label', 'text' => 'Aktivitas Mengajar'],
                [
                    'text' => 'Jadwal Kelas',
                    'icon' => 'ph ph-calendar-dots',
                    'link' => 'guru/jadwal',
                ],
                [
                    'text' => 'Materi Pelajaran',
                    'icon' => 'ph ph-bookmarks',
                    'link' => 'guru/materi',
                ],
                [
                    'text' => 'Tugas & Nilai',
                    'icon' => 'ph ph-clipboard-text',
                    'submenu' => [
                        ['text' => 'Daftar Tugas', 'link' => 'guru/tugas'],
                        ['text' => 'Daftar Nilai', 'link' => 'guru/nilai'],
                    ],
                ],
                ['type' => 'label', 'text' => 'Tentang Sekolah'],
                [
                    'text' => 'Informasi Sekolah',
                    'icon' => 'ph ph-clipboard-text',
                    'link' => 'admin/nilai',
                ],
                [
                    'text' => 'Website Sekolah',
                    'icon' => 'ph ph-globe',
                    'submenu' => [
                        ['text' => 'Berita', 'link' => 'admin/artikel/berita'],
                        ['text' => 'Pengumuman', 'link' => 'admin/artikel/pengumuman'],
                        ['text' => "Galeri", 'link' => 'admin/galeri/'],
                        ['text' => "Kategori Galeri", 'link' => 'admin/galeri-kategori/'],
                        ['text' => 'Slideshow', 'link' => 'admin/slideshow/'],
                        ['text' => 'Kontak', 'link' => 'admin/kontak/'],
                        ['text' => 'Sosial Media', 'link' => 'admin/social-media/'],
                    ],
                ],
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

        $menu[] = ['type' => 'label', 'text' => 'Pengaturan'];
        $menu[] = [
            'text' => 'Profil Saya',
            'icon' => 'ph ph-user',
            'link' => 'pengaturan/profile',
        ];
        $menu[] = [
            'text' => 'Log Aktivitas',
            'icon' => 'ph ph-clock',
            'link' => 'pengaturan/log-aktivitas',
        ];
        $menu[] = [
            'text' => 'Aturan Umum',
            'icon' => 'ph ph-gear',
            'link' => 'pengaturan/pengaturan-sistem',
        ];

        return $menu;
    }
}