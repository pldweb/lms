<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Slideshow;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class SlideshowController extends Controller
{
    public array $roles = ['Admin'];
    
    public static function getSlideshow()
    {
        $slideshows = Slideshow::aktif()->urutan()->get();
        
        if ($slideshows->isEmpty()) {
            // Fallback ke data statis jika belum ada data di database
            return [
                [
                    'image' => asset('landing/img/hero/hero-1.png'),
                    'title' => 'Selamat Datang di Website Resmi SMPN 20 Jakarta',
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
        }
        return $slideshows->toArray();
    }
    
    public function getIndex()
    {
        $slideshows = Slideshow::orderBy('urutan')->get();
        $params = [
            'slideshows' => $slideshows
        ];
        return view('admin.slideshow.index', $params);
    }
    
    public function getCreate()
    {
        return view('admin.slideshow.detail');
    }
    
    public function getEdit($id)
    {
        $slideshow = Slideshow::findOrFail($id);
        $params = [
            'data' => $slideshow
        ];
        return view('admin.slideshow.detail', $params);
    }
    
    public function postStore(Request $request)
    {
        if (!$request->id && !$request->hasFile('image')) {
            return errorAlert('Gambar harus diupload');
        }

        try {
            DB::beginTransaction();

            if ($request->id) {
                $slideshow = Slideshow::findOrFail($request->id);
            } else {
                $slideshow = new Slideshow;
            }

            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ada
                if ($slideshow->image && File::exists(public_path($slideshow->image))) {
                    File::delete(public_path($slideshow->image));
                }

                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('landing/img/hero'), $imageName);
                $slideshow->image = 'landing/img/hero/' . $imageName;
            }

            $data = [
                'image' => $slideshow->image ?? null,
                'title' => $request->title ?? null,
                'deskripsi' => $request->deskripsi ?? null,
                'link' => $request->link ?? null,
                'tombol_text' => $request->tombol_text ?? null,
                'urutan' => $request->urutan ?? 0,
                'aktif' => $request->has('aktif'),
            ];

            if ($request->id) {
                $slideshow->update($data);
            } else {
                Slideshow::create($data);
            }

            DB::commit();
            $text = $request->id ? 'Slideshow berhasil diperbarui' : 'Slideshow berhasil ditambahkan';
            return successAlert($text, null, '#masterData', '/admin/slideshow');
        } catch (\Throwable $th) {
            DB::rollBack();
            return errorAlert('Gagal menyimpan slideshow: ' . $th->getMessage());
        }
    }

    
    public function postDeleteAction($id)
    {
        $slideshow = Slideshow::findOrFail($id);

        try {
            if ($slideshow->image && File::exists(public_path($slideshow->image))) {
                File::delete(public_path($slideshow->image));
            }
            $slideshow->delete();
            return successAlert('Berhasil hapus slideshow');
        }catch(\Exception $e){
            return errorAlert('Gagal hapus slideshow');
        }
    }
}
