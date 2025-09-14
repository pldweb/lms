<?php

namespace App\Http\Controllers\admin;

use App\Helper\CatatLogAktivitas;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public array $roles = ['Admin', 'Guru', 'Siswa', 'Wali Murid'];

    public function getAdmin()
    {
        $users = User::role(['Admin'])->orderBy('created_at', 'desc')->get();
        $params = [
            'users' => $users,
            'jenis' => 'admin'
        ];
        return view('admin.user.admin', $params);
    }

    public function getGuru()
    {
        $users = User::role(['Guru'])->orderBy('created_at', 'desc')->get();
        $params = [
            'users' => $users,
            'jenis' => 'guru'
        ];
        return view('admin.user.admin', $params);
    }

    public function getSiswa()
    {
        $users = User::role(['Siswa'])->orderBy('created_at', 'desc')->get();
        $params = [
            'users' => $users,
            'jenis' => 'siswa'
        ];
        return view('admin.user.admin', $params);
    }

    public function getDetail($id)
    {
        $user = User::find($id);
        $params = [
            'user' => $user,
            'jenis' => $user->roles->first()->name,
        ];
        return view('admin.user.detail', $params);
    }

    public function getCreateUser($jenis)
    {
        $params = [
            'roles' => $this->roles,
            'jenis' => $jenis,
        ];
        return view('admin.user.create', $params);
    }

    public function getEdit($jenis, $id)
    {
        $user = User::find($id);
        $params = [
            'jenis' => $jenis,
            'user' => $user,
        ];
        return view('admin.user.create', $params);
    }

    public function postCreateUserAction(Request $request)
    {
        $nama = $request->nama;
        $email = $request->email;
        $password = $request->password;
        $jenisUser = $request->jenis;
        $tanggalLahir = $request->tanggal_lahir;
        $id = $request->id;

        try {
            DB::beginTransaction();
            
            $user = User::find($id) ?? new User();
            
            $user->nama = $nama;
            $user->email = $email;
            $user->nama_lengkap = $request->nama_lengkap;
            $user->nisn = $request->nisn;
            $user->jenis_kelamin = $request->jenis_kelamin;
            if ($password) { 
                $user->password = Hash::make($password);
            }
            $user->tanggal_lahir = $tanggalLahir;
            $user->alamat = $request->alamat;
            $user->no_hp = $request->no_hp;
            $user->provinsi = $request->provinsi;
            $user->kota = $request->kota;
            $user->kecamatan = $request->kecamatan;
            $user->kelurahan = $request->kelurahan;
            $user->kodepos = $request->kodepos;
            
            // Tambahkan data khusus berdasarkan jenis user
            if ($jenisUser == 'siswa') {
                $user->nama_orang_tua = $request->nama_orang_tua;
                $user->no_hp_orang_tua = $request->no_hp_orang_tua;
            }
            
            // Upload dan simpan foto profile jika ada
            if ($request->hasFile('foto_profile')) {
                $file = $request->file('foto_profile');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('profile', $fileName, 'public');
                $user->foto_profile = $path;
            }
            
            $user->save();
            
            $lowerJenis = strtolower($jenisUser);
            $redirect = '/admin/user/'. $lowerJenis;  
            DB::commit();
            
            // Pesan sesuai kondisi create/update
            $aksi = $id ? "Update" : "Buat";
            CatatLogAktivitas::catatAktivitas("$aksi user $user->nama $jenisUser");
            sendTelegramMessage("$aksi user $user->nama $jenisUser");
            return successAlert("Berhasil $aksi user ".$user->nama, null, '#message-modal', $redirect);
        } catch (\Exception $e) {
            DB::rollBack();
            $aksi = $id ? "update" : "buat";
            CatatLogAktivitas::catatAktivitas("Gagal $aksi user $jenisUser");
            sendTelegramMessage("Gagal $aksi user $jenisUser");
            return errorAlert("Gagal $aksi user $jenisUser: ". $e->getMessage());
        }
    }

    public function postDeleteUser($id, $jenis)
    {
        $id = intval($id);
        $lowerJenis = strtolower($jenis);
        try {
            DB::beginTransaction();
            $user = User::find($id);
            CatatLogAktivitas::catatAktivitas('Hapus user '.$user->nama);
            sendTelegramMessage('Hapus user '.$user->nama);
            $user->delete();
            DB::commit();
            return successAlert('Berhasil hapus user', null, '#message-modal', '/admin/user/'.$lowerJenis);
        }catch (\Exception $e){
            DB::rollBack();
            CatatLogAktivitas::catatAktivitas('Gagal hapus user');
            sendTelegramMessage('Gagal hapus user');
            return errorAlert('Gagal hapus user'. $e->getMessage());
        }
    }
}
