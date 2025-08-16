<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\DomCrawler\Crawler;

class AmphuriScraperCommand extends Command
{
    protected $signature = 'scrape:amphuri {--pages=25 : Number of pages to scrape}';

    protected $description = 'Scrape data anggota AMPHURI dari website';

    public function handle()
    {
        $totalPages = $this->option('pages');
        $allData = [];
        
        $this->info("🚀 Memulai scraping data AMPHURI untuk {$totalPages} halaman...");
        $this->info("📍 Website: https://amphuri.org/data-anggota-amphuri");
        $this->newLine();

        // Progress bar
        $bar = $this->output->createProgressBar($totalPages);
        $bar->start();

        for ($page = 1; $page <= $totalPages; $page++) {
            try {
                $url = $page == 1 
                    ? 'https://amphuri.org/data-anggota-amphuri'
                    : "https://amphuri.org/data-anggota-amphuri/?excel_page={$page}";

                // Ambil HTML dari website
                $response = Http::timeout(30)
                    ->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                        'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
                        'Accept-Language' => 'id-ID,id;q=0.9,en;q=0.8',
                        'Accept-Encoding' => 'gzip, deflate, br',
                        'Connection' => 'keep-alive',
                        'Upgrade-Insecure-Requests' => '1',
                        'Cache-Control' => 'max-age=0',
                    ])
                    ->get($url);

                if ($response->successful()) {
                    $html = $response->body();
                    $pageData = $this->parseHtml($html);
                    $allData = array_merge($allData, $pageData);
                    
                    // Update progress bar dengan info
                    $bar->advance();
                    
                } else {
                    $bar->advance();
                    $this->newLine();
                    $this->warn("⚠️  Halaman {$page} gagal diambil (Status: {$response->status()})");
                }
                
                // Delay untuk menghindari rate limiting
                sleep(1);
                
            } catch (\Exception $e) {
                $bar->advance();
                $this->newLine();
                $this->error("❌ Error pada halaman {$page}: " . $e->getMessage());
            }
        }

        $bar->finish();
        $this->newLine(2);

        // Simpan ke CSV
        if (!empty($allData)) {
            $filename = $this->saveToCSV($allData);
            $this->info("✅ Scraping berhasil!");
            $this->info("📊 Total data berhasil di-scrape: " . count($allData) . " records");
            $this->info("💾 File CSV disimpan di:");
            $this->line("   - storage/app/{$filename}");
            $this->line("   - public/{$filename}");
            $this->newLine();
            $this->info("🎉 Proses selesai! Anda bisa menggunakan file CSV tersebut.");
        } else {
            $this->error("❌ Tidak ada data yang berhasil di-scrape!");
            $this->warn("💡 Kemungkinan penyebab:");
            $this->line("   - Website sedang down");
            $this->line("   - Struktur HTML website berubah");
            $this->line("   - Koneksi internet bermasalah");
        }

        return 0;
    }

    private function parseHtml($html)
    {
        $crawler = new Crawler($html);
        $data = [];

        try {
            // Cari tabel row dengan class yang sesuai
            $crawler->filter('tr.hover\\:bg-gray-50, table tr, tbody tr')->each(function (Crawler $row, $i) use (&$data) {
                // Skip jika ini adalah header row (tidak memiliki td)
                if ($row->filter('td')->count() == 0) return;

                $cells = $row->filter('td');
                
                if ($cells->count() >= 9) { // Pastikan ada minimal 9 kolom sesuai struktur
                    $rowData = [
                        'no' => trim($cells->eq(0)->text()),
                        'nama_perusahaan' => trim($cells->eq(1)->text()),
                        'merek_perusahaan' => trim($cells->eq(2)->text()),
                        'nomor_anggota' => trim($cells->eq(3)->text()),
                        'nama_pimpinan' => trim($cells->eq(4)->text()),
                        'perijinan' => trim($cells->eq(5)->text()),
                        'kota' => trim($cells->eq(6)->text()),
                        'provinsi' => trim($cells->eq(7)->text()),
                        'dpd' => trim($cells->eq(8)->text()),
                    ];
                    
                    // Hanya tambahkan jika nama perusahaan tidak kosong dan bukan header
                    if (!empty($rowData['nama_perusahaan']) && 
                        $rowData['nama_perusahaan'] !== 'Nama Perusahaan' &&
                        strlen($rowData['nama_perusahaan']) > 3) {
                        $data[] = array_values($rowData);
                    }
                }
            });

        } catch (\Exception $e) {
            $this->error("Error parsing HTML: " . $e->getMessage());
        }

        return $data;
    }

    /**
     * Simpan data ke file CSV
     */
    private function saveToCSV($data)
    {
        $filename = 'amphuri_data_' . date('Y-m-d_H-i-s') . '.csv';
        
        // BOM untuk UTF-8 agar Excel bisa baca dengan benar
        $csvContent = "\xEF\xBB\xBF";
        
        // Header CSV (sesuai dengan struktur data AMPHURI)
        $header = [
            'No',
            'Nama Perusahaan', 
            'Merek Perusahaan',
            'Nomor Anggota',
            'Nama Pimpinan',
            'Perijinan',
            'Kota',
            'Provinsi',
            'DPD'
        ];
        
        $csvContent .= implode(',', $header) . "\n";

        // Data rows
        foreach ($data as $index => $row) {
            // Escape dan bersihkan data
            $cleanRow = array_map(function($cell) {
                $cell = str_replace(['"', "\n", "\r"], ['""', ' ', ' '], $cell);
                return '"' . $cell . '"';
            }, $row);
            
            // Pastikan jumlah kolom konsisten (9 kolom)
            while (count($cleanRow) < 9) {
                $cleanRow[] = '""';
            }
            
            $csvContent .= implode(',', array_slice($cleanRow, 0, 9)) . "\n";
        }

        // Simpan file di storage dan public
        Storage::put($filename, $csvContent);
        file_put_contents(public_path($filename), $csvContent);
        
        return $filename;
    }
}