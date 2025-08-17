<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MataPelajaranController extends Controller
{
    
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

        // Filter berdasarkan semester
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        // Filter berdasarkan status aktif
        if ($request->filled('aktif')) {
            $query->where('aktif', $request->aktif);
        }

        $mataPelajaran = $query->orderBy('urutan')
                              ->orderBy('nama')
                              ->paginate(20);

        $params = ['mataPelajaran' => $mataPelajaran];

        return view('admin.mata-pelajaran.index', $params);
    }

    public function getCreate()
    {
        // Generate kode otomatis
        $kodeOtomatis = $this->generateKode();
        $params = ['kodeOtomatis' => $kodeOtomatis];
        
        return view('admin.mata-pelajaran.create', $params);
    }

    public function postStore(Request $request)
    {
        try {
            DB::beginTransaction();
            DB::table('mata_pelajaran')->insert([
                'nama' => $request->nama,
                'kode' => $request->kode,
                'deskripsi' => $request->deskripsi,
                'jenjang' => $request->jenjang,
                'semester' => $request->semester,
                'sks' => $request->sks ?? 1,
                'urutan' => $request->urutan ?? 0,
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();
            return successAlert('Mata pelajaran berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return errorAlert('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function getShow(string $id)
    {
        $mataPelajaran = DB::table('mata_pelajaran')->where('id', $id)->first();
        
        if (!$mataPelajaran) {
            return errorAlert('Data tidak ditemukan!');
        }

        // Statistik kelas untuk mata pelajaran ini
        $jumlahKelas = DB::table('kelas')
            ->where('mata_pelajaran_id', $id)
            ->count();

        $jumlahSiswa = DB::table('keanggotaan_kelas')
            ->join('kelas', 'keanggotaan_kelas.kelas_id', '=', 'kelas.id')
            ->where('kelas.mata_pelajaran_id', $id)
            ->count();

        $params = [
            'mataPelajaran' => $mataPelajaran,
            'jumlahKelas' => $jumlahKelas,
            'jumlahSiswa' => $jumlahSiswa,
        ];
        return view('admin.mata-pelajaran.show', $params);
    }

    public function getEdit(string $id)
    {
        $mataPelajaran = DB::table('mata_pelajaran')->where('id', $id)->first();
        
        if (!$mataPelajaran) {
            return errorAlert('Data tidak ditemukan!');
        }

        // Statistik kelas untuk mata pelajaran ini
        $jumlahKelas = DB::table('kelas')
            ->where('mata_pelajaran_id', $id)
            ->count();

        $kelasUsage = DB::table('kelas')
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->where('kelas.mata_pelajaran_id', $id)
            ->select('kelas.*', 'tahun_ajaran.nama as tahun_ajaran_nama')
            ->orderBy('kelas.jenjang')
            ->orderBy('kelas.tingkat')
            ->get();

        $params = [
            'mataPelajaran' => $mataPelajaran,
            'jumlahKelas' => $jumlahKelas,
            'kelasUsage' => $kelasUsage
        ];
        return view('admin.mata-pelajaran.edit', $params);
    }

    public function putUpdate(Request $request, string $id)
    {
        try {
            DB::table('mata_pelajaran')
                ->where('id', $id)
                ->update([
                    'nama' => $request->nama,
                    'kode' => $request->kode,
                    'deskripsi' => $request->deskripsi,
                    'jenjang' => $request->jenjang,
                    'semester' => $request->semester,
                    'sks' => $request->sks ?? 1,
                    'urutan' => $request->urutan ?? 0,
                    'updated_at' => now()
                ]);

            return successAlert('Mata pelajaran berhasil diperbarui!');
        } catch (\Exception $e) {
            return errorAlert('Terjadi kesalahan: ' . $e->getMessage());
        }
    }


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

            return successAlert('Mata pelajaran berhasil dihapus!');
        } catch (\Exception $e) {
            return errorAlert('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function postDeleteAction(string $id)
    {
        try {
            // Cek apakah mata pelajaran sedang digunakan
            $kelasCount = DB::table('kelas')->where('mata_pelajaran_id', $id)->count();
            
            if ($kelasCount > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mata pelajaran tidak dapat dihapus karena masih memiliki ' . $kelasCount . ' kelas aktif!'
                ]);
            }

            DB::table('mata_pelajaran')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Mata pelajaran berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function patchToggleStatus(string $id)
    {
        try {
            $mataPelajaran = DB::table('mata_pelajaran')->where('id', $id)->first();
            
            if (!$mataPelajaran) {
                return redirect()->back()->with('error', 'Data tidak ditemukan!');
            }

            $newStatus = !$mataPelajaran->aktif;
            
            DB::table('mata_pelajaran')
                ->where('id', $id)
                ->update([
                    'aktif' => $newStatus,
                    'updated_at' => now()
                ]);

            $statusText = $newStatus ? 'diaktifkan' : 'dinonaktifkan';
            
            return successAlert("Mata pelajaran berhasil {$statusText}!");
        } catch (\Exception $e) {
            return errorAlert('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function getByJenjang($jenjang)
    {
        $mataPelajaran = DB::table('mata_pelajaran')
            ->where('jenjang', $jenjang)
            ->where('aktif', true)
            ->select('id', 'kode', 'nama', 'sks')
            ->orderBy('nama')
            ->get();

        return response()->json($mataPelajaran);
    }

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
