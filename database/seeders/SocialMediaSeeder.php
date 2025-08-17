<?php

namespace Database\Seeders;

use App\Models\SocialMedia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $socialMediaData = [
            [
                'nama' => 'Facebook',
                'icon' => 'fab fa-facebook-f',
                'link' => 'https://facebook.com/smpn20jakarta',
                'deskripsi' => 'Halaman Facebook resmi SMP Negeri 20 Jakarta',
                'urutan' => 1,
                'aktif' => true
            ],
            [
                'nama' => 'Instagram',
                'icon' => 'fab fa-instagram',
                'link' => 'https://instagram.com/smpn20jakarta',
                'deskripsi' => 'Instagram resmi SMP Negeri 20 Jakarta',
                'urutan' => 2,
                'aktif' => true
            ],
            [
                'nama' => 'YouTube',
                'icon' => 'fab fa-youtube',
                'link' => 'https://youtube.com/@smpn20jakarta',
                'deskripsi' => 'Channel YouTube SMP Negeri 20 Jakarta',
                'urutan' => 3,
                'aktif' => true
            ],
            [
                'nama' => 'Twitter',
                'icon' => 'fab fa-twitter',
                'link' => 'https://twitter.com/smpn20jakarta',
                'deskripsi' => 'Twitter resmi SMP Negeri 20 Jakarta',
                'urutan' => 4,
                'aktif' => true
            ],
            [
                'nama' => 'TikTok',
                'icon' => 'fab fa-tiktok',
                'link' => 'https://tiktok.com/@smpn20jakarta',
                'deskripsi' => 'TikTok resmi SMP Negeri 20 Jakarta',
                'urutan' => 5,
                'aktif' => false
            ]
        ];

        foreach ($socialMediaData as $data) {
            SocialMedia::create($data);
        }
    }
}