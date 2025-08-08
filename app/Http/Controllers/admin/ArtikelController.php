<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
    public array $roles = ['Admin', 'Guru'];

    // Halaman daftar semua artikel
    public function getIndex()
    {
        $artikel = Artikel::with('penulis')->latest()->get();
        $params = [
            'artikel' => $artikel,
        ];
        return view('admin.artikel.index', $params);
    }

    // Halaman daftar berita
    public function getBerita()
    {
        $artikel = Artikel::berita()->with('penulis')->latest()->get();
        $params = [
            'artikel' => $artikel,
            'jenis' => 'berita'
        ];
        return view('admin.artikel.index', $params);
    }

    // Halaman daftar pengumuman
    public function getPengumuman()
    {
        $artikel = Artikel::pengumuman()->with('penulis')->latest()->get();
        $params = [
            'artikel' => $artikel,
            'jenis' => 'pengumuman'
        ];
        return view('admin.artikel.index', $params);
    }

    // Halaman form tambah artikel
    public function getCreate()
    {
        return view('admin.artikel.create');
    }

    // Halaman form tambah berita
    public function getCreateBerita()
    {
        $params = [
            'jenis' => 'berita'
        ];
        return view('admin.artikel.create', $params);
    }

    // Halaman form tambah pengumuman
    public function getCreatePengumuman()
    {
        $params = [
            'jenis' => 'pengumuman'
        ];
        return view('admin.artikel.create', $params);
    }

    // Simpan artikel baru
    public function postStore(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:berita,pengumuman',
            'judul' => 'required|string|max:255',
            'ringkasan' => 'nullable|string',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,publish'
        ]);

        $data = $request->only(['jenis', 'judul', 'ringkasan', 'isi', 'status']);
        $data['penulis_id'] = Auth::id();

        if ($request->status === 'publish') {
            $data['tanggal_publish'] = now();
        }

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('artikel', $fileName, 'public');
            $data['gambar'] = $filePath;
        }

        Artikel::create($data);

        $redirectURL = url('/admin/artikel/' . $request->jenis);
        return successAlert('Artikel berhasil disimpan', null, '', $redirectURL);
    }

    // Halaman detail artikel
    public function getDetail($id)
    {
        $artikel = Artikel::with('penulis')->findOrFail($id);
        $params = [
            'artikel' => $artikel
        ];
        return view('admin.artikel.detail', $params);
    }

    // Halaman edit artikel
    public function getEdit($id)
    {
        $artikel = Artikel::findOrFail($id);
        $params = [
            'artikel' => $artikel
        ];
        return view('admin.artikel.edit', $params);
    }

    // Update artikel
    public function putUpdate(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id);

        $request->validate([
            'jenis' => 'required|in:berita,pengumuman',
            'judul' => 'required|string|max:255',
            'ringkasan' => 'nullable|string',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,publish'
        ]);

        $data = $request->only(['jenis', 'judul', 'ringkasan', 'isi', 'status']);

        // Update tanggal publish jika status berubah ke publish
        if ($request->status === 'publish' && $artikel->status === 'draft') {
            $data['tanggal_publish'] = now();
        }

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($artikel->gambar && Storage::disk('public')->exists($artikel->gambar)) {
                Storage::disk('public')->delete($artikel->gambar);
            }

            $file = $request->file('gambar');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('artikel', $fileName, 'public');
            $data['gambar'] = $filePath;
        }

        $artikel->update($data);

        $redirectURL = url('/admin/artikel/' . $artikel->jenis);
        return successAlert('Artikel berhasil diupdate', null, '', $redirectURL);
    }

    // Hapus artikel
    public function deleteDestroy($id)
    {
        $artikel = Artikel::findOrFail($id);
        
        // Hapus gambar jika ada
        if ($artikel->gambar && Storage::disk('public')->exists($artikel->gambar)) {
            Storage::disk('public')->delete($artikel->gambar);
        }

        $jenis = $artikel->jenis;
        $artikel->delete();

        $redirectURL = url('/admin/artikel/' . $jenis);
        return successAlert('Artikel berhasil dihapus', null, '', $redirectURL);
    }

    // Toggle status publish/draft
    public function postToggleStatus($id)
    {
        $artikel = Artikel::findOrFail($id);
        
        if ($artikel->status === 'draft') {
            $artikel->update([
                'status' => 'publish',
                'tanggal_publish' => now()
            ]);
            $message = 'Artikel berhasil dipublish';
        } else {
            $artikel->update([
                'status' => 'draft',
                'tanggal_publish' => null
            ]);
            $message = 'Artikel berhasil dijadikan draft';
        }

        return successAlert($message, null, '', url('/admin/artikel/' . $artikel->jenis));
    }
}
