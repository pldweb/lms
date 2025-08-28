<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Str;

class ScreenshotWebController extends Controller
{
    public function getIndex()
    {
        return view('admin.screenshot.index');
    }

    public function postPushScreenshot(Request $request)
    {
        $website = $request->input('website');

        // Konfigurasi semua perangkat dalam satu array
        $deviceConfigurations = [
            [
                'url_name' => 'iphone',
                'name' => 'iphone-6.5',
                'width' => 621,
                'height' => 1334,
            ],
            [
                'url_name' => 'iphone',
                'name' => 'iphone-6.9',
                'width' => 660,
                'height' => 1434,
            ],
            [
                'url_name' => 'ipad',
                'name' => 'ipad',
                'width' => 1032,
                'height' => 1376,
            ],
        ];

        $ids = [1, 2, 3, 4, 5];

        Storage::makeDirectory("public/screenshot/$website");

        // Proses setiap konfigurasi perangkat
        foreach ($deviceConfigurations as $config) {
            // Proses setiap ID
            foreach ($ids as $id) {
                // Tentukan URL
                $url = "https://m.$website/mobile-maker/generate/$id/{$config['url_name']}";

                // Buat nama file yang unik
                $filename = Str::slug("screenshot-{$config['name']}-$id") . '.jpg';
                $path = "public/screenshot/$website/$filename";

                try {
                    // Ambil screenshot
                    Browsershot::url($url)
                        ->windowSize($config['width'], $config['height'])
                        ->devicePixelRatio(2)
                        ->save(storage_path('app/' . $path));

                    echo "Screenshot untuk $url ({$config['name']}) berhasil disimpan.\n";
                } catch (\Exception $e) {
                    echo "Gagal mengambil screenshot untuk $url ({$config['name']}): " . $e->getMessage() . "\n";
                }
            }
        }

        return successAlert('Screenshot berhasil dibuat');
    }
}