<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SocialMediaController extends Controller
{
    /**
     * Method untuk mendapatkan data social media dengan fallback
     */
    public static function getSocialMedia()
    {
        return [
            [
                'nama' => 'Facebook',
                'icon' => 'fab fa-facebook-f',
                'link' => 'https://facebook.com/sekolah',
                'deskripsi' => 'Halaman Facebook Sekolah',
                'urutan' => 1,
                'aktif' => true
            ],
            [
                'nama' => 'Instagram',
                'icon' => 'fab fa-instagram',
                'link' => 'https://instagram.com/sekolah',
                'deskripsi' => 'Instagram Sekolah',
                'urutan' => 2,
                'aktif' => true
            ],
            [
                'nama' => 'YouTube',
                'icon' => 'fab fa-youtube',
                'link' => 'https://youtube.com/sekolah',
                'deskripsi' => 'Channel YouTube Sekolah',
                'urutan' => 3,
                'aktif' => true
            ]
        ];
    }

    /**
     * Menampilkan halaman index social media
     */
    public function getIndex()
    {
        $socialMedia = SocialMedia::orderBy('urutan', 'asc')->get();
        
        return view('admin.social_media.index', [
            'socialMedia' => $socialMedia
        ]);
    }

    /**
     * Menampilkan halaman create social media
     */
    public function getCreate()
    {
        return view('admin.social_media.detail', [
            'socialMedia' => null
        ]);
    }

    /**
     * Menampilkan halaman edit social media
     */
    public function getEdit($id)
    {
        $socialMedia = SocialMedia::find($id);
        
        if (!$socialMedia) {
            return redirect()->route('admin.social_media')->with('error', 'Social Media tidak ditemukan');
        }
        
        return view('admin.social_media.detail', [
            'socialMedia' => $socialMedia
        ]);
    }

    /**
     * Menyimpan atau mengupdate data social media
     */
    public function postStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'link' => 'required|url|max:255',
            'deskripsi' => 'nullable|string',
            'urutan' => 'required|integer|min:0',
            'aktif' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $data = [
                'nama' => $request->nama,
                'icon' => $request->icon,
                'link' => $request->link,
                'deskripsi' => $request->deskripsi,
                'urutan' => $request->urutan,
                'aktif' => $request->has('aktif') ? true : false
            ];

            if ($request->id) {
                // Update existing social media
                $socialMedia = SocialMedia::find($request->id);
                if (!$socialMedia) {
                    throw new \Exception('Social Media tidak ditemukan');
                }
                $socialMedia->update($data);
                $message = 'Social Media berhasil diupdate';
            } else {
                // Create new social media
                SocialMedia::create($data);
                $message = 'Social Media berhasil ditambahkan';
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $message,
                'redirect' => route('admin.social_media')
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menghapus social media
     */
    public function postDeleteAction($id)
    {
        try {
            $socialMedia = SocialMedia::find($id);
            
            if (!$socialMedia) {
                return response()->json([
                    'success' => false,
                    'message' => 'Social Media tidak ditemukan'
                ], 404);
            }

            $socialMedia->delete();

            return response()->json([
                'success' => true,
                'message' => 'Social Media berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
