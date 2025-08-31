<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Halaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HalamanController extends Controller
{
    public array $roles = ['Admin', 'Guru'];

    public function getIndex()
    {
        $halaman = Halaman::with('penulis')->latest()->get();
        $params = [
            'halaman' => $halaman,
        ];
        return view('admin.halaman.index', $params);
    }

    public function getCreate()
    {
        return view('admin.halaman.create');
    }

    public function postStore(Request $request)
    {
        try {
            DB::beginTransaction();

            // Generate slug dari judul
            $slug = Str::slug($request->judul);
            
            // Cek apakah slug sudah ada
            $count = Halaman::where('slug', $slug)->count();
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

            $halaman = Halaman::create($data);

            DB::commit();

            $statusMessage = [
                'draft' => 'Halaman berhasil disimpan sebagai draft',
                'publish' => 'Halaman berhasil dipublish'
            ];

            return successAlert($statusMessage[$request->status], null, '', '/admin/halaman');

        } catch (\Exception $e) {
            DB::rollBack();
            return errorAlert('Terjadi kesalahan saat menyimpan halaman: ' . $e->getMessage());
        }
    }

    public function getDetail($id)
    {
        $halaman = Halaman::with('penulis')->findOrFail($id);
        $params = ['halaman' => $halaman];
        return view('admin.halaman.detail', $params);
    }

    public function getEdit($id)
    {
        $halaman = Halaman::findOrFail($id);
        $params = ['halaman' => $halaman];
        return view('admin.halaman.edit', $params);
    }

    public function postUpdate(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $halaman = Halaman::findOrFail($id);
            
            // Jika judul berubah, update slug
            if ($halaman->judul != $request->judul) {
                // Generate slug dari judul
                $slug = Str::slug($request->judul);
                
                // Cek apakah slug sudah ada selain halaman ini
                $count = Halaman::where('slug', $slug)->where('id', '!=', $id)->count();
                if ($count > 0) {
                    $slug = $slug . '-' . ($count + 1);
                }
                
                $halaman->slug = $slug;
            }
            
            $halaman->judul = $request->judul;
            $halaman->isi = $request->isi;
            
            // Update status dan tanggal publish
            if ($request->status === 'publish' && $halaman->status === 'draft') {
                $halaman->status = 'publish';
                $halaman->tanggal_publish = now();
            } elseif ($request->status === 'draft') {
                $halaman->status = 'draft';
            }
            
            // Handle upload gambar
            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($halaman->gambar) {
                    $oldImagePath = public_path('img/halaman/' . $halaman->gambar);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                
                $file = $request->file('gambar');
                $filename = 'halaman-' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('img/halaman'), $filename);
                $halaman->gambar = $filename;
            }
            
            $halaman->save();
            
            DB::commit();
            
            return successAlert('Halaman berhasil diupdate', null, '', '/admin/halaman');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return errorAlert('Terjadi kesalahan saat mengupdate halaman: ' . $e->getMessage());
        }
    }

    public function deleteDestroy($id)
    {
        try {
            $halaman = Halaman::findOrFail($id);
            
            // Hapus gambar jika ada
            if ($halaman->gambar) {
                $imagePath = public_path('img/halaman/' . $halaman->gambar);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            
            $halaman->delete();
            
            return successAlert('Halaman berhasil dihapus', null, '', '/admin/halaman');
            
        } catch (\Exception $e) {
            return errorAlert('Terjadi kesalahan saat menghapus halaman: ' . $e->getMessage());
        }
    }

    public function postToggleStatus($id)
    {
        $halaman = Halaman::findOrFail($id);
        Carbon::setLocale('id');
        
        if ($halaman->status === 'draft') {
            $halaman->update([
                'status' => 'publish',
                'tanggal_publish' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
            $message = 'Halaman berhasil dipublish';
        } else {
            $halaman->update([
                'status' => 'draft',
                'tanggal_publish' => null
            ]);
            $message = 'Halaman berhasil dijadikan draft';
        }
        return successAlert($message, null, '', url('/admin/halaman'));
    }
}
