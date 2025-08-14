<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MataPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getIndex(Request $request)
    {
        $query = DB::table('mata_pelajaran');

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                  ->orWhere('kode', 'LIKE', "%{$search}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$search}%");
            });
        }

        // Filter berdasarkan jenjang
        if ($request->filled('jenjang')) {
            $query->where('jenjang', $request->jenjang);
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $status = $request->status === 'aktif' ? 1 : 0;
            $query->where('is_active', $status);
        }

        $mataPelajaran = $query->orderBy('jenjang')
                              ->orderBy('nama')
                              ->paginate(20);

        return view('admin.mata-pelajaran.index', compact('mataPelajaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getCreate()
    {
        // Generate kode otomatis
        $kodeOtomatis = $this->generateKode();
        
        return view('admin.mata-pelajaran.create', compact('kodeOtomatis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function postStore(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:20|unique:mata_pelajaran,kode',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'kategori' => 'required|in:wajib,pilihan,muatan_lokal',
            'jenjang' => 'nullable|in:SD,SMP,SMA,SMK',
            'tingkat' => 'nullable|integer|between:1,12',
            'bobot_sks' => 'required|integer|min:1|max:10'
        ]);

        try {
            DB::table('mata_pelajaran')->insert([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'kategori' => $request->kategori,
                'jenjang' => $request->jenjang,
                'tingkat' => $request->tingkat,
                'bobot_sks' => $request->bobot_sks,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return redirect('/admin/mata-pelajaran/')
                ->with('success', 'Mata pelajaran berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function getShow(string $id)
    {
        $mataPelajaran = DB::table('mata_pelajaran')->where('id', $id)->first();
        
        if (!$mataPelajaran) {
            return redirect('/admin/mata-pelajaran/')
                ->with('error', 'Data tidak ditemukan!');
        }

        // Statistik kelas untuk mata pelajaran ini
        $jumlahKelas = DB::table('kelas')
            ->where('mata_pelajaran_id', $id)
            ->count();

        $jumlahSiswa = DB::table('keanggotaan_kelas')
            ->join('kelas', 'keanggotaan_kelas.kelas_id', '=', 'kelas.id')
            ->where('kelas.mata_pelajaran_id', $id)
            ->count();

        return view('admin.mata-pelajaran.show', compact('mataPelajaran', 'jumlahKelas', 'jumlahSiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function getEdit(string $id)
    {
        $mataPelajaran = DB::table('mata_pelajaran')->where('id', $id)->first();
        
        if (!$mataPelajaran) {
            return redirect('/admin/mata-pelajaran/')
                ->with('error', 'Data tidak ditemukan!');
        }

        return view('admin.mata-pelajaran.edit', compact('mataPelajaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function putUpdate(Request $request, string $id)
    {
        $request->validate([
            'kode' => 'required|string|max:20|unique:mata_pelajaran,kode,' . $id,
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
            'kategori' => 'required|in:wajib,pilihan,muatan_lokal',
            'jenjang' => 'nullable|in:SD,SMP,SMA,SMK',
            'tingkat' => 'nullable|integer|between:1,12',
            'bobot_sks' => 'required|integer|min:1|max:10'
        ]);

        try {
            DB::table('mata_pelajaran')
                ->where('id', $id)
                ->update([
                    'kode' => $request->kode,
                    'nama' => $request->nama,
                    'deskripsi' => $request->deskripsi,
                    'kategori' => $request->kategori,
                    'jenjang' => $request->jenjang,
                    'tingkat' => $request->tingkat,
                    'bobot_sks' => $request->bobot_sks,
                    'updated_at' => now()
                ]);

            return redirect('/admin/mata-pelajaran/')
                ->with('success', 'Mata pelajaran berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteDestroy(string $id)
    {
        try {
            // Cek apakah mata pelajaran sedang digunakan
            $kelasCount = DB::table('kelas')->where('mata_pelajaran_id', $id)->count();
            
            if ($kelasCount > 0) {
                return redirect()->back()
                    ->with('error', 'Mata pelajaran tidak dapat dihapus karena masih memiliki ' . $kelasCount . ' kelas aktif!');
            }

            DB::table('mata_pelajaran')->where('id', $id)->delete();

            return redirect('/admin/mata-pelajaran/')
                ->with('success', 'Mata pelajaran berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Toggle status aktif/non-aktif
     */
    public function patchToggleStatus(string $id)
    {
        try {
            $mataPelajaran = DB::table('mata_pelajaran')->where('id', $id)->first();
            
            if (!$mataPelajaran) {
                return redirect()->back()->with('error', 'Data tidak ditemukan!');
            }

            $newStatus = !$mataPelajaran->is_active;
            
            DB::table('mata_pelajaran')
                ->where('id', $id)
                ->update([
                    'is_active' => $newStatus,
                    'updated_at' => now()
                ]);

            $statusText = $newStatus ? 'diaktifkan' : 'dinonaktifkan';
            
            return redirect('/admin/mata-pelajaran/')
                ->with('success', "Mata pelajaran berhasil {$statusText}!");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Ajax endpoint untuk mata pelajaran berdasarkan jenjang
     */
    public function getByJenjang($jenjang)
    {
        $mataPelajaran = DB::table('mata_pelajaran')
            ->where('jenjang', $jenjang)
            ->where('is_active', true)
            ->select('id', 'kode', 'nama', 'bobot_sks')
            ->orderBy('nama')
            ->get();

        return response()->json($mataPelajaran);
    }

    /**
     * Generate kode mata pelajaran otomatis
     */
    private function generateKode($prefix = 'MP')
    {
        $lastRecord = DB::table('mata_pelajaran')
            ->where('kode', 'LIKE', $prefix . '%')
            ->orderBy('kode', 'desc')
            ->first();
        
        if ($lastRecord) {
            $lastNumber = (int) substr($lastRecord->kode, strlen($prefix));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
}
