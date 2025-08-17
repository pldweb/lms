<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class KontakController extends Controller
{
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
        return view('admin.kontak.index', compact('kontak'));
    }

    public function getCreate()
    {
        return view('admin.kontak.detail');
    }

    public function getEdit($id)
    {
        $data = Kontak::findOrFail($id);
        return view('admin.kontak.detail', compact('data'));
    }

    public function postStore(Request $request)
    {
        DB::beginTransaction();
        try {
            $kontak = $request->id ? Kontak::findOrFail($request->id) : new Kontak();

            $data = [
                'nama' => $request->nama ?? null,
                'jabatan' => $request->jabatan ?? null,
                'email' => $request->email ?? null,
                'telepon' => $request->telepon ?? null,
                'alamat' => $request->alamat ?? null,
                'icon' => $request->icon ?? null,
                'urutan' => $request->urutan ?? 0,
                'aktif' => $request->has('aktif'),
            ];

            if ($request->id) {
                $kontak->update($data);
            } else {
                Kontak::create($data);
            }

            DB::commit();
            $text = $request->id ? 'Kontak berhasil diperbarui' : 'Kontak berhasil ditambahkan';
            return successAlert($text, null, '#masterData', '/admin/kontak');
        } catch (\Throwable $th) {
            DB::rollBack();
            return errorAlert('Gagal menyimpan kontak: ' . $th->getMessage());
        }
    }

    public function postDeleteAction($id)
    {
        $kontak = Kontak::findOrFail($id);

        try {
            $kontak->delete();
            return successAlert('Berhasil hapus kontak');
        }catch(\Exception $e){
            return errorAlert('Gagal hapus kontak');
        }
    }
}
