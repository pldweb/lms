<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Throwable;

class ImportLokasi extends Command
{
    protected $signature = 'app:import-lokasi';

    protected $description = 'Ambil data lokasi dari 4 API Nusakita';

    public function handle()
    {
        $this->info('🚀 Memulai proses impor data lokasi dari 4 API.');
        $this->comment('Proses ini mungkin memakan waktu sangat lama, terutama untuk desa/kelurahan...');

        // Daftar endpoint API Anda
        $endpoints = [
            'provinsi' => 'https://api.nusakita.yuefii.site/v2/provinsi?pagination=false',
            'kabupaten' => 'https://api.nusakita.yuefii.site/v2/kab-kota?pagination=false',
            'kecamatan' => 'https://api.nusakita.yuefii.site/v2/kecamatan?pagination=false',
            'kelurahan' => 'https://api.nusakita.yuefii.site/v2/desa-kel?pagination=false',
        ];

        try {
            $this->processEndpoint($endpoints['provinsi'], 'provinsis', [
                'kode' => 'kode',
                'nama' => 'nama',
                'lat' => 'lat',
                'lng' => 'lng'
            ]);

            $this->processEndpoint($endpoints['kabupaten'], 'kabupatens', [
                'kode' => 'kode',
                'nama' => 'nama',
                'kode_provinsi' => 'kode_provinsi',
                'lat' => 'lat',
                'lng' => 'lng'
            ]);

            $this->processEndpoint($endpoints['kecamatan'], 'kecamatans', [
                'kode' => 'kode',
                'nama' => 'nama',
                'kode_kabupaten' => 'kode_kabupaten_kota',
                'lat' => 'lat',
                'lng' => 'lng'
            ]);

            $this->processEndpoint($endpoints['kelurahan'], 'kelurahans', [
                'kode' => 'kode',
                'nama' => 'nama',
                'kode_kecamatan' => 'kode_kecamatan',
                'lat' => 'lat',
                'lng' => 'lng'
            ]);

            $this->info('✅ Semua data lokasi berhasil diimpor.');

        } catch (Throwable $e) {
            $this->error('Terjadi kesalahan saat impor: ' . $e->getMessage());
        }

        return 0;
    }

    protected function processEndpoint(string $url, string $tableName, array $columnMapping)
    {
        $this->comment("Mengambil data untuk tabel: {$tableName}...");
        
        $response = Http::get($url);

        if (!$response->successful()) {
            $this->error("Gagal mengambil data dari URL: {$url}");
            return;
        }

        $data = $response->json()['data'];
        $total = count($data);
        $this->info("{$total} data ditemukan. Memulai proses impor ke database...");

        $collection = collect($data);
        $chunks = $collection->chunk(500); 

        $progressBar = $this->output->createProgressBar($total);
        $progressBar->start();

        foreach ($chunks as $chunk) {
            $insertData = [];
            foreach ($chunk as $item) {
                $newItem = [];
                foreach ($columnMapping as $dbColumn => $apiColumn) {
                    $newItem[$dbColumn] = $item[$apiColumn] ?? null;
                }
                $insertData[] = $newItem;
            }
            
            DB::table($tableName)->upsert($insertData, ['kode']);
            
            $progressBar->advance($chunk->count());
        }

        $progressBar->finish();
        $this->newLine(2);
    }
}