<?php

namespace App\Http\Controllers;

use App\Helper\MenuNavbarHelper;
use App\Helper\TimHelper;
use App\Models\Artikel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private function heroSection(){
        $data = [
            [
                'image' => asset('landing/img/hero/hero-1.png'),
                'title' => 'Selamat Datang di Website Resmi',
                'deskripsi' => '"Membangun Generasi Cerdas, Berkarakter, dan Siap Masa Depan"',
                'link' => 'https://google.com',
                'tombol_text' => 'Segera Hubungi'
           ],
           [
                'image' => asset('landing/img/hero/hero-2.png'),
                'title' => 'Ini Judul Hero',
                'deskripsi' => 'Ini Dekripsi',
                'link' => 'https://google.com',
                 'tombol_text' => 'Segera Hubungi'
           ],
           [
                'image' => asset('landing/img/hero/hero-3.png'),
                'title' => 'Ini Judul Hero',
                'deskripsi' => 'Ini Dekripsi',
                'link' => 'https://google.com',
                 'tombol_text' => 'Segera Hubungi'
           ],
           [
                'image' => asset('landing/img/hero/hero-4.png'),
                'title' => 'Ini Judul Hero',
                'deskripsi' => 'Ini Dekripsi',
                'link' => 'https://google.com',
                 'tombol_text' => 'Segera Hubungi'
           ]
        ];
        return $data;
    }

    public function getIndex(){

        $params = [
            'title' => 'Selamat Datang di SMP 20 Jakarta',
            'heroSection' => self::heroSection()
        ];
        return view('landing.index', $params);
    }

    public function getLogin(){
        $params = ['' => ''];
        return view('landing.auth.login');
    }

    public function getRegister(){
        $params = ['' => ''];
        return view('landing.auth.register');
    }

    public function getResetPassword(){
        $params = ['' => ''];
        return view('landing.auth.reset-password');
    }
}
