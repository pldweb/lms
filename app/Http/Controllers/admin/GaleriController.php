<?php

namespace App\Http\Controllers\admin;

use App\Helper\CatatLogAktivitas;
use App\Http\Controllers\Controller;
use App\Models\KategoriGaleri;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GaleriController extends Controller
{
    public array $roles = ['Admin', 'Guru'];

    public function getKategori()
    {
        $kategori = KategoriGaleri::withCount('galeri')->orderBy('urutan')->get();
        
        $params = [
            'kategori' => $kategori,
        ];
        return view('admin.galeri.kategori.index', $params);
    }

    public function getKategoriCreate()
    {
        return view('admin.galeri.kategori.create');
    }

    public function postKategoriStore(Request $request)
    {

        try {
            DB::beginTransaction();

            $data = [
                'nama_kategori' => $request->nama_kategori,
                'slug' => Str::slug($request->nama_kategori),
                'deskripsi' => $request->deskripsi,
                'status' => $request->status,
                'urutan' => $request->urutan ?? 0
            ];

            // Handle upload gambar cover
            if ($request->hasFile('gambar_cover')) {
                $file = $request->file('gambar_cover');
                $filename = 'kategori-' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('img/galeri/kategori'), $filename);
                $data['gambar_cover'] = $filename;
            }

            $kategori = KategoriGaleri::create($data);

            DB::commit();

            return successAlert('Kategori galeri berhasil disimpan', null, '/admin/galeri/kategori');

        } catch (\Exception $e) {
            DB::rollBack();

            return errorAlert('Terjadi kesalahan saat menyimpan kategori: ' . $e->getMessage());
        }
    }

    public function getKategoriEdit($id)
    {
        $kategori = KategoriGaleri::findOrFail($id);
        
        $params = [
            'kategori' => $kategori,
        ];
        return view('admin.galeri.kategori.edit', $params);
    }

    public function postKategoriUpdate(Request $request, $id)
    {

        try {
            DB::beginTransaction();

            $kategori = KategoriGaleri::findOrFail($id);

            $data = [
                'nama_kategori' => $request->nama_kategori,
                'slug' => Str::slug($request->nama_kategori),
                'deskripsi' => $request->deskripsi,
                'status' => $request->status,
                'urutan' => $request->urutan ?? 0
            ];

            // Handle upload gambar cover
            if ($request->hasFile('gambar_cover')) {
                // Delete old image
                if ($kategori->gambar_cover && file_exists(public_path('img/galeri/kategori/' . $kategori->gambar_cover))) {
                    unlink(public_path('img/galeri/kategori/' . $kategori->gambar_cover));
                }

                $file = $request->file('gambar_cover');
                $filename = 'kategori-' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('img/galeri/kategori'), $filename);
                $data['gambar_cover'] = $filename;
            }

            $kategori->update($data);

            DB::commit();

            return successAlert('Kategori galeri berhasil diupdate', null, '/admin/galeri/kategori');

        } catch (\Exception $e) {
            DB::rollBack();

            return errorAlert('Terjadi kesalahan saat mengupdate kategori: ' . $e->getMessage());
        }
    }

    public function deleteKategori($id)
    {
        try {
            DB::beginTransaction();

            $kategori = KategoriGaleri::findOrFail($id);
            
            // Check if category has galeri items
            if ($kategori->galeri()->count() > 0) {
                return errorAlert('Kategori tidak dapat dihapus karena masih memiliki item galeri');
            }

            // Delete cover image
            if ($kategori->gambar_cover && file_exists(public_path('img/galeri/kategori/' . $kategori->gambar_cover))) {
                unlink(public_path('img/galeri/kategori/' . $kategori->gambar_cover));
            }

            $kategori->delete();

            DB::commit();

            return successAlert('Kategori galeri berhasil dihapus', null, '/admin/galeri/kategori');

        } catch (\Exception $e) {
            DB::rollBack();

            return errorAlert('Terjadi kesalahan saat menghapus kategori: ' . $e->getMessage());
        }
    }


    public function getIndex()
    {
        $galeri = Galeri::with('kategori')->orderBy('kategori_galeri_id')->orderBy('urutan')->get();
        $kategori = KategoriGaleri::aktif()->orderBy('urutan')->get();
        
        $params = [
            'galeri' => $galeri,
            'kategori' => $kategori,
        ];
        return view('admin.galeri.index', $params);
    }

    public function getCreate()
    {
        $kategori = KategoriGaleri::aktif()->orderBy('urutan')->get();
        $params = [
            'kategori' => $kategori,
        ];
        return view('admin.galeri.create', $params);
    }

    public function postStore(Request $request)
    {

        try {
            DB::beginTransaction();

            // Handle multiple photo uploads
            if ($request->hasFile('files')) {
                $urutan = 1;
                foreach ($request->file('files') as $file) {
                    $filename = 'galeri-' . time() . '-' . $urutan . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('img/galeri'), $filename);

                    Galeri::create([
                        'kategori_galeri_id' => $request->kategori_galeri_id,
                        'judul' => $request->judul . ($urutan > 1 ? " ($urutan)" : ''),
                        'deskripsi' => $request->deskripsi,
                        'tipe' => 'foto',
                        'file_path' => $filename,
                        'tanggal_foto' => $request->tanggal_foto,
                        'fotografer' => $request->fotografer,
                        'urutan' => $urutan,
                        'status' => $request->status
                    ]);
                    $urutan++;
                }
            }

            DB::commit();
        
            CatatLogAktivitas::catatAktivitas('Berhasil upload galeri');
            sendTelegramMessage('Berhasil upload galeri');
            return successAlert('Item galeri berhasil disimpan', null, '#message-modal', '/admin/galeri');

        } catch (\Exception $e) {
            DB::rollBack();
            CatatLogAktivitas::catatAktivitas('Gagal upload galeri');
            sendTelegramMessage('Gagal upload galeri');
            return errorAlert('Terjadi kesalahan saat menyimpan galeri: ' . $e->getMessage());
        }
    }

    public function getEdit($id)
    {
        $galeri = Galeri::with('kategori')->findOrFail($id);
        $kategori = KategoriGaleri::aktif()->orderBy('urutan')->get();
        
        $params = [
            'galeri' => $galeri,
            'kategori' => $kategori,
        ];
        return view('admin.galeri.create', $params);
    }

    public function postUpdate(Request $request, $id)
    {  

        try {
            DB::beginTransaction();

            $galeri = Galeri::findOrFail($id);

            $data = [
                'kategori_galeri_id' => $request->kategori_galeri_id,
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'tipe' => 'foto',
                'tanggal_foto' => $request->tanggal_foto,
                'fotografer' => $request->fotografer,
                'urutan' => $request->urutan ?? 0,
                'status' => $request->status
            ];

            // Handle photo upload
            if ($request->hasFile('file')) {
                // Delete old file
                if ($galeri->file_path && file_exists(public_path('img/galeri/' . $galeri->file_path))) {
                    unlink(public_path('img/galeri/' . $galeri->file_path));
                }

                $file = $request->file('file');
                $filename = 'galeri-' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('img/galeri'), $filename);
                $data['file_path'] = $filename;
            }

            $galeri->update($data);

            DB::commit();

            return successAlert('Item galeri berhasil diupdate', null, '#message-modal', '/admin/galeri');

        } catch (\Exception $e) {
            DB::rollBack();

            return errorAlert('Terjadi kesalahan saat mengupdate galeri: ' . $e->getMessage());
        }
    }

    public function postToggleStatus($id)
    {
        try {
            DB::beginTransaction();

            $galeri = Galeri::findOrFail($id);
            $galeri->status = $galeri->status === 'aktif' ? 'nonaktif' : 'aktif';
            $galeri->save();
            DB::commit();

            CatatLogAktivitas::catatAktivitas('Berhasil ubah status galeri');
            sendTelegramMessage('Berhasil ubah status galeri');
            return successAlert('Status galeri berhasil diubah', null, '#message-modal', '/admin/galeri');

        } catch (\Exception $e) {
            DB::rollBack();
            CatatLogAktivitas::catatAktivitas('Gagal ubah status galeri');
            sendTelegramMessage('Gagal ubah status galeri');
            return errorAlert('Terjadi kesalahan saat mengubah status galeri: ' . $e->getMessage());
        }
    }

    public function postDelete($id)
    {
        try {
            DB::beginTransaction();

            $galeri = Galeri::findOrFail($id);

            // Delete file if exists
            if ($galeri->file_path && file_exists(public_path('img/galeri/' . $galeri->file_path))) {
                unlink(public_path('img/galeri/' . $galeri->file_path));
            }

            $galeri->delete();

            DB::commit();
            CatatLogAktivitas::catatAktivitas('Berhasil hapus galeri');
            sendTelegramMessage('Berhasil hapus galeri');

            return successAlert('Item galeri berhasil dihapus', null, '/admin/galeri');

        } catch (\Exception $e) {
            DB::rollBack();
            CatatLogAktivitas::catatAktivitas('Gagal hapus galeri');
            sendTelegramMessage('Gagal hapus galeri');

            return errorAlert('Terjadi kesalahan saat menghapus galeri: ' . $e->getMessage());
        }
    }
}
