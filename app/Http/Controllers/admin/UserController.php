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
        $users = User::role(['Admin'])->get();
        $params = [
            'users' => $users,
            'jenis' => 'admin'
        ];
        return view('admin.user.admin', $params);
    }

    public function getGuru()
    {
        $users = User::role(['Guru'])->get();
        $params = [
            'users' => $users,
            'jenis' => 'guru'
        ];
        return view('admin.user.admin', $params);
    }

    public function getSiswa()
    {
        $users = User::role(['Siswa'])->get();
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

    public function postUpdateUserAction(Request $request)
    {
        $id = $request->id;
        $nama = $request->nama;
        $email = $request->email;
        $password = $request->password;
        $jenis = $request->jenis;
        $jenisUser = $request->jenis_user;
        $tanggalLahir = $request->tanggal_lahir;

        try {
            DB::beginTransaction();
            $user = User::find($id);
            $user->nama = $nama;
            $user->email = $email;
            if($password != null){
                $user->password = Hash::make($password);
            }
            
            // Update data umum
            $user->jenis_user = $jenisUser;
            $user->tanggal_lahir = $tanggalLahir;
            $user->alamat = $request->alamat;
            $user->no_hp = $request->no_hp;
            $user->provinsi = $request->provinsi;
            $user->kota = $request->kota;
            $user->kecamatan = $request->kecamatan;
            $user->kelurahan = $request->kelurahan;
            $user->kodepos = $request->kodepos;
            
            // Update data khusus berdasarkan jenis user
            if ($jenisUser == 'siswa') {
                $user->nama_orang_tua = $request->nama_orang_tua;
                $user->no_hp_orang_tua = $request->no_hp_orang_tua;
            }
            
            // Upload dan simpan foto profile jika ada
            if ($request->hasFile('foto_profile')) {
                // Hapus foto lama jika ada
                if ($user->foto_profile && Storage::disk('public')->exists($user->foto_profile)) {
                    Storage::disk('public')->delete($user->foto_profile);
                }
                
                $file = $request->file('foto_profile');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('profile', $fileName, 'public');
                $user->foto_profile = $path;
            }
            
            $user->save();
            DB::commit();
            CatatLogAktivitas::catatAktivitas('Ubah profile user');
            sendTelegramMessage('Ubah profile user');
            return successAlert('Berhasil ubah profile', null, '#message-modal', '/admin/user/'.$jenis);
        }catch (\Exception $e){
            DB::rollBack();
            CatatLogAktivitas::catatAktivitas('Gagal ubah profile user');
            sendTelegramMessage('Gagal ubah profile user');
            return errorAlert('Gagal ubah profile'. $e->getMessage());
        }
    }

    public function getCreateUser($jenis)
    {
        $params = [
            'roles' => $this->roles,
            'jenis' => $jenis,
        ];
        return view('admin.user.create', $params);
    }

    public function postCreateUserAction(Request $request)
    {
        $nama = $request->nama;
        $email = $request->email;
        $password = $request->password;
        $jenis = $request->jenis;
        $lowerJenis = strtolower($jenis);
        $jenisUser = $request->jenis_user;
        $tanggalLahir = $request->tanggal_lahir;

        try {
            DB::beginTransaction();
            $user = new User();
            $user->nama = $nama;
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->jenis_user = $jenisUser;
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
            $user->assignRole($jenis);
            DB::commit();
            CatatLogAktivitas::catatAktivitas('Buat user');
            sendTelegramMessage('Buat user');
            return successAlert('Berhasil buat user', null, '#message-modal', '/admin/user/'.  $lowerJenis);
        }catch (\Exception $e){
            DB::rollBack();
            CatatLogAktivitas::catatAktivitas('Gagal buat user');
            sendTelegramMessage('Gagal buat user');
            return errorAlert('Gagal buat user'. $e->getMessage());
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
