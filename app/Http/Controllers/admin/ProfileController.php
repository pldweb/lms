<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;    
use App\Helper\LokasiHelper;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    public function getUploadFoto()
    {
        return view('admin.profile.upload-foto');
    }

    public function postUploadFotoAction(Request $request)
    {
        $user = Auth::user();
        if ($user->foto_profile && Storage::disk('public')->exists($user->foto_profile)) {
            Storage::disk('public')->delete($user->foto_profile);
        }
        $path = $request->file('foto_profile')->store('profile-photo', 'public');

        try{
            DB::beginTransaction();
            $userExist = User::find($user->id);
            $userExist->foto_profile = $path;
            $userExist->save();
            DB::commit();
            return successAlert('Foto profile berhasil diupload');
        }catch(\Exception $e){
            DB::rollBack();
            return errorAlert('Foto profile gagal diupload');
        }
    }

    public function getIndex()
    {
        $provinsi = LokasiHelper::getProvinsi();
        $provinsi = $provinsi['data'];
        $user = Auth::user();

        $params = [
            'provinsi' => $provinsi,
            'user' => $user,
        ];
        return view('admin.profile.index', $params);
    }

    public function postUpdateProfile(Request $request)
    {
        $id = $request->id;
        $nama = $request->nama;
        $namaLengkap = $request->nama_lengkap;
        $email = $request->email;
        $phone = $request->phone;
        $alamat = $request->alamat;
        $provinsi = $request->provinsi;
        $kota = $request->kota;
        $kecamatan = $request->kecamatan;
        $kelurahan = $request->kelurahan;
        $kodepos = $request->kodepos;

        if($nama == null){
            return errorAlert('Nama tidak boleh kosong');
        }

        if($namaLengkap == null){
            return errorAlert('Nama tidak boleh kosong');
        }

        if($email == null){
            return errorAlert('Email tidak boleh kosong');
        }

        try{
            DB::beginTransaction();
            $user = User::find($id);
            $user->nama = $nama;
            $user->nama_lengkap = $namaLengkap;
            $user->email = $email;
            $user->no_hp = $phone;
            $user->alamat = $alamat;
            $user->provinsi = $provinsi;
            $user->kota = $kota;
            $user->kecamatan = $kecamatan;
            $user->kelurahan = $kelurahan;
            $user->kodepos = $kodepos;
            $user->save();
            DB::commit();
            return successAlert('Profil berhasil diupdate', '/admin/profile');
        }catch(\Exception $e){
            DB::rollBack();
            return errorAlert('Profil gagal diupdate', '/admin/profile');
        }
    }

    public function getChangePassword()
    {
        return view('admin.profile.change-password');
    }

    public function postChangePasswordAction(Request $request)
    {
        $password = $request->password;
        if($password == null){
            return errorAlert('Password tidak boleh kosong');
        }

        try{
            DB::beginTransaction();
            $user = Auth::user();
            $user->password = Hash::make('password');
            User::where('id', $user->id)->update(['password' => $user->password]);
            DB::commit();
            return successAlert('Password berhasil diganti', '/admin/profile');
        }catch(\Exception $e){
            DB::rollBack();
            return errorAlert('Password gagal diganti', '/admin/profile');
        }
    }
}
