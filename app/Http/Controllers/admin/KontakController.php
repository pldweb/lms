<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use App\Helper\CatatLogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KontakController extends Controller
{
    public array $roles = ['Admin'];

    public static function getKontak()
    {
        $kontak = Kontak::aktif()
            ->urutan()
            ->get()
            ->toArray();
            
        if (empty($kontak)) {
            // Fallback data jika tidak ada data di database
            $kontak = [
                [
                    'nama' => 'Kepala Sekolah',
                    'jabatan' => 'Kepala Sekolah',
                    'email' => 'kepsek@smp20jakarta.sch.id',
                    'telepon' => '021-12345678',
                    'alamat' => 'Jl. Contoh No. 123, Jakarta',
                    'icon' => 'fas fa-user-tie'
                ],
                [
                    'nama' => 'Tata Usaha',
                    'jabatan' => 'Tata Usaha',
                    'email' => 'tu@smp20jakarta.sch.id',
                    'telepon' => '021-87654321',
                    'alamat' => 'Jl. Contoh No. 123, Jakarta',
                    'icon' => 'fas fa-envelope'
                ],
                [
                    'nama' => 'Bagian Kesiswaan',
                    'jabatan' => 'Wakil Kepala Sekolah Bidang Kesiswaan',
                    'email' => 'kesiswaan@smp20jakarta.sch.id',
                    'telepon' => '021-13579246',
                    'alamat' => 'Jl. Contoh No. 123, Jakarta',
                    'icon' => 'fas fa-users'
                ]
            ];
        }
        
        return $kontak;
    }

    public function getIndex()
    {
        $kontak = Kontak::orderBy('urutan', 'asc')->get();
        $params = ['kontak' => $kontak];
        return view('admin.kontak.index', $params);
    }

    public function getCreate(Request $request)
    {
        $data = Kontak::find($request->id);
        $params = ['data' => $data];
        return view('admin.kontak.detail', $params);
    }

    public function getEdit($id)
    {
        $data = Kontak::find($id);
        $params = ['data' => $data];
        return view('admin.kontak.detail', $params);
    }

    public function postStore(Request $request)
    {
        $id = $request->id;
        $kontak = $id ? Kontak::find($id) : new Kontak();
        
        try {
            DB::beginTransaction();
            
            $kontak->nama = $request->nama ?? '';
            $kontak->jabatan = $request->jabatan ?? '';
            $kontak->email = $request->email ?? '';
            $kontak->telepon = $request->telepon ?? '';
            $kontak->alamat = $request->alamat ?? '';
            $kontak->icon = $request->icon ?? null;
            $kontak->urutan = $request->urutan ?? 0;
            $kontak->aktif = $request->has('aktif') ? true : false;
            
            $kontak->save();
            DB::commit();
            
            if($id){
                sendTelegramMessage('Kontak berhasil diupdate');
                CatatLogAktivitas::catatAktivitas('Kontak berhasil diupdate');
                return successAlert('Kontak berhasil diupdate', null, '', '/admin/kontak');
            } else {
                sendTelegramMessage('Kontak berhasil ditambahkan');
                CatatLogAktivitas::catatAktivitas('Kontak berhasil ditambahkan');
                return successAlert('Kontak berhasil ditambahkan', null, '', '/admin/kontak');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return errorAlert('Kontak gagal ' . ($id ? 'diupdate' : 'ditambahkan'), $th->getMessage());
        }
    }

    public function postDelete($id)
    {
        $kontak = Kontak::find($id);
        
        try {
            DB::beginTransaction();
            $kontak->delete();
            DB::commit();
            
            sendTelegramMessage('Kontak berhasil dihapus');
            CatatLogAktivitas::catatAktivitas('Kontak berhasil dihapus');
            return successAlert('Kontak berhasil dihapus', null, '', '/admin/kontak');
        } catch (\Throwable $th) {
            DB::rollBack();
            return errorAlert('Kontak gagal dihapus', $th->getMessage());
        }
    }
    
    public function postToggleStatus($id)
    {
        $kontak = Kontak::find($id);
        
        try {
            DB::beginTransaction();
            $kontak->aktif = !$kontak->aktif;
            $kontak->save();
            DB::commit();
            
            $status = $kontak->aktif ? 'diaktifkan' : 'dinonaktifkan';
            sendTelegramMessage('Kontak berhasil ' . $status);
            CatatLogAktivitas::catatAktivitas('Kontak berhasil ' . $status);
            return successAlert('Kontak berhasil ' . $status);
        } catch (\Throwable $th) {
            DB::rollBack();
            return errorAlert('Kontak gagal diupdate', $th->getMessage());
        }
    }
}
