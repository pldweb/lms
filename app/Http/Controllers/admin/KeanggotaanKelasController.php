<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeanggotaanKelasController extends Controller
{
    public function getIndex(Request $request)
    {
        $query = DB::table('keanggotaan_kelas')
            ->join('users', 'keanggotaan_kelas.siswa_id', '=', 'users.id')
            ->join('kelas', 'keanggotaan_kelas.kelas_id', '=', 'kelas.id')
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->select(
                'keanggotaan_kelas.*',
                'users.name as siswa_nama',
                'users.email as siswa_email',
                'kelas.nama as kelas_nama',
                'kelas.jenjang',
                'kelas.tingkat',
                'tahun_ajaran.nama as tahun_ajaran_nama'
            );

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('users.name', 'LIKE', "%{$search}%")
                  ->orWhere('users.email', 'LIKE', "%{$search}%")
                  ->orWhere('kelas.nama', 'LIKE', "%{$search}%");
            });
        }

        // Filter berdasarkan kelas
        if ($request->filled('kelas_id')) {
            $query->where('keanggotaan_kelas.kelas_id', $request->kelas_id);
        }

        // Filter berdasarkan jenjang
        if ($request->filled('jenjang')) {
            $query->where('kelas.jenjang', $request->jenjang);
        }

        // Filter berdasarkan tahun ajaran
        if ($request->filled('tahun_ajaran_id')) {
            $query->where('kelas.tahun_ajaran_id', $request->tahun_ajaran_id);
        }

        $keanggotaan = $query->orderBy('kelas.jenjang')
                            ->orderBy('kelas.tingkat')
                            ->orderBy('users.name')
                            ->paginate(20);

        // Data untuk filter
        $kelas = DB::table('kelas')
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->select('kelas.id', 'kelas.nama', 'kelas.jenjang', 'kelas.tingkat', 'tahun_ajaran.nama as tahun_ajaran')
            ->orderBy('kelas.jenjang')
            ->orderBy('kelas.tingkat')
            ->get();

        $tahunAjaran = DB::table('tahun_ajaran')
            ->select('id', 'nama')
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        return view('admin.keanggotaan-kelas.index', compact('keanggotaan', 'kelas', 'tahunAjaran'));
    }

    public function getCreate(Request $request)
    {
        // Data untuk dropdown
        $kelas = DB::table('kelas')
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->where('kelas.is_active', true)
            ->select('kelas.id', 'kelas.nama', 'kelas.jenjang', 'kelas.tingkat', 'tahun_ajaran.nama as tahun_ajaran')
            ->orderBy('kelas.jenjang')
            ->orderBy('kelas.tingkat')
            ->get();

        // Siswa yang belum terdaftar di kelas manapun untuk tahun ajaran aktif
        $siswaQuery = DB::table('users')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('model_has_roles')
                      ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                      ->whereRaw('model_has_roles.model_id = users.id')
                      ->where('roles.name', 'Siswa');
            });

        // Jika ada kelas yang dipilih, filter siswa yang belum di kelas tersebut
        if ($request->filled('kelas_id')) {
            $siswaQuery->whereNotExists(function($query) use ($request) {
                $query->select(DB::raw(1))
                      ->from('keanggotaan_kelas')
                      ->whereRaw('keanggotaan_kelas.siswa_id = users.id')
                      ->where('keanggotaan_kelas.kelas_id', $request->kelas_id);
            });
        }

        $siswa = $siswaQuery->select('id', 'name', 'email')
                           ->orderBy('name')
                           ->get();

        $selectedKelasId = $request->get('kelas_id');

        return view('admin.keanggotaan-kelas.create', compact('kelas', 'siswa', 'selectedKelasId'));
    }

    public function postStore(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'siswa_ids' => 'required|array|min:1',
            'siswa_ids.*' => 'exists:users,id',
            'tanggal_bergabung' => 'required|date'
        ]);

        try {
            // Cek kapasitas kelas
            $kelas = DB::table('kelas')->where('id', $request->kelas_id)->first();
            $jumlahSiswaSekarang = DB::table('keanggotaan_kelas')
                ->where('kelas_id', $request->kelas_id)
                ->count();
            
            $jumlahSiswaBaru = count($request->siswa_ids);
            
            if (($jumlahSiswaSekarang + $jumlahSiswaBaru) > $kelas->kapasitas) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', "Kapasitas kelas tidak mencukupi! Tersisa " . ($kelas->kapasitas - $jumlahSiswaSekarang) . " slot.");
            }

            // Cek apakah ada siswa yang sudah terdaftar
            $siswaExist = DB::table('keanggotaan_kelas')
                ->where('kelas_id', $request->kelas_id)
                ->whereIn('siswa_id', $request->siswa_ids)
                ->exists();

            if ($siswaExist) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Beberapa siswa sudah terdaftar di kelas ini!');
            }

            // Insert multiple siswa
            $dataInsert = [];
            foreach ($request->siswa_ids as $siswaId) {
                $dataInsert[] = [
                    'kelas_id' => $request->kelas_id,
                    'siswa_id' => $siswaId,
                    'tanggal_bergabung' => $request->tanggal_bergabung,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            DB::table('keanggotaan_kelas')->insert($dataInsert);

            return redirect('/admin/keanggotaan-kelas/')
                ->with('success', count($request->siswa_ids) . ' siswa berhasil ditambahkan ke kelas!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function getShow(string $id)
    {
        $keanggotaan = DB::table('keanggotaan_kelas')
            ->join('users', 'keanggotaan_kelas.siswa_id', '=', 'users.id')
            ->join('kelas', 'keanggotaan_kelas.kelas_id', '=', 'kelas.id')
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->select(
                'keanggotaan_kelas.*',
                'users.name as siswa_nama',
                'users.email as siswa_email',
                'kelas.nama as kelas_nama',
                'kelas.jenjang',
                'kelas.tingkat',
                'kelas.kapasitas',
                'tahun_ajaran.nama as tahun_ajaran_nama'
            )
            ->where('keanggotaan_kelas.id', $id)
            ->first();
        
        if (!$keanggotaan) {
            return redirect('/admin/keanggotaan-kelas/')
                ->with('error', 'Data tidak ditemukan!');
        }

        // Nilai siswa untuk kelas ini
        $nilaiSiswa = DB::table('nilai_siswa')
            ->join('mata_pelajaran', 'nilai_siswa.mata_pelajaran_id', '=', 'mata_pelajaran.id')
            ->where('nilai_siswa.siswa_id', $keanggotaan->siswa_id)
            ->where('nilai_siswa.kelas_id', $keanggotaan->kelas_id)
            ->select(
                'nilai_siswa.*',
                'mata_pelajaran.nama as mata_pelajaran_nama',
                'mata_pelajaran.kode as mata_pelajaran_kode'
            )
            ->orderBy('mata_pelajaran.nama')
            ->orderBy('nilai_siswa.jenis_nilai')
            ->get();

        return view('admin.keanggotaan-kelas.show', compact('keanggotaan', 'nilaiSiswa'));
    }

    public function deleteDestroy(string $id)
    {
        try {
            $keanggotaan = DB::table('keanggotaan_kelas')->where('id', $id)->first();
            
            if (!$keanggotaan) {
                return redirect()->back()->with('error', 'Data tidak ditemukan!');
            }

            // Cek apakah siswa sudah memiliki nilai
            $hasNilai = DB::table('nilai_siswa')
                ->where('siswa_id', $keanggotaan->siswa_id)
                ->where('kelas_id', $keanggotaan->kelas_id)
                ->exists();

            if ($hasNilai) {
                return redirect()->back()
                    ->with('error', 'Siswa tidak dapat dikeluarkan karena sudah memiliki nilai!');
            }

            DB::table('keanggotaan_kelas')->where('id', $id)->delete();

            return redirect('/admin/keanggotaan-kelas/')
                ->with('success', 'Siswa berhasil dikeluarkan dari kelas!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * API untuk remove siswa dari kelas (digunakan di view detail kelas)
     */
    public function deleteRemove(string $siswaId, Request $request)
    {
        try {
            $kelasId = $request->input('kelas_id');
            
            $keanggotaan = DB::table('keanggotaan_kelas')
                ->where('siswa_id', $siswaId)
                ->where('kelas_id', $kelasId)
                ->first();
            
            if (!$keanggotaan) {
                return response()->json(['success' => false, 'message' => 'Data tidak ditemukan!']);
            }

            // Cek apakah siswa sudah memiliki nilai
            $hasNilai = DB::table('nilai_siswa')
                ->where('siswa_id', $siswaId)
                ->where('kelas_id', $kelasId)
                ->exists();

            if ($hasNilai) {
                return response()->json(['success' => false, 'message' => 'Siswa tidak dapat dikeluarkan karena sudah memiliki nilai!']);
            }

            DB::table('keanggotaan_kelas')
                ->where('siswa_id', $siswaId)
                ->where('kelas_id', $kelasId)
                ->delete();

            return response()->json(['success' => true, 'message' => 'Siswa berhasil dikeluarkan dari kelas!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * API untuk mendapatkan siswa berdasarkan kelas
     */
    public function getBySiswa($siswaId)
    {
        $keanggotaan = DB::table('keanggotaan_kelas')
            ->join('kelas', 'keanggotaan_kelas.kelas_id', '=', 'kelas.id')
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->where('keanggotaan_kelas.siswa_id', $siswaId)
            ->select(
                'keanggotaan_kelas.*',
                'kelas.nama as kelas_nama',
                'kelas.jenjang',
                'kelas.tingkat',
                'tahun_ajaran.nama as tahun_ajaran_nama'
            )
            ->orderBy('tahun_ajaran.tanggal_mulai', 'desc')
            ->get();

        return response()->json($keanggotaan);
    }
}
