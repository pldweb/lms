<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\PrestasiSekolah;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PrestasiSekolahController extends Controller
{
    public array $roles = ['Admin', 'Guru'];

    public function getIndex()
    {
        $prestasis = PrestasiSekolah::with('penulis')->latest()->get();
        $params = [
            'prestasis' => $prestasis,
        ];
        return view('admin.prestasi-sekolah.index', $params);
    }

    public function getCreate()
    {
        return view('admin.prestasi-sekolah.create');
    }

    public function postStore(Request $request)
    {
        try {
            DB::beginTransaction();

            // Generate slug dari judul
            $slug = Str::slug($request->judul);
            
            // Cek apakah slug sudah ada
            $count = PrestasiSekolah::where('slug', $slug)->count();
            if ($count > 0) {
                $slug = $slug . '-' . ($count + 1);
            }

            $data = [
                'judul' => $request->judul,
                'slug' => $slug,
                'isi' => $request->isi,
                'status' => $request->status,
                'penulis_id' => Auth::id(),
                'tanggal_publish' => null
            ];

            // Handle tanggal publish
            if ($request->status === 'publish') {
                $data['tanggal_publish'] = now();
            }

            // Handle upload gambar
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $filename = 'prestasi-' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('img/prestasi'), $filename);
                $data['gambar'] = $filename;
            }

            $prestasi = PrestasiSekolah::create($data);

            DB::commit();

            $statusMessage = [
                'draft' => 'Prestasi sekolah berhasil disimpan sebagai draft',
                'publish' => 'Prestasi sekolah berhasil dipublish'
            ];

            return successAlert($statusMessage[$request->status], null, '', '/admin/prestasi-sekolah');

        } catch (\Exception $e) {
            DB::rollBack();
            return errorAlert('Terjadi kesalahan saat menyimpan prestasi sekolah: ' . $e->getMessage());
        }
    }

    public function getDetail($id)
    {
        $prestasi = PrestasiSekolah::with('penulis')->findOrFail($id);
        $params = ['prestasi' => $prestasi];
        return view('admin.prestasi-sekolah.detail', $params);
    }

    public function getEdit($id)
    {
        $prestasi = PrestasiSekolah::findOrFail($id);
        $params = ['prestasi' => $prestasi];
        return view('admin.prestasi-sekolah.edit', $params);
    }

    public function postUpdate(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $prestasi = PrestasiSekolah::findOrFail($id);
            
            // Jika judul berubah, update slug
            if ($prestasi->judul != $request->judul) {
                // Generate slug dari judul
                $slug = Str::slug($request->judul);
                
                // Cek apakah slug sudah ada selain prestasi ini
                $count = PrestasiSekolah::where('slug', $slug)->where('id', '!=', $id)->count();
                if ($count > 0) {
                    $slug = $slug . '-' . ($count + 1);
                }
                
                $prestasi->slug = $slug;
            }
            
            $prestasi->judul = $request->judul;
            $prestasi->isi = $request->isi;
            
            // Update status dan tanggal publish
            if ($request->status === 'publish' && $prestasi->status === 'draft') {
                $prestasi->status = 'publish';
                $prestasi->tanggal_publish = now();
            } elseif ($request->status === 'draft') {
                $prestasi->status = 'draft';
            }
            
            // Handle upload gambar
            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($prestasi->gambar) {
                    $oldImagePath = public_path('img/prestasi/' . $prestasi->gambar);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                
                $file = $request->file('gambar');
                $filename = 'prestasi-' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('img/prestasi'), $filename);
                $prestasi->gambar = $filename;
            }
            
            $prestasi->save();
            
            DB::commit();
            
            return successAlert('Prestasi sekolah berhasil diupdate', null, '', '/admin/prestasi-sekolah');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return errorAlert('Terjadi kesalahan saat mengupdate prestasi sekolah: ' . $e->getMessage());
        }
    }

    public function deleteDestroy($id)
    {
        try {
            $prestasi = PrestasiSekolah::findOrFail($id);
            
            // Hapus gambar jika ada
            if ($prestasi->gambar) {
                $imagePath = public_path('img/prestasi/' . $prestasi->gambar);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            
            $prestasi->delete();
            
            return successAlert('Prestasi sekolah berhasil dihapus', null, '', '/admin/prestasi-sekolah');
            
        } catch (\Exception $e) {
            return errorAlert('Terjadi kesalahan saat menghapus prestasi sekolah: ' . $e->getMessage());
        }
    }

    public function postToggleStatus($id)
    {
        $prestasi = PrestasiSekolah::findOrFail($id);
        Carbon::setLocale('id');
        
        if ($prestasi->status === 'draft') {
            $prestasi->update([
                'status' => 'publish',
                'tanggal_publish' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
            $message = 'Prestasi sekolah berhasil dipublish';
        } else {
            $prestasi->update([
                'status' => 'draft',
                'tanggal_publish' => null
            ]);
            $message = 'Prestasi sekolah berhasil dijadikan draft';
        }
        return successAlert($message, null, '', url('/admin/prestasi-sekolah'));
    }
}
