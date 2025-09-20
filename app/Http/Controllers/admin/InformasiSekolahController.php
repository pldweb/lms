<?php

namespace App\Http\Controllers\admin;

use App\Helper\CatatLogAktivitas;
use App\Http\Controllers\Controller;
use App\Models\InformasiSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InformasiSekolahController extends Controller
{
    public function getIndex()
    {
        $informasiSekolah = InformasiSekolah::first();
        $params = ['data' => $informasiSekolah];
        return view('admin.informasi-sekolah.index', $params);
    }

    public function postStore(Request $request)
    {
        $nama_sekolah = $request->nama_sekolah;
        $alamat = $request->alamat;
        $nomor_telepon = $request->nomor_telepon;
        $email = $request->email;
        $nomor_handphone = $request->nomor_handphone;
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $tagline = $request->tagline;
        
        try {
            DB::beginTransaction();
            $informasiSekolah = InformasiSekolah::first();
            
            if (!$informasiSekolah) {
                $informasiSekolah = new InformasiSekolah();
            }
            
            $informasiSekolah->nama_sekolah = $nama_sekolah;
            $informasiSekolah->alamat = $alamat;
            $informasiSekolah->nomor_telepon = $nomor_telepon;
            $informasiSekolah->email = $email;
            $informasiSekolah->nomor_handphone = $nomor_handphone;
            $informasiSekolah->latitude = $latitude;
            $informasiSekolah->longitude = $longitude;
            $informasiSekolah->tagline = $tagline;
            
            $imgPath = public_path('img');
            if (!file_exists($imgPath)) {
                mkdir($imgPath, 0755, true);
            }
            
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                if ($informasiSekolah->logo) {
                    Storage::delete('public/img/' . $informasiSekolah->logo);
                }

                $strip = str_replace(' ', '_', $logo->getClientOriginalName());
                $logoName = time() . '_' . $strip;
                
                $logo->move($imgPath, $logoName);
                $informasiSekolah->logo = $logoName;
            }

            if ($request->hasFile('logo_invert')) {
                if ($informasiSekolah->logo_invert) {
                    Storage::delete('public/img/' . $informasiSekolah->logo_invert);
                }
                $logoInvert = $request->file('logo_invert');
                $strip = str_replace(' ', '_', $logoInvert->getClientOriginalName());
                $logoInvertName = time() . '_' . $strip;
                $logoInvert->move($imgPath, $logoInvertName);
                $informasiSekolah->logo_invert = $logoInvertName;
            }

            if ($request->hasFile('favicon')) {
                if ($informasiSekolah->favicon) {
                    Storage::delete('public/img/' . $informasiSekolah->favicon);
                }
                $favicon = $request->file('favicon');
                $strip = str_replace(' ', '_', $favicon->getClientOriginalName());
                $faviconName = time() . '_' . $strip;
                $favicon->move($imgPath, $faviconName);
                $informasiSekolah->favicon = $faviconName;
            }
            
            
            $informasiSekolah->save();
            DB::commit();
            CatatLogAktivitas::catatAktivitas('memperbarui informasi sekolah');
            sendTelegramMessage('Memperbarui informasi sekolah');
            return successAlert('Berhasil memperbarui informasi sekolah', null, '#message-modal', '/admin/informasi-sekolah');
        } catch (\Exception $e) {
            DB::rollBack();
            return errorAlert('Gagal memperbarui informasi sekolah: '. $e->getMessage());
        }
    }
}
