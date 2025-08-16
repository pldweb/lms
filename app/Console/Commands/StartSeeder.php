<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class StartSeeder extends Command
{
    protected $signature = 'app:start-seeder';

    protected $description = 'Menjalankan semua seeder untuk mengisi data dummy ke dalam database';

    public function handle()
    {
        $this->info('🚀 Memulai proses seeding data dummy...');
        
        $this->call('migrate:fresh', [
            '--seed' => true,
        ]);
        
        $this->info('✅ Proses seeding berhasil diselesaikan!');
        return 0;
    }
}