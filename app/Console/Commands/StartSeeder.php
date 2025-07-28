<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class StartSeeder extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'app:start-seeder';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Menjalankan semua seeder untuk mengisi data dummy ke dalam database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Memulai proses seeding data dummy...');
        
        // Menjalankan seeder utama
        Artisan::call('migrate:fresh --seed');
        
        $this->info('✅ Proses seeding berhasil diselesaikan!');
        return 0;
    }
}
