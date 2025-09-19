<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriGaleri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KategoriGaleriController extends Controller
{
    public function getIndex(Request $request)
    {
        $query = KategoriGaleri::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_kategori', 'LIKE', "%{$search}%")
                    ->orWhere('deskripsi', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $kategoriGaleri = $query
            ->orderBy('urutan')
            ->orderBy('nama_kategori')
            ->paginate(20);

        $params = ['kategoriGaleri' => $kategoriGaleri];
        return view('admin.galeri.kategori.index', $params);
    }

    public function getCreate()
    {

    }

    public function postStore(Request $request)
    {

    }

    public function getShow($id)
    {

    }

    public function getEdit($id)
    {

    }

    public function postDelete($id)
    {

    }
}
