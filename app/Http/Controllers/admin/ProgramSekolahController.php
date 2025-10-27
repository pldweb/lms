<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramSekolah;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProgramSekolahController extends Controller
{
    public array $roles = ['Admin', 'Guru'];

    public function getIndex()
    {
        $programs = ProgramSekolah::with('penulis')->latest()->get();
        $params = [
            'programs' => $programs,
        ];
        return view('admin.program-sekolah.index', $params);
    }

    public function getCreate()
    {
        return view('admin.program-sekolah.create');
    }

    public function postStore(Request $request)
    {
        try {
            DB::beginTransaction();

            // Generate slug dari judul
            $slug = Str::slug($request->judul);
            
            // Cek apakah slug sudah ada
            $count = ProgramSekolah::where('slug', $slug)->count();
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
                $filename = 'program-' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('img/program'), $filename);
                $data['gambar'] = $filename;
            }

            $program = ProgramSekolah::create($data);

            DB::commit();

            $statusMessage = [
                'draft' => 'Program sekolah berhasil disimpan sebagai draft',
                'publish' => 'Program sekolah berhasil dipublish'
            ];

            return successAlert($statusMessage[$request->status], null, '', '/admin/program-sekolah');

        } catch (\Exception $e) {
            DB::rollBack();
            return errorAlert('Terjadi kesalahan saat menyimpan program sekolah: ' . $e->getMessage());
        }
    }

    public function getDetail($id)
    {
        $program = ProgramSekolah::with('penulis')->findOrFail($id);
        $params = ['program' => $program];
        return view('admin.program-sekolah.detail', $params);
    }

    public function getEdit($id)
    {
        $program = ProgramSekolah::findOrFail($id);
        $params = ['program' => $program];
        return view('admin.program-sekolah.edit', $params);
    }

    public function postUpdate(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $program = ProgramSekolah::findOrFail($id);
            
            // Jika judul berubah, update slug
            if ($program->judul != $request->judul) {
                // Generate slug dari judul
                $slug = Str::slug($request->judul);
                
                // Cek apakah slug sudah ada selain program ini
                $count = ProgramSekolah::where('slug', $slug)->where('id', '!=', $id)->count();
                if ($count > 0) {
                    $slug = $slug . '-' . ($count + 1);
                }
                
                $program->slug = $slug;
            }
            
            $program->judul = $request->judul;
            $program->isi = $request->isi;
            
            // Update status dan tanggal publish
            if ($request->status === 'publish' && $program->status === 'draft') {
                $program->status = 'publish';
                $program->tanggal_publish = now();
            } elseif ($request->status === 'draft') {
                $program->status = 'draft';
            }
            
            // Handle upload gambar
            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($program->gambar) {
                    $oldImagePath = public_path('img/program/' . $program->gambar);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
                
                $file = $request->file('gambar');
                $filename = 'program-' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('img/program'), $filename);
                $program->gambar = $filename;
            }
            
            $program->save();
            
            DB::commit();
            
            return successAlert('Program sekolah berhasil diupdate', null, '', '/admin/program-sekolah');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return errorAlert('Terjadi kesalahan saat mengupdate program sekolah: ' . $e->getMessage());
        }
    }

    public function deleteDestroy($id)
    {
        try {
            $program = ProgramSekolah::findOrFail($id);
            
            // Hapus gambar jika ada
            if ($program->gambar) {
                $imagePath = public_path('img/program/' . $program->gambar);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            
            $program->delete();
            
            return successAlert('Program sekolah berhasil dihapus', null, '', '/admin/program-sekolah');
            
        } catch (\Exception $e) {
            return errorAlert('Terjadi kesalahan saat menghapus program sekolah: ' . $e->getMessage());
        }
    }

    public function postToggleStatus($id)
    {
        $program = ProgramSekolah::findOrFail($id);
        Carbon::setLocale('id');
        
        if ($program->status === 'draft') {
            $program->update([
                'status' => 'publish',
                'tanggal_publish' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
            $message = 'Program sekolah berhasil dipublish';
        } else {
            $program->update([
                'status' => 'draft',
                'tanggal_publish' => null
            ]);
            $message = 'Program sekolah berhasil dijadikan draft';
        }
        return successAlert($message, null, '', url('/admin/program-sekolah'));
    }
}
