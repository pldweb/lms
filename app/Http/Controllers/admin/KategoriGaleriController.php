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

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_kategori', 'LIKE', "%{$search}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$search}%");
            });
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $kategoriGaleri = $query->orderBy('urutan')
                               ->orderBy('nama_kategori')
                               ->paginate(20);

        $params = ['kategoriGaleri' => $kategoriGaleri];

        return view('admin.kategori-galeri.index', $params);
    }

    public function getCreate()
    {
        return view('admin.kategori-galeri.create');
    }

    public function postStore(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar_cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:aktif,nonaktif',
            'urutan' => 'nullable|integer|min:0'
        ]);

        $data = $request->only(['nama_kategori', 'deskripsi', 'status', 'urutan']);
        $data['slug'] = Str::slug($data['nama_kategori']);

        // Handle file upload
        if ($request->hasFile('gambar_cover')) {
            $file = $request->file('gambar_cover');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/img/kategori-galeri', $filename);
            $data['gambar_cover'] = 'img/kategori-galeri/' . $filename;
        }

        KategoriGaleri::create($data);

        return redirect()->route('admin.kategori-galeri.index')
                        ->with('success', 'Kategori galeri berhasil ditambahkan.');
    }

    public function getShow($id)
    {
        $kategoriGaleri = KategoriGaleri::with('galeri')->findOrFail($id);
        return view('admin.kategori-galeri.show', compact('kategoriGaleri'));
    }

    public function getEdit($id)
    {
        $kategoriGaleri = KategoriGaleri::findOrFail($id);
        return view('admin.kategori-galeri.edit', compact('kategoriGaleri'));
    }

    public function putUpdate(Request $request, $id)
    {
        $kategoriGaleri = KategoriGaleri::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar_cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:aktif,nonaktif',
            'urutan' => 'nullable|integer|min:0'
        ]);

        $data = $request->only(['nama_kategori', 'deskripsi', 'status', 'urutan']);
        $data['slug'] = Str::slug($data['nama_kategori']);

        // Handle file upload
        if ($request->hasFile('gambar_cover')) {
            // Delete old file if exists
            if ($kategoriGaleri->gambar_cover && Storage::exists('public/' . $kategoriGaleri->gambar_cover)) {
                Storage::delete('public/' . $kategoriGaleri->gambar_cover);
            }

            $file = $request->file('gambar_cover');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/img/kategori-galeri', $filename);
            $data['gambar_cover'] = 'img/kategori-galeri/' . $filename;
        }

        $kategoriGaleri->update($data);

        return redirect()->route('admin.kategori-galeri.index')
                        ->with('success', 'Kategori galeri berhasil diperbarui.');
    }

    public function deleteDestroy($id)
    {
        $kategoriGaleri = KategoriGaleri::findOrFail($id);

        // Check if category has galleries
        if ($kategoriGaleri->galeri()->count() > 0) {
            return redirect()->route('admin.kategori-galeri.index')
                            ->with('error', 'Kategori galeri tidak dapat dihapus karena masih memiliki galeri.');
        }

        // Delete file if exists
        if ($kategoriGaleri->gambar_cover && Storage::exists('public/' . $kategoriGaleri->gambar_cover)) {
            Storage::delete('public/' . $kategoriGaleri->gambar_cover);
        }

        $kategoriGaleri->delete();

        return redirect()->route('admin.kategori-galeri.index')
                        ->with('success', 'Kategori galeri berhasil dihapus.');
    }
}