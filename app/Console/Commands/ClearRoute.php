<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ClearRoute extends Command
{
    protected $signature = 'app:clear-route';

    protected $description = 'Menghapus cache route dan konfigurasi';

    public function handle()
    {
        $this->info('🚀 Memulai proses clear cache route dan konfigurasi...');

        Artisan::call('route:clear');
        $this->info('✔ Route cache cleared');

        // Hapus cache konfigurasi
        Artisan::call('config:clear');
        $this->info('✔ Config cache cleared');

        // Hapus cache aplikasi
        Artisan::call('cache:clear');
        $this->info('✔ Application cache cleared');

        Artisan::call('config:cache');
        $this->info('✔ Application cache re-cached');

        Artisan::call('key:generate');
        $this->info('✔ Application configuration key generated');

        Artisan::call('optimize:clear');
        $this->info('✔ Application cache optimized');

        // List semua route (untuk debugging)
        $this->info('Menampilkan daftar rute yang terdaftar:');
        $this->call('route:list', [
            '-v' => true
        ]);

        $this->info('Berhasil clear cache route');
    }
}