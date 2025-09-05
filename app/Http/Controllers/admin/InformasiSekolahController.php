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
        $params = [
            'data' => $informasiSekolah
        ];
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
            
            if ($request->hasFile('logo')) {
                // Delete old logo if exists
                if ($informasiSekolah->logo && $informasiSekolah->logo != 'Logo-SMPN20.png') {
                    if (file_exists(public_path('img/' . $informasiSekolah->logo))) {
                        unlink(public_path('img/' . $informasiSekolah->logo));
                    }
                }
                
                // Upload new logo
                $logoName = time() . '.' . $request->logo->extension();
                $request->logo->move(public_path('img'), $logoName);
                $informasiSekolah->logo = $logoName;
            }

            if ($request->hasFile('favicon')) {
                // Delete old favicon if exists
                if ($informasiSekolah->favicon && $informasiSekolah->favicon != 'favicon.png') {
                    if (file_exists(public_path('img/' . $informasiSekolah->favicon))) {
                        unlink(public_path('img/' . $informasiSekolah->favicon));
                    }
                }

                // Upload new favicon
                $faviconName = time() . '.' . $request->favicon->extension();
                $request->favicon->move(public_path('img'), $faviconName);
                $informasiSekolah->favicon = $faviconName;
            }
            
            $informasiSekolah->save();
            DB::commit();
            CatatLogAktivitas::catatAktivitas('memperbarui informasi sekolah');
            return successAlert('Berhasil memperbarui informasi sekolah', null, '#message-modal', '/admin/informasi-sekolah');
        } catch (\Exception $e) {
            DB::rollBack();
            return errorAlert('Gagal memperbarui informasi sekolah'. $e->getMessage());
        }
    }
}
