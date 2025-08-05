<?php

namespace App\Helper;

use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;


class AdminSidebar 
{
    public static function setSidebarMenu()
    {
        $user = Auth::user();
        $menu = [];

        if (!$user) {
            return [];
        }

        if ($user->hasRole(['Admin', 'Guru'])) {
            $menu = [
                [
                    'text' => 'Dashboard',
                    'icon' => 'ph ph-squares-four',
                    'link' => 'admin/dashboard',
                ],
                ['type' => 'label', 'text' => 'Manajemen'],
                [
                    'text' => 'Pengguna',
                    'icon' => 'ph ph-users-three',
                    'submenu' => [
                        ['text' => 'Data Admin', 'link' => 'admin/user/admin'],
                        ['text' => 'Data Guru', 'link' => 'admin/user/guru'],
                        ['text' => 'Data Siswa', 'link' => 'admin/user/siswa'],
                        ['text' => 'Data Wali Murid', 'link' => 'admin/user/wali-murid'],
                    ],
                ],
                [
                    'text' => 'Akademik',
                    'icon' => 'ph ph-books',
                    'submenu' => [
                        ['text' => 'Tahun Ajaran', 'link' => 'admin/akademik/tahun-ajaran'],
                        ['text' => 'Mata Pelajaran', 'link' => 'admin/akademik/mapel'],
                        ['text' => 'Daftar Kelas', 'link' => 'admin/akademik/kelas'],
                    ],
                ],
                [
                    'text' => 'Pembelajaran',
                    'icon' => 'ph ph-graduation-cap',
                    'submenu' => [
                        ['text' => 'Jadwal Pelajaran', 'link' => 'admin/pembelajaran/jadwal'],
                        ['text' => 'Keanggotaan Kelas', 'link' => 'admin/pembelajaran/anggota-kelas'],
                    ],
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
                        ['text' => 'Pengumpulan Siswa', 'link' => 'guru/penilaian'],
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
                        ['text' => 'Berita', 'link' => 'guru/tugas'],
                        ['text' => 'Pengumuman', 'link' => 'guru/penilaian'],
                        ['text' => 'Slideshow', 'link' => 'guru/website'],
                        ['text' => 'Kontak', 'link' => 'guru/website'],
                        ['text' => 'Sosial Media', 'link' => 'guru/website'],
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
                    'link' => 'siswa/tugas',
                ],
            ];
        }

        $menu[] = ['type' => 'label', 'text' => 'Akun Saya'];
        $menu[] = [
            'text' => 'Profil Saya',
            'icon' => 'ph ph-user',
            'link' => 'admin/profile'
        ];

        return $menu;
    }
}