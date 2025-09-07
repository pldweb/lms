<?php

namespace App\Http\Controllers\admin;

use App\Helper\CatatLogAktivitas;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriArtikel;
use Illuminate\Support\Facades\DB;

class KategoriArtikelController extends Controller
{
    public function getIndex()
    {
        $kategori = KategoriArtikel::all();
        return view('admin.kategori-artikel.index', compact('kategori'));
    }

    public function getCreate(Request $request)
    {
        $data = KategoriArtikel::find($request->id);
        return view('admin.kategori-artikel.create', compact('data'));
    }

    public function postStore(Request $request)
    {
        $id = KategoriArtikel::find($request->id);

        $kategori = $id ? KategoriArtikel::find($id) : new KategoriArtikel;
        try {
            DB::beginTransaction();
            $kategori->nama = $request->nama;
            $kategori->slug = strtolower(str_replace(' ', '-', $request->nama));
            $kategori->save();
            DB::commit();
            if($id){
                sendTelegramMessage('Kategori artikel berhasil diupdate');
            }else{
                sendTelegramMessage('Kategori artikel berhasil ditambahkan');
            }
            CatatLogAktivitas::catatAktivitas($id ? 'Kategori artikel berhasil diupdate' : 'Kategori artikel berhasil ditambahkan');
            return successAlert($id ? 'Kategori artikel berhasil diupdate' : 'Kategori artikel berhasil ditambahkan');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return errorAlert('Kategori artikel gagal ditambahkan');
        }
    }

    public function postDelete($id)
    {
        $kategori = KategoriArtikel::find($id);
        try {
            DB::beginTransaction();
            $kategori->delete();
            DB::commit();
            sendTelegramMessage('Kategori artikel berhasil dihapus');
            CatatLogAktivitas::catatAktivitas('Kategori artikel berhasil dihapus');
            return successAlert('Kategori artikel berhasil dihapus');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return errorAlert('Kategori artikel gagal dihapus');
        }
    }

    public function getDetail($id)
    {
        $data = KategoriArtikel::find($id);
        return view('admin.kategori-artikel.create', compact('data'));
    }

    public function getSelect2(Request $request)
    {
        $kategori = KategoriArtikel::where('nama', 'like', '%'.$request->q.'%')->get();
        return response()->json($kategori);
    }
}
