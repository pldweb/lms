<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus semua menu yang ada
        Menu::truncate();
        
        // Menu utama
        $home = Menu::create([
            'title' => 'Home',
            'url' => '/',
            'icon' => 'fas fa-home',
            'order' => 1,
            'active' => true,
        ]);
        
        $informasi = Menu::create([
            'title' => 'Informasi',
            'url' => '#',
            'icon' => 'fas fa-info-circle',
            'order' => 2,
            'active' => true,
        ]);
        
        $galeri = Menu::create([
            'title' => 'Galeri',
            'url' => '/galeri',
            'icon' => 'fas fa-images',
            'order' => 3,
            'active' => true,
        ]);
        
        $ppid = Menu::create([
            'title' => 'PPID',
            'url' => '#',
            'icon' => 'fas fa-building',
            'order' => 4,
            'active' => true,
        ]);
        
        $perpustakaan = Menu::create([
            'title' => 'Perpustakaan',
            'url' => '#',
            'icon' => 'fas fa-book',
            'order' => 5,
            'active' => true,
        ]);
        
        // Sub menu untuk Informasi
        Menu::create([
            'title' => 'Berita Sekolah',
            'url' => '/berita',
            'icon' => 'fas fa-newspaper',
            'parent_id' => $informasi->id,
            'order' => 1,
            'active' => true,
        ]);
        
        Menu::create([
            'title' => 'Pengumuman',
            'url' => '/pengumuman',
            'icon' => 'fas fa-bullhorn',
            'parent_id' => $informasi->id,
            'order' => 2,
            'active' => true,
        ]);
        
        // Sub menu untuk PPID
        Menu::create([
            'title' => 'PPID SMPN 20 Jakarta',
            'url' => '/ppid',
            'icon' => 'fas fa-landmark',
            'parent_id' => $ppid->id,
            'order' => 1,
            'active' => true,
        ]);
        
        // Sub menu untuk Perpustakaan
        Menu::create([
            'title' => 'Administrasi',
            'url' => '/perpustakaan/administrasi',
            'icon' => 'fas fa-clipboard-list',
            'parent_id' => $perpustakaan->id,
            'order' => 1,
            'active' => true,
        ]);
        
        Menu::create([
            'title' => 'Aktivitas',
            'url' => '/perpustakaan/aktivitas',
            'icon' => 'fas fa-tasks',
            'parent_id' => $perpustakaan->id,
            'order' => 2,
            'active' => true,
        ]);
        
        Menu::create([
            'title' => 'Klinik',
            'url' => '/perpustakaan/klinik',
            'icon' => 'fas fa-clinic-medical',
            'parent_id' => $perpustakaan->id,
            'order' => 3,
            'active' => true,
        ]);
        
        Menu::create([
            'title' => 'Studi Club',
            'url' => '/perpustakaan/studi-club',
            'icon' => 'fas fa-users',
            'parent_id' => $perpustakaan->id,
            'order' => 4,
            'active' => true,
        ]);
    }
}