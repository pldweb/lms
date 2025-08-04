<?php

namespace App\Helper;

class AdminHeader 
{
    public static function setHeaderNotification(){
        return $data = [
                [
                    'user' => 'Ashwin Bose',
                    'message' => 'meminta akses ke file Design - Final Project.',
                    'avatar' => asset('admin/images/thumbs/notification-img1.png'),
                    'file' => 'Design brief and ideas.txt',
                    'icon' => asset('admin/images/icons/google-drive.png'),
                    'size' => '2.2 MB',
                    'time' => '2 menit lalu',
                ],
                [
                    'user' => 'Patrick',
                    'message' => 'menambahkan komentar pada file Design Assets - Smart Tags',
                    'avatar' => asset('admin/images/thumbs/notification-img2.png'),
                    'file' => null,
                    'icon' => null,
                    'size' => null,
                    'time' => '3 menit lalu',
                ],
            ];
    }
    
    public static function setHeaderMenu(){
        $data = [
            [
                'icon' => 'ph ph-gear',
                'text' => 'Pengaturan Akun',
                'url' => '/admin/profile',
                'class' => '',
            ],
            [
                'icon' => 'ph ph-chart-line-up',
                'text' => 'Daily Activity',
                'url' => '/admin/daily-aktivitas',
                'class' => '',
            ],
        ];
    return $data;

    }
}