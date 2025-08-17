<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NilaiSiswaController extends Controller
{
    public function getIndex(Request $request)
    {
        $query = DB::table('nilai_siswa')
            ->join('users', 'nilai_siswa.siswa_id', '=', 'users.id')
            ->join('kelas', 'nilai_siswa.kelas_id', '=', 'kelas.id')
            ->join('mata_pelajaran', 'nilai_siswa.mata_pelajaran_id', '=', 'mata_pelajaran.id')
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->select(
                'nilai_siswa.*',
                'users.nama as siswa_nama',
                'users.email as siswa_email',
                'kelas.nama as kelas_nama',
                'kelas.jenjang',
                'kelas.tingkat',
                'mata_pelajaran.nama as mata_pelajaran_nama',
                'mata_pelajaran.kode as mata_pelajaran_kode',
                'tahun_ajaran.nama as tahun_ajaran_nama'
            );

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('users.nama', 'LIKE', "%{$search}%")
                  ->orWhere('mata_pelajaran.nama', 'LIKE', "%{$search}%")
                  ->orWhere('kelas.nama', 'LIKE', "%{$search}%");
            });
        }

        // Filter berdasarkan kelas
        if ($request->filled('kelas_id')) {
            $query->where('nilai_siswa.kelas_id', $request->kelas_id);
        }

        // Filter berdasarkan mata pelajaran
        if ($request->filled('mata_pelajaran_id')) {
            $query->where('nilai_siswa.mata_pelajaran_id', $request->mata_pelajaran_id);
        }

        // Filter berdasarkan jenis nilai
        if ($request->filled('jenis_nilai')) {
            $query->where('nilai_siswa.jenis_nilai', $request->jenis_nilai);
        }

        // Filter berdasarkan semester
        if ($request->filled('semester')) {
            $query->where('nilai_siswa.semester', $request->semester);
        }

        // Filter berdasarkan tahun ajaran
        if ($request->filled('tahun_ajaran_id')) {
            $query->where('kelas.tahun_ajaran_id', $request->tahun_ajaran_id);
        }

        $nilaiSiswa = $query->orderBy('nilai_siswa.tanggal_nilai', 'desc')
                           ->orderBy('users.nama')
                           ->paginate(20);

        // Data untuk filter
        $kelas = DB::table('kelas')
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->select('kelas.id', 'kelas.nama', 'kelas.jenjang', 'kelas.tingkat', 'tahun_ajaran.nama as tahun_ajaran')
            ->orderBy('kelas.jenjang')
            ->orderBy('kelas.tingkat')
            ->get();

        $mataPelajaran = DB::table('mata_pelajaran')
            ->select('id', 'nama', 'kode')
            ->orderBy('nama')
            ->get();

        $tahunAjaran = DB::table('tahun_ajaran')
            ->select('id', 'nama')
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        return view('admin.nilai-siswa.index', compact('nilaiSiswa', 'kelas', 'mataPelajaran', 'tahunAjaran'));
    }

    public function getCreate(Request $request)
    {
        // Data untuk dropdown
        $kelas = DB::table('kelas')
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            
            ->select('kelas.id', 'kelas.nama', 'kelas.jenjang', 'kelas.tingkat', 'tahun_ajaran.nama as tahun_ajaran')
            ->orderBy('kelas.jenjang')
            ->orderBy('kelas.tingkat')
            ->get();

        $mataPelajaran = DB::table('mata_pelajaran')
            ->select('id', 'nama', 'kode')
            ->orderBy('nama')
            ->get();

        // Siswa berdasarkan kelas yang dipilih
        $siswa = collect();
        if ($request->filled('kelas_id')) {
            $siswa = DB::table('keanggotaan_kelas')
                ->join('users', 'keanggotaan_kelas.siswa_id', '=', 'users.id')
                ->where('keanggotaan_kelas.kelas_id', $request->kelas_id)
                ->select('users.id', 'users.nama', 'users.email')
                ->orderBy('users.nama')
                ->get();
        }

        $selectedKelasId = $request->get('kelas_id');
        $selectedSiswaId = $request->get('siswa_id');
        $selectedMataPelajaranId = $request->get('mata_pelajaran_id');

        return view('admin.nilai-siswa.create', compact('kelas', 'mataPelajaran', 'siswa', 'selectedKelasId', 'selectedSiswaId', 'selectedMataPelajaranId'));
    }

    public function postStore(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:users,id',
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'jenis_nilai' => 'required|in:UTS,UAS,Tugas,Kuis,Praktik,Lainnya',
            'nilai' => 'required|numeric|min:0|max:100',
            'tanggal_nilai' => 'required|date',
            'semester' => 'required|in:Ganjil,Genap',
            'keterangan' => 'nullable|string|max:500'
        ]);

        try {
            // Validasi siswa ada di kelas
            $keanggotaan = DB::table('keanggotaan_kelas')
                ->where('siswa_id', $request->siswa_id)
                ->where('kelas_id', $request->kelas_id)
                ->exists();

            if (!$keanggotaan) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Siswa tidak terdaftar di kelas yang dipilih!');
            }

            // Cek duplikasi nilai
            $existingNilai = DB::table('nilai_siswa')
                ->where('siswa_id', $request->siswa_id)
                ->where('kelas_id', $request->kelas_id)
                ->where('mata_pelajaran_id', $request->mata_pelajaran_id)
                ->where('jenis_nilai', $request->jenis_nilai)
                ->where('semester', $request->semester)
                ->exists();

            if ($existingNilai) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Nilai untuk jenis dan semester yang sama sudah ada! Gunakan fitur edit untuk mengubah nilai.');
            }

            DB::table('nilai_siswa')->insert([
                'siswa_id' => $request->siswa_id,
                'kelas_id' => $request->kelas_id,
                'mata_pelajaran_id' => $request->mata_pelajaran_id,
                'jenis_nilai' => $request->jenis_nilai,
                'nilai' => $request->nilai,
                'tanggal_nilai' => $request->tanggal_nilai,
                'semester' => $request->semester,
                'keterangan' => $request->keterangan,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return redirect('/admin/nilai-siswa/')
                ->with('success', 'Nilai siswa berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function getShow(string $id)
    {
        $nilai = DB::table('nilai_siswa')
            ->join('users', 'nilai_siswa.siswa_id', '=', 'users.id')
            ->join('kelas', 'nilai_siswa.kelas_id', '=', 'kelas.id')
            ->join('mata_pelajaran', 'nilai_siswa.mata_pelajaran_id', '=', 'mata_pelajaran.id')
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->select(
                'nilai_siswa.*',
                'users.nama as siswa_nama',
                'users.email as siswa_email',
                'kelas.nama as kelas_nama',
                'kelas.jenjang',
                'kelas.tingkat',
                'mata_pelajaran.nama as mata_pelajaran_nama',
                'mata_pelajaran.kode as mata_pelajaran_kode',
                'tahun_ajaran.nama as tahun_ajaran_nama'
            )
            ->where('nilai_siswa.id', $id)
            ->first();
        
        if (!$nilai) {
            return redirect('/admin/nilai-siswa/')
                ->with('error', 'Data tidak ditemukan!');
        }

        // Nilai lain siswa untuk mata pelajaran yang sama
        $nilaiLainnya = DB::table('nilai_siswa')
            ->where('siswa_id', $nilai->siswa_id)
            ->where('mata_pelajaran_id', $nilai->mata_pelajaran_id)
            ->where('kelas_id', $nilai->kelas_id)
            ->where('id', '!=', $id)
            ->orderBy('tanggal_nilai', 'desc')
            ->get();

        // Statistik nilai siswa untuk mata pelajaran ini
        $statistik = DB::table('nilai_siswa')
            ->where('siswa_id', $nilai->siswa_id)
            ->where('mata_pelajaran_id', $nilai->mata_pelajaran_id)
            ->where('kelas_id', $nilai->kelas_id)
            ->selectRaw('
                AVG(nilai) as rata_rata,
                MAX(nilai) as nilai_tertinggi,
                MIN(nilai) as nilai_terendah,
                COUNT(*) as total_nilai
            ')
            ->first();

        return view('admin.nilai-siswa.show', compact('nilai', 'nilaiLainnya', 'statistik'));
    }

    public function getEdit(string $id)
    {
        $nilai = DB::table('nilai_siswa')
            ->join('users', 'nilai_siswa.siswa_id', '=', 'users.id')
            ->join('kelas', 'nilai_siswa.kelas_id', '=', 'kelas.id')
            ->join('mata_pelajaran', 'nilai_siswa.mata_pelajaran_id', '=', 'mata_pelajaran.id')
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->select(
                'nilai_siswa.*',
                'users.nama as siswa_nama',
                'kelas.nama as kelas_nama',
                'kelas.jenjang',
                'kelas.tingkat',
                'mata_pelajaran.nama as mata_pelajaran_nama',
                'tahun_ajaran.nama as tahun_ajaran_nama'
            )
            ->where('nilai_siswa.id', $id)
            ->first();

        if (!$nilai) {
            return redirect('/admin/nilai-siswa/')
                ->with('error', 'Data tidak ditemukan!');
        }

        return view('admin.nilai-siswa.edit', compact('nilai'));
    }

    public function putUpdate(Request $request, string $id)
    {
        $request->validate([
            'jenis_nilai' => 'required|in:UTS,UAS,Tugas,Kuis,Praktik,Lainnya',
            'nilai' => 'required|numeric|min:0|max:100',
            'tanggal_nilai' => 'required|date',
            'semester' => 'required|in:Ganjil,Genap',
            'keterangan' => 'nullable|string|max:500'
        ]);

        try {
            $nilai = DB::table('nilai_siswa')->where('id', $id)->first();
            
            if (!$nilai) {
                return redirect()->back()->with('error', 'Data tidak ditemukan!');
            }

            // Cek duplikasi jika mengubah jenis nilai atau semester
            if ($request->jenis_nilai != $nilai->jenis_nilai || $request->semester != $nilai->semester) {
                $existingNilai = DB::table('nilai_siswa')
                    ->where('siswa_id', $nilai->siswa_id)
                    ->where('kelas_id', $nilai->kelas_id)
                    ->where('mata_pelajaran_id', $nilai->mata_pelajaran_id)
                    ->where('jenis_nilai', $request->jenis_nilai)
                    ->where('semester', $request->semester)
                    ->where('id', '!=', $id)
                    ->exists();

                if ($existingNilai) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Nilai untuk jenis dan semester yang sama sudah ada!');
                }
            }

            DB::table('nilai_siswa')
                ->where('id', $id)
                ->update([
                    'jenis_nilai' => $request->jenis_nilai,
                    'nilai' => $request->nilai,
                    'tanggal_nilai' => $request->tanggal_nilai,
                    'semester' => $request->semester,
                    'keterangan' => $request->keterangan,
                    'updated_at' => now()
                ]);

            return redirect('/admin/nilai-siswa/')
                ->with('success', 'Nilai siswa berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function deleteDestroy(string $id)
    {
        try {
            $deleted = DB::table('nilai_siswa')->where('id', $id)->delete();
            
            if (!$deleted) {
                return redirect()->back()->with('error', 'Data tidak ditemukan!');
            }

            return redirect('/admin/nilai-siswa/')
                ->with('success', 'Nilai siswa berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * API untuk mendapatkan siswa berdasarkan kelas
     */
    public function getSiswaByKelas($kelasId)
    {
        $siswa = DB::table('keanggotaan_kelas')
            ->join('users', 'keanggotaan_kelas.siswa_id', '=', 'users.id')
            ->where('keanggotaan_kelas.kelas_id', $kelasId)
            ->select('users.id', 'users.nama', 'users.email')
            ->orderBy('users.nama')
            ->get();

        return response()->json($siswa);
    }

    /**
     * API untuk laporan nilai per siswa
     */
    public function getLaporanSiswa($siswaId, Request $request)
    {
        $query = DB::table('nilai_siswa')
            ->join('mata_pelajaran', 'nilai_siswa.mata_pelajaran_id', '=', 'mata_pelajaran.id')
            ->join('kelas', 'nilai_siswa.kelas_id', '=', 'kelas.id')
            ->where('nilai_siswa.siswa_id', $siswaId)
            ->select(
                'nilai_siswa.*',
                'mata_pelajaran.nama as mata_pelajaran_nama',
                'mata_pelajaran.kode as mata_pelajaran_kode',
                'kelas.nama as kelas_nama',
                'kelas.jenjang',
                'kelas.tingkat'
            );

        if ($request->filled('semester')) {
            $query->where('nilai_siswa.semester', $request->semester);
        }

        if ($request->filled('kelas_id')) {
            $query->where('nilai_siswa.kelas_id', $request->kelas_id);
        }

        $nilai = $query->orderBy('mata_pelajaran.nama')
                      ->orderBy('nilai_siswa.jenis_nilai')
                      ->get();

        return response()->json($nilai);
    }

    /**
     * Analisis nilai kelas
     */
    public function getAnalisisKelas($kelasId, Request $request)
    {
        $query = DB::table('nilai_siswa')
            ->join('users', 'nilai_siswa.siswa_id', '=', 'users.id')
            ->join('mata_pelajaran', 'nilai_siswa.mata_pelajaran_id', '=', 'mata_pelajaran.id')
            ->where('nilai_siswa.kelas_id', $kelasId)
            ->select(
                'nilai_siswa.*',
                'users.name as siswa_nama',
                'mata_pelajaran.nama as mata_pelajaran_nama'
            );

        if ($request->filled('mata_pelajaran_id')) {
            $query->where('nilai_siswa.mata_pelajaran_id', $request->mata_pelajaran_id);
        }

        if ($request->filled('semester')) {
            $query->where('nilai_siswa.semester', $request->semester);
        }

        $data = $query->get();

        // Analisis statistik
        $analisis = [
            'total_nilai' => $data->count(),
            'rata_rata_kelas' => $data->avg('nilai'),
            'nilai_tertinggi' => $data->max('nilai'),
            'nilai_terendah' => $data->min('nilai'),
            'siswa_di_atas_kkm' => $data->where('nilai', '>=', 75)->count(),
            'siswa_di_bawah_kkm' => $data->where('nilai', '<', 75)->count(),
        ];

        return response()->json([
            'analisis' => $analisis,
            'data' => $data
        ]);
    }
}
