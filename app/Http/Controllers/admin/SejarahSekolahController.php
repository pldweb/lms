<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SejarahSekolah;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SejarahSekolahController extends Controller
{
    public array $roles = ['Admin', 'Guru'];

    public function getIndex()
    {
        $sejarahs = SejarahSekolah::with('penulis')->latest()->get();
        $params = [
            'sejarahs' => $sejarahs,
        ];
        return view('admin.sejarah-sekolah.index', $params);
    }

    public function getCreate()
    {
        return view('admin.sejarah-sekolah.create');
    }

    public function postStore(Request $request)
    {
        try {
            DB::beginTransaction();

            // Generate slug dari judul
            $slug = Str::slug($request->judul);
            
            // Cek apakah slug sudah ada
            $count = SejarahSekolah::where('slug', $slug)->count();
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
                $filename = 'sejarah-' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('img/sejarah'), $filename);
                $data['gambar'] = $filename;
            }

            $sejarah = SejarahSekolah::create($data);

            DB::commit();

            $statusMessage = [
                'draft' => 'Sejarah sekolah berhasil disimpan sebagai draft',
                'publish' => 'Sejarah sekolah berhasil dipublish'
            ];

            return successAlert($statusMessage[$request->status], null, '', '/admin/sejarah-sekolah');

        } catch (\Exception $e) {
            DB::rollBack();
            return errorAlert('Terjadi kesalahan saat menyimpan sejarah sekolah: ' . $e->getMessage());
        }
    }

    public function getDetail($id)
    {
        $sejarah = SejarahSekolah::with('penulis')->findOrFail($id);
        $params = ['sejarah' => $sejarah];
        return view('admin.sejarah-sekolah.detail', $params);
    }

    public function getEdit($id)
    {
        $sejarah = SejarahSekolah::findOrFail($id);
        $params = ['sejarah' => $sejarah];
        return view('admin.sejarah-sekolah.edit', $params);
    }

    public function postUpdate(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $sejarah = SejarahSekolah::findOrFail($id);
            
            // Jika judul berubah, update slug
            if ($sejarah->judul != $request->judul) {
                // Generate slug dari judul
                $slug = Str::slug($request->judul);
                
                // Cek apakah slug sudah ada selain sejarah ini
                $count = SejarahSekolah::where('slug', $slug)->where('id', '!=', $id)->count();
                if ($count > 0) {
                    $slug = $slug . '-' . ($count + 1);
                }
                
                $sejarah->slug = $slug;
            }
            
            $sejarah->judul = $request->judul;
            $sejarah->isi = $request->isi;
            
            // Update status dan tanggal publish
            if ($request->status === 'publish' && $sejarah->status === 'draft') {
                $sejarah->status = 'publish';
                $sejarah->tanggal_publish = now();
            } elseif ($request->status === 'draft') {
                $sejarah->status = 'draft';
            }
            
            // Handle upload gambar
            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($sejarah->gambar) {
                    $oldImagePath = public_path('img/sejarah/' . $sejarah->gambar);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                
                $file = $request->file('gambar');
                $filename = 'sejarah-' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('img/sejarah'), $filename);
                $sejarah->gambar = $filename;
            }
            
            $sejarah->save();
            
            DB::commit();
            
            return successAlert('Sejarah sekolah berhasil diupdate', null, '', '/admin/sejarah-sekolah');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return errorAlert('Terjadi kesalahan saat mengupdate sejarah sekolah: ' . $e->getMessage());
        }
    }

    public function deleteDestroy($id)
    {
        try {
            $sejarah = SejarahSekolah::findOrFail($id);
            
            // Hapus gambar jika ada
            if ($sejarah->gambar) {
                $imagePath = public_path('img/sejarah/' . $sejarah->gambar);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            
            $sejarah->delete();
            
            return successAlert('Sejarah sekolah berhasil dihapus', null, '', '/admin/sejarah-sekolah');
            
        } catch (\Exception $e) {
            return errorAlert('Terjadi kesalahan saat menghapus sejarah sekolah: ' . $e->getMessage());
        }
    }

    public function postToggleStatus($id)
    {
        $sejarah = SejarahSekolah::findOrFail($id);
        Carbon::setLocale('id');
        
        if ($sejarah->status === 'draft') {
            $sejarah->update([
                'status' => 'publish',
                'tanggal_publish' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
            $message = 'Sejarah sekolah berhasil dipublish';
        } else {
            $sejarah->update([
                'status' => 'draft',
                'tanggal_publish' => null
            ]);
            $message = 'Sejarah sekolah berhasil dijadikan draft';
        }
        return successAlert($message, null, '', url('/admin/sejarah-sekolah'));
    }
}
