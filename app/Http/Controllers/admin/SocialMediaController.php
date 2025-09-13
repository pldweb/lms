<?php

namespace App\Http\Controllers\admin;

use App\Helper\CatatLogAktivitas;
use App\Http\Controllers\Controller;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class SocialMediaController extends Controller
{
    public array $roles = ['Admin'];
   
    public static function getSocialMedia()
    {
        $socialMedia = SocialMedia::aktif()->urutan()->get();
        
        if ($socialMedia->isEmpty()) {
            return [
                [
                    'nama' => 'Facebook',
                    'icon' => '',
                    'link' => 'https://facebook.com/sekolah',
                    'deskripsi' => 'Halaman Facebook Sekolah',
                    'urutan' => 1,
                    'aktif' => true
                ],
                [
                    'nama' => 'Instagram',
                    'icon' => '',
                    'link' => 'https://instagram.com/sekolah',
                    'deskripsi' => 'Instagram Sekolah',
                    'urutan' => 2,
                    'aktif' => true
                ],
                [
                    'nama' => 'YouTube',
                    'icon' => '',
                    'link' => 'https://youtube.com/sekolah',
                    'deskripsi' => 'Channel YouTube Sekolah',
                    'urutan' => 3,
                    'aktif' => true
                ]
            ];
        }
        
        return $socialMedia;
    }

    public function getIndex()
    {
        $socialMedia = SocialMedia::orderBy('urutan', 'asc')->get();
        $params = [
            'socialMedia' => $socialMedia
        ];
        return view('admin.social_media.index', $params);
    }

    public function getCreate(Request $request)
    {
        $data = SocialMedia::find($request->id);
        $params = ['socialMedia' => $data];
        return view('admin.social_media.create', $params);
    }

    public function getEdit($id)
    {
        $data = SocialMedia::find($id);
        $params = ['socialMedia' => $data];
        return view('admin.social_media.create', $params);
    }


    public function postStore(Request $request)
    {
        
        $id = $request->id;
        $socialMedia = $id ? SocialMedia::find($id) : new SocialMedia;
        
        try {
            DB::beginTransaction();
            
            $socialMedia->nama = $request->nama;
            $socialMedia->link = $request->link;
            $socialMedia->urutan = $request->urutan;
            $socialMedia->aktif = $request->has('aktif') ? true : false;
            
            // Handle icon upload
            if ($request->hasFile('icon')) {
                if ($socialMedia->icon && Storage::disk('public')->exists($socialMedia->icon)) {
                    Storage::disk('public')->delete($socialMedia->icon);
                }
                
                $iconFile = $request->file('icon');
                $iconName = time() . '_' . str_replace(' ', '_', $iconFile->getClientOriginalName());
                $socialMedia->icon = $iconFile->storeAs('social_media', $iconName, 'public');

            } elseif ($request->icon && !$request->hasFile('icon')) {
                $socialMedia->icon = $request->icon;
            }
            
            $socialMedia->save();
            DB::commit();
            
            if($id){
                sendTelegramMessage('Social Media berhasil diupdate');
                CatatLogAktivitas::catatAktivitas('Social Media berhasil diupdate');
                return successAlert('Social Media berhasil diupdate', null, '', '/admin/social-media');
            } else {
                sendTelegramMessage('Social Media berhasil ditambahkan');
                CatatLogAktivitas::catatAktivitas('Social Media berhasil ditambahkan');
                return successAlert('Social Media berhasil ditambahkan', null, '', '/admin/social-media');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return errorAlert('Social Media gagal ' . ($id ? 'diupdate' : 'ditambahkan'), $th->getMessage());
        }
    }

    public function postDelete($id)
    {
        $socialMedia = SocialMedia::find($id);
        
        try {
            DB::beginTransaction();
            
            // Delete icon file if exists
            if ($socialMedia->icon && Storage::exists('public/social_media/' . $socialMedia->icon)) {
                Storage::delete('public/social_media/' . $socialMedia->icon);
            }
            
            $socialMedia->delete();
            DB::commit();
            
            sendTelegramMessage('Social Media berhasil dihapus');
            CatatLogAktivitas::catatAktivitas('Social Media berhasil dihapus');
            return successAlert('Social Media berhasil dihapus', null, '', '/admin/social_media');
        } catch (\Throwable $th) {
            DB::rollBack();
            return errorAlert('Social Media gagal dihapus', $th->getMessage());
        }
    }
    
    public function postToggleStatus($id)
    {
        $socialMedia = SocialMedia::find($id);
        
        try {
            DB::beginTransaction();
            $socialMedia->aktif = !$socialMedia->aktif;
            $socialMedia->save();
            DB::commit();
            
            $status = $socialMedia->aktif ? 'diaktifkan' : 'dinonaktifkan';
            sendTelegramMessage('Social Media berhasil ' . $status);
            CatatLogAktivitas::catatAktivitas('Social Media berhasil ' . $status);
            return successAlert('Social Media berhasil ' . $status);
        } catch (\Throwable $th) {
            DB::rollBack();
            return errorAlert('Social Media gagal diupdate', $th->getMessage());
        }
    }
}
