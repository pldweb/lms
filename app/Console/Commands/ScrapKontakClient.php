<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Storage;

class ScrapKontakClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scrap-kontak-client {--username=} {--password=} {--start=980} {--end=987} {--otp=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scraping data kontak client dari website admin.erahajj.co.id';

    protected $client;
    protected $cookieJar;
    protected $baseUrl = 'https://admin.erahajj.co.id';
    protected $loginUrl = 'https://admin.erahajj.co.id/login';
    protected $kontakUrl = 'https://admin.erahajj.co.id/user/kontak-client';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai proses scraping data kontak client...');
        
        $username = $this->option('username') ?: $this->ask('Masukkan username:');
        $password = $this->option('password') ?: $this->secret('Masukkan password:');
        $startPage = $this->option('start');
        $endPage = $this->option('end');
        $otp = $this->option('otp');
        
        $this->cookieJar = new CookieJar();
        $this->client = new Client([
            'cookies' => $this->cookieJar,
            'verify' => false, // Disable SSL verification if needed
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.114 Safari/537.36',
            ],
        ]);

        // Login ke website
        $loginResult = $this->login($username, $password);
        
        if ($loginResult === 'need_otp') {
            // Jika OTP sudah disediakan melalui parameter
            if ($otp) {
                if (!$this->verifyOtp($otp)) {
                    $this->error('Verifikasi OTP gagal.');
                    return 1;
                }
            } else {
                // Minta input OTP dari user
                $otp = $this->ask('Kode OTP telah dikirim. Silakan masukkan kode OTP:');
                if (!$this->verifyOtp($otp)) {
                    $this->error('Verifikasi OTP gagal.');
                    return 1;
                }
            }
        } elseif ($loginResult !== true) {
            $this->error('Login gagal. Periksa kembali username dan password Anda.');
            return 1;
        }

        $this->info('Login berhasil!');
        
        // Persiapkan file CSV
        $csvFileName = 'kontak_client_' . date('Y-m-d_His') . '.csv';
        $csvFilePath = storage_path('app/' . $csvFileName);
        
        // Buat header CSV
        $csvFile = fopen($csvFilePath, 'w');
        fputcsv($csvFile, ['No', 'Nama', 'Travel', 'Jabatan', 'Email', 'No. Handphone']);
        
        $totalData = 0;
        
        // Scraping data dari setiap halaman
        $this->output->progressStart($endPage - $startPage + 1);
        
        for ($page = $startPage; $page <= $endPage; $page++) {
            $this->info("\nScraping halaman $page...");
            $pageUrl = $this->kontakUrl . '?page=' . $page;
            
            try {
                $response = $this->client->get($pageUrl);
                $html = (string) $response->getBody();
                $crawler = new Crawler($html);
                
                // Ambil data dari tabel
                $rows = $crawler->filter('table tbody tr')->each(function (Crawler $row) {
                    $columns = $row->filter('td')->each(function (Crawler $column) {
                        return trim($column->text());
                    });
                    
                    return $columns;
                });
                
                // Tulis data ke CSV
                foreach ($rows as $row) {
                    if (count($row) >= 6) {
                        fputcsv($csvFile, $row);
                        $totalData++;
                    }
                }
                
                $this->output->progressAdvance();
                
                // Delay untuk menghindari rate limiting
                sleep(1);
                
            } catch (\Exception $e) {
                $this->error("Error pada halaman $page: " . $e->getMessage());
            }
        }
        
        $this->output->progressFinish();
        fclose($csvFile);
        
        $this->info("\nProses scraping selesai!");
        $this->info("Total data yang berhasil di-scraping: $totalData");
        $this->info("Data disimpan di: $csvFilePath");
        
        return 0;
    }
    
    /**
     * Login ke website
     */
    protected function login($username, $password)
    {
        try {
            // Ambil CSRF token
            $response = $this->client->get($this->loginUrl);
            $html = (string) $response->getBody();
            $crawler = new Crawler($html);
            
            $csrfToken = $crawler->filter('input[name="_token"]')->attr('value');
            
            if (!$csrfToken) {
                $this->error('Tidak dapat menemukan CSRF token.');
                return false;
            }
            
            // Kirim request login
            $this->info('Mengirim data login...');
            $response = $this->client->post($this->loginUrl, [
                'form_params' => [
                    '_token' => $csrfToken,
                    'email' => $username,
                    'password' => $password,
                ],
                'allow_redirects' => true,
            ]);
            
            $html = (string) $response->getBody();
            $finalUrl = $response->getHeaderLine('X-Guzzle-Redirect-History') ?: (string) $response->getEffectiveUrl();
            
            // Cek apakah ada form OTP
            if (strpos($html, 'otp') !== false || strpos($html, 'OTP') !== false || 
                strpos($html, 'verifikasi') !== false || strpos($html, 'verification') !== false) {
                $this->info('Sistem meminta verifikasi OTP. OTP telah dikirim ke email/nomor HP Anda.');
                return 'need_otp';
            }
            
            // Jika URL setelah login tidak mengandung 'login', kemungkinan login berhasil
            return strpos($finalUrl, 'login') === false;
            
        } catch (\Exception $e) {
            $this->error('Error saat login: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Verifikasi OTP
     */
    protected function verifyOtp($otp)
    {
        try {
            // Cari URL dan form untuk verifikasi OTP
            $this->info('Mencari form verifikasi OTP...');
            
            // Coba beberapa kemungkinan URL untuk form OTP
            $possibleUrls = [
                $this->baseUrl . '/verify-otp',
                $this->baseUrl . '/otp-verification',
                $this->baseUrl . '/verification',
                $this->baseUrl . '/validate-otp',
                $this->baseUrl
            ];
            
            $otpUrl = null;
            $csrfToken = null;
            
            foreach ($possibleUrls as $url) {
                try {
                    $response = $this->client->get($url);
                    $html = (string) $response->getBody();
                    $crawler = new Crawler($html);
                    
                    // Cari form OTP
                    $otpForm = $crawler->filter('form:contains("OTP"), form:contains("otp"), form:contains("verifikasi"), form:contains("verification")');
                    
                    if ($otpForm->count() > 0) {
                        // Ambil action URL dan CSRF token
                        $formAction = $otpForm->attr('action');
                        if ($formAction) {
                            // Jika action adalah URL relatif, gabungkan dengan baseUrl
                            if (strpos($formAction, 'http') !== 0) {
                                $otpUrl = rtrim($this->baseUrl, '/') . '/' . ltrim($formAction, '/');
                            } else {
                                $otpUrl = $formAction;
                            }
                        } else {
                            $otpUrl = $url; // Gunakan URL saat ini jika tidak ada action
                        }
                        
                        $csrfTokenElement = $otpForm->filter('input[name="_token"]');
                        if ($csrfTokenElement->count() > 0) {
                            $csrfToken = $csrfTokenElement->attr('value');
                        }
                        
                        $this->info('Form OTP ditemukan di: ' . $url);
                        break;
                    }
                } catch (\Exception $e) {
                    continue; // Coba URL berikutnya
                }
            }
            
            if (!$otpUrl) {
                $this->error('Tidak dapat menemukan form OTP.');
                return false;
            }
            
            // Siapkan data untuk verifikasi OTP
            $formData = [];
            
            if ($csrfToken) {
                $formData['_token'] = $csrfToken;
            }
            
            // Coba beberapa kemungkinan nama field untuk OTP
            $otpFieldNames = ['otp', 'otp_code', 'verification_code', 'code', 'token'];
            
            // Gunakan nama field pertama sebagai default
            $formData[$otpFieldNames[0]] = $otp;
            
            $this->info('Mengirim kode OTP: ' . $otp);
            
            // Kirim OTP
            $response = $this->client->post($otpUrl, [
                'form_params' => $formData,
                'allow_redirects' => true,
            ]);
            
            $finalUrl = $response->getHeaderLine('X-Guzzle-Redirect-History') ?: (string) $response->getEffectiveUrl();
            $html = (string) $response->getBody();
            
            // Cek apakah verifikasi berhasil
            if (strpos($html, 'berhasil') !== false || 
                strpos($html, 'success') !== false || 
                strpos($finalUrl, 'dashboard') !== false || 
                strpos($finalUrl, 'home') !== false ||
                strpos($finalUrl, 'kontak-client') !== false) {
                $this->info('Verifikasi OTP berhasil!');
                return true;
            } else {
                $this->error('Verifikasi OTP gagal. Periksa kode OTP Anda.');
                return false;
            }
            
        } catch (\Exception $e) {
            $this->error('Error saat verifikasi OTP: ' . $e->getMessage());
            return false;
        }
    }
}
