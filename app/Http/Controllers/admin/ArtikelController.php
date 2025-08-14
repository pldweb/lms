<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use function Laravel\Prompts\error;

class ArtikelController extends Controller
{
    public array $roles = ['Admin', 'Guru'];

    public function getIndex()
    {
        $artikel = Artikel::with('penulis')->latest()->get();
        $params = [
            'artikel' => $artikel,
        ];
        return view('admin.artikel.index', $params);
    }

    public function getBerita()
    {
        $artikel = Artikel::berita()->with('penulis')->latest()->get();
        $params = [
            'artikel' => $artikel,
            'jenis' => 'berita'
        ];
        return view('admin.artikel.index', $params);
    }

    public function getPengumuman()
    {
        $artikel = Artikel::pengumuman()->with('penulis')->latest()->get();
        $params = [
            'artikel' => $artikel,
            'jenis' => 'pengumuman'
        ];
        return view('admin.artikel.index', $params);
    }

    public function getCreateBerita()
    {
        $params = ['jenis' => 'berita'];
        return view('admin.artikel.create', $params);
    }

    public function getCreatePengumuman()
    {
        $params = ['jenis' => 'pengumuman'];
        return view('admin.artikel.create', $params);
    }

    public function postStore(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = [
                'jenis' => $request->jenis,
                'judul' => $request->judul,
                'isi' => $request->isi,
                'status' => $request->status,
                'penulis_id' => Auth::id(),
                'tanggal_publish' => null
            ];

            // Handle tanggal publish untuk artikel scheduled
            if ($request->status === 'scheduled') {
                if (!$request->tanggal_publish) {
                    return errorAlert('Tanggal publish harus diisi untuk artikel terjadwal');
                }

                $tanggalPublish = Carbon::parse($request->tanggal_publish);
                if ($tanggalPublish->isPast()) {
                    return errorAlert('Tanggal publish harus lebih dari waktu sekarang');
                }

                $data['tanggal_publish'] = $tanggalPublish;
            } elseif ($request->status === 'publish') {
                $data['tanggal_publish'] = now();
            }

            // Handle upload gambar
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $filename = 'artikel-' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('img/artikel'), $filename);
                $data['gambar'] = $filename;
            }

            $artikel = Artikel::create($data);

            DB::commit();

            $statusMessage = [
                'draft' => 'Artikel berhasil disimpan sebagai draft',
                'publish' => 'Artikel berhasil dipublish',
                'scheduled' => 'Artikel berhasil dijadwalkan untuk dipublish'
            ];

            $redirectUrl = $request->jenis ? "/admin/artikel/{$request->jenis}" : '/admin/artikel';

            return successAlert($statusMessage[$request->status], null, '', $redirectUrl);

        } catch (\Exception $e) {
            DB::rollBack();
            return errorAlert('Terjadi kesalahan saat menyimpan artikel: ' . $e->getMessage());
        }
    }

    public function getDetail($id)
    {
        $artikel = Artikel::with('penulis')->findOrFail($id);
        $params = ['artikel' => $artikel];
        return view('admin.artikel.detail', $params);
    }

    public function getEdit($id)
    {
        $artikel = Artikel::findOrFail($id);
        $params = ['artikel' => $artikel];
        return view('admin.artikel.edit', $params);
    }

    // Update artikel
    public function postUpdate(Request $request, $id)
    {
        $artikel = Artikel::findOrFail($id);

        $data = $request->only(['jenis', 'judul', 'ringkasan', 'isi', 'status']);

        if ($request->status === 'publish' && $artikel->status === 'draft') {
            $data['tanggal_publish'] = now();
        }

        if ($request->hasFile('gambar')) {
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

    public function deleteDestroy($id)
    {
        $artikel = Artikel::findOrFail($id);
        
        if ($artikel->gambar && Storage::disk('public')->exists($artikel->gambar)) {
            Storage::disk('public')->delete($artikel->gambar);
        }

        $jenis = $artikel->jenis;
        $artikel->delete();

        $redirectURL = url('/admin/artikel/' . $jenis);
        return successAlert('Artikel berhasil dihapus', null, '', $redirectURL);
    }

    public function postToggleStatus($id)
    {
        $artikel = Artikel::findOrFail($id);
        Carbon::setLocale('id');
        
        if ($artikel->status === 'draft') {
            $artikel->update([
                'status' => 'publish',
                'tanggal_publish' => Carbon::now()->format('Y-m-d H:i:s')
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
