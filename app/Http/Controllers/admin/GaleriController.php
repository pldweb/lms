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

    public function postKategoriSave(Request $request)
    {
    
        $id = $request->id;
        $kategori = KategoriGaleri::find($id) ?? new KategoriGaleri();

        DB::beginTransaction();
        try {
            $kategori->nama_kategori = $request->nama_kategori;
            $kategori->slug = Str::slug($request->nama_kategori);
            $kategori->deskripsi = $request->deskripsi;
            $kategori->status = $request->status;
            $kategori->urutan = $request->urutan ?? 0;

            if ($request->hasFile('gambar_cover')) {
                // Hapus file lama kalau ada
                if ($kategori->gambar_cover && file_exists(public_path('img/galeri/kategori/' . $kategori->gambar_cover))) {
                    @unlink(public_path('img/galeri/kategori/' . $kategori->gambar_cover));
                }

                $file = $request->file('gambar_cover');
                $filename = 'kategori-' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('img/galeri/kategori'), $filename);
                $kategori->gambar_cover = $filename;
            }

            $kategori->save();
            DB::commit();
            sendTelegramMessage('Kategori galeri ' . $kategori->nama_kategori . ' berhasil disimpan');
            CatatLogAktivitas::catatAktivitas('Kategori galeri ' . $kategori->nama_kategori . ' berhasil disimpan');
            return successAlert('Kategori galeri berhasil disimpan', null, '', '/admin/galeri/kategori');

        } catch (\Exception $e) {
            DB::rollBack();
            sendTelegramMessage('Terjadi kesalahan saat menyimpan kategori: ' . $e->getMessage());
            CatatLogAktivitas::catatAktivitas('Terjadi kesalahan saat menyimpan kategori');
            return errorAlert('Terjadi kesalahan saat menyimpan kategori: ' . $e->getMessage());
        }
    }

    public function getKategoriEdit($id)
    {
        $kategori = KategoriGaleri::findOrFail($id);

        $params = [
            'kategori' => $kategori,
        ];
        return view('admin.galeri.kategori.create', $params);
    }

    public function deleteKategori($id)
    {
        try {
            DB::beginTransaction();

            $kategori = KategoriGaleri::findOrFail($id);

            if ($kategori->galeri()->count() > 0) {
                return errorAlert('Kategori tidak dapat dihapus karena masih memiliki item galeri');
            }

            if ($kategori->gambar_cover && file_exists(public_path('img/galeri/kategori/' . $kategori->gambar_cover))) {
                unlink(public_path('img/galeri/kategori/' . $kategori->gambar_cover));
            }

            sendTelegramMessage('Kategori galeri ' . $kategori->nama_kategori . ' berhasil dihapus');
            CatatLogAktivitas::catatAktivitas('Kategori galeri ' . $kategori->nama_kategori . ' berhasil dihapus');
            $kategori->delete();
            DB::commit();
            return successAlert('Kategori galeri berhasil dihapus', null, '/admin/galeri/kategori');

        } catch (\Exception $e) {
            DB::rollBack();
            sendTelegramMessage('Terjadi kesalahan saat menghapus kategori: ' . $e->getMessage());
            CatatLogAktivitas::catatAktivitas('Terjadi kesalahan saat menghapus kategori');
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

    public function getCreate(Request $request)
    {
        $kategori_id = $request->query('kategori_id');
        
        // Jika tidak ada kategori_id, redirect ke halaman index
        if (!$kategori_id) {
            return redirect('/admin/galeri')->with('error', 'Silahkan pilih kategori terlebih dahulu');
        }
        
        $kategori_terpilih = KategoriGaleri::findOrFail($kategori_id);
        $kategori = KategoriGaleri::aktif()->orderBy('urutan')->get();
        
        $params = [
            'kategori' => $kategori,
            'kategori_terpilih' => $kategori_terpilih,
        ];
        return view('admin.galeri.create', $params);
    }

    public function postGaleriSave(Request $request)
    {
        $id = $request->id;
        $isUpdate = !empty($id);

        try {
            DB::beginTransaction();

            // Get selected images from file manager
            $selectedImages = json_decode($request->selected_images, true) ?? [];
            
            // selectedImages sudah berupa array of image paths dari JavaScript
            $imagePaths = $selectedImages;

            // === MODE UPDATE ===
            if ($isUpdate) {
                $galeri = Galeri::findOrFail($id);
                
                // Update first image if new images are selected
                if (count($imagePaths) > 0) {
                    $galeri->fill([
                        'kategori_galeri_id' => $request->kategori_galeri_id,
                        'judul'              => $request->judul,
                        'deskripsi'          => $request->deskripsi,
                        'tanggal_foto'       => $request->tanggal_foto,
                        'status'             => $request->status,
                        'file_path'          => $imagePaths[0] // Use first selected image
                    ]);
                    
                    $galeri->save();

                    // Create additional gallery items for remaining images
                    if (count($imagePaths) > 1) {
                        $newData = [];
                        foreach (array_slice($imagePaths, 1) as $index => $imagePath) {
                            $newData[] = [
                                'kategori_galeri_id' => $request->kategori_galeri_id,
                                'judul'              => $request->judul . ' (' . ($index + 2) . ')',
                                'deskripsi'          => $request->deskripsi,
                                'tanggal_foto'       => $request->tanggal_foto,
                                'status'             => $request->status,
                                'file_path'          => $imagePath,
                                'created_at'         => now(),
                                'updated_at'         => now(),
                            ];
                        }
                        Galeri::insert($newData);
                    }
                } else {
                    // Update without changing images
                    $galeri->fill([
                        'kategori_galeri_id' => $request->kategori_galeri_id,
                        'judul'              => $request->judul,
                        'deskripsi'          => $request->deskripsi,
                        'tanggal_foto'       => $request->tanggal_foto,
                        'status'             => $request->status,
                    ]);
                    $galeri->save();
                }
            } 
            // === MODE CREATE BARU (MULTIPLE) ===
            else {
                if (count($imagePaths) > 0) {
                    $newData = [];
                    foreach ($imagePaths as $index => $imagePath) {
                        $newData[] = [
                            'kategori_galeri_id' => $request->kategori_galeri_id,
                            'judul'              => $request->judul . ($index > 0 ? " (" . ($index + 1) . ")" : ""),
                            'deskripsi'          => $request->deskripsi,
                            'tanggal_foto'       => $request->tanggal_foto,
                            'status'             => $request->status,
                            'file_path'          => $imagePath,
                            'created_at'         => now(),
                            'updated_at'         => now(),
                        ];
                    }
                    Galeri::insert($newData); // Bulk insert
                }
            }

            DB::commit();

            $pesan = $isUpdate ? "Galeri berhasil diupdate" : "Galeri berhasil diupload";
            CatatLogAktivitas::catatAktivitas($pesan);
            sendTelegramMessage($pesan);

            return successAlert('Berhasil', null, '#message-modal', '', '/admin/galeri');

        } catch (\Exception $e) {
            DB::rollBack();
            $pesan = $isUpdate ? "Gagal update galeri" : "Gagal upload galeri";
            CatatLogAktivitas::catatAktivitas($pesan . ': ' . $e->getMessage());
            sendTelegramMessage($pesan);
            return errorAlert('Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function getEdit($id)
    {
        $galeri = Galeri::with('kategori')->findOrFail($id);
        $kategori = KategoriGaleri::aktif()->orderBy('urutan')->get();
        $kategori_terpilih = $galeri->kategori;
        
        $params = [
            'galeri' => $galeri,
            'kategori' => $kategori,
            'kategori_terpilih' => $kategori_terpilih,
        ];
        return view('admin.galeri.create', $params);
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

            return successAlert('Item galeri berhasil dihapus', null, '', '/admin/galeri');

        } catch (\Exception $e) {
            DB::rollBack();
            CatatLogAktivitas::catatAktivitas('Gagal hapus galeri');
            sendTelegramMessage('Gagal hapus galeri');

            return errorAlert('Terjadi kesalahan saat menghapus galeri: ' . $e->getMessage());
        }
    }

    public function deleteIndividualImage(Request $request)
    {
        $id = $request->id;
        $imageIndex = $request->image_index;
        
        try {
            DB::beginTransaction();

            $galeri = Galeri::findOrFail($id);
            
            // Parse existing images
            $images = json_decode($galeri->images_data, true) ?? [];
            
            // Fallback jika images_data kosong tapi ada file_path
            if (empty($images) && $galeri->file_path) {
                $images = [$galeri->file_path];
            }
            
            if (!isset($images[$imageIndex])) {
                return response()->json(['success' => false, 'message' => 'Gambar tidak ditemukan']);
            }
            
            // Remove image from array
            array_splice($images, $imageIndex, 1);
            
            // Update data
            if (count($images) > 0) {
                $galeri->images_data = json_encode($images);
                $galeri->file_path = $images[0]; // Update main image path
            } else {
                $galeri->images_data = null;
                $galeri->file_path = null;
            }
            
            $galeri->save();

            DB::commit();
            
            return response()->json(['success' => true, 'message' => 'Gambar berhasil dihapus']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function replaceIndividualImage(Request $request)
    {
        $id = $request->id;
        $imageIndex = $request->image_index;
        $newImagePath = $request->new_image_path;
        
        try {
            DB::beginTransaction();

            $galeri = Galeri::findOrFail($id);
            
            // Parse existing images
            $images = json_decode($galeri->images_data, true) ?? [];
            
            // Fallback jika images_data kosong tapi ada file_path
            if (empty($images) && $galeri->file_path) {
                $images = [$galeri->file_path];
            }
            
            if (!isset($images[$imageIndex])) {
                return response()->json(['success' => false, 'message' => 'Gambar tidak ditemukan']);
            }
            
            // Replace image
            $images[$imageIndex] = $newImagePath;
            
            // Update data
            $galeri->images_data = json_encode($images);
            if ($imageIndex === 0) {
                $galeri->file_path = $newImagePath; // Update main image if replacing first image
            }
            
            $galeri->save();

            DB::commit();
            
            return response()->json(['success' => true, 'message' => 'Gambar berhasil diganti', 'new_path' => $newImagePath]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
