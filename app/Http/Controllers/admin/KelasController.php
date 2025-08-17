<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class KelasController extends Controller
{
    public function getIndex(Request $request)
    {
        $query = DB::table('kelas')
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->leftJoin('mata_pelajaran', 'kelas.mata_pelajaran_id', '=', 'mata_pelajaran.id')
            ->leftJoin('users as guru', 'kelas.guru_id', '=', 'guru.id')
            ->select(
                'kelas.*',
                'kelas.kode_kelas as kode',
                'kelas.semester',
                'tahun_ajaran.nama as tahun_ajaran_nama',
                'mata_pelajaran.nama as mata_pelajaran_nama',
                'mata_pelajaran.kode as mata_pelajaran_kode',
                'guru.nama as guru_nama',
                DB::raw('(SELECT COUNT(*) FROM keanggotaan_kelas WHERE keanggotaan_kelas.kelas_id = kelas.id) as kapasitas'),
                DB::raw('1 as is_active')
            );

        // Filter berdasarkan role user
        $user = Auth::user();
        if ($user) {
            $userModel = User::find($user->id);
            if ($userModel && !$userModel->hasRole('Admin')) {
                // Jika bukan admin, hanya tampilkan kelas yang dibuat oleh user tersebut
                $query->where('kelas.guru_id', $user->id);
            }
        }

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kelas.nama', 'LIKE', "%{$search}%")
                  ->orWhere('kelas.kode_kelas', 'LIKE', "%{$search}%");
            });
        }

        // Filter berdasarkan jenjang
        if ($request->filled('jenjang')) {
            $query->where('kelas.jenjang', $request->jenjang);
        }

        // Filter berdasarkan semester
        if ($request->filled('semester')) {
            $query->where('kelas.semester', $request->semester);
        }

        // Filter berdasarkan status aktif
        if ($request->filled('aktif')) {
            // Karena kita menggunakan hardcoded is_active = 1, kita bisa menambahkan kondisi lain jika diperlukan
            // Untuk saat ini, kita abaikan filter ini karena semua kelas dianggap aktif
        }

        // Filter berdasarkan tingkat
        if ($request->filled('tingkat')) {
            $query->where('kelas.tingkat', $request->tingkat);
        }

        // Filter berdasarkan tahun ajaran
        if ($request->filled('tahun_ajaran_id')) {
            $query->where('kelas.tahun_ajaran_id', $request->tahun_ajaran_id);
        }

        // Filter berdasarkan status - tidak tersedia karena tabel kelas tidak memiliki kolom is_active
        // if ($request->filled('status')) {
        //     $status = $request->status === 'aktif' ? 1 : 0;
        //     $query->where('kelas.is_active', $status);
        // }

        $kelas = $query->orderBy('kelas.jenjang')
                      ->orderBy('kelas.tingkat')
                      ->orderBy('kelas.nama')
                      ->paginate(20);

        // Data untuk filter
        $tahunAjaran = DB::table('tahun_ajaran')
            ->select('id', 'nama')
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        return view('admin.kelas.index', compact('kelas', 'tahunAjaran'));
    }

    public function getCreate()
    {
        // Data untuk dropdown
        $tahunAjaran = DB::table('tahun_ajaran')
            ->select('id', 'nama')
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        $mataPelajaran = DB::table('mata_pelajaran')
            ->where('aktif', true)
            ->select('id', 'kode', 'nama', 'jenjang')
            ->orderBy('jenjang')
            ->orderBy('nama')
            ->get();

        return view('admin.kelas.create', compact('tahunAjaran', 'mataPelajaran'));
    }

    public function postStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:20|unique:kelas,kode',
            'jenjang' => 'required|in:SD,SMP,SMA,SMK',
            'tingkat' => 'required|integer|between:1,12',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'mata_pelajaran_id' => 'nullable|exists:mata_pelajaran,id',
            'kapasitas' => 'required|integer|min:1|max:50',
            'deskripsi' => 'nullable|string|max:1000'
        ]);

        try {
            $user = Auth::user();
            DB::table('kelas')->insert([
                'nama' => $request->nama,
                'kode_kelas' => $request->kode,
                'jenjang' => $request->jenjang,
                'tahun_ajaran' => $request->tahun_ajaran,
                'semester' => $request->semester,
                'deskripsi' => $request->deskripsi,
                'guru_id' => $user ? $user->id : null,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return redirect('/admin/kelas/')
                ->with('success', 'Kelas berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function getShow(string $id)
    {
        $kelas = DB::table('kelas')
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->leftJoin('mata_pelajaran', 'kelas.mata_pelajaran_id', '=', 'mata_pelajaran.id')
            ->select(
                'kelas.*',
                'tahun_ajaran.nama as tahun_ajaran_nama',
                'mata_pelajaran.nama as mata_pelajaran_nama',
                'mata_pelajaran.kode as mata_pelajaran_kode'
            )
            ->where('kelas.id', $id)
            ->first();
        
        if (!$kelas) {
            return redirect('/admin/kelas/')
                ->with('error', 'Data tidak ditemukan!');
        }

        // Statistik kelas
        $jumlahSiswa = DB::table('keanggotaan_kelas')
            ->where('kelas_id', $id)
            ->count();

        $jumlahJadwal = DB::table('jadwal_pelajaran')
            ->where('kelas_id', $id)
            ->count();

        // Daftar siswa
        $anggotaKelas = DB::table('keanggotaan_kelas')
            ->join('users', 'keanggotaan_kelas.siswa_id', '=', 'users.id')
            ->where('keanggotaan_kelas.kelas_id', $id)
            ->select('users.id', 'users.nama as name', 'users.email', 'keanggotaan_kelas.tanggal_bergabung')
            ->orderBy('users.nama')
            ->get();

        return view('admin.kelas.show', compact('kelas', 'jumlahSiswa', 'jumlahJadwal', 'anggotaKelas'));
    }

    public function getEdit(string $id)
    {
        $kelas = DB::table('kelas')->where('id', $id)->first();
        
        if (!$kelas) {
            return redirect('/admin/kelas/')
                ->with('error', 'Data tidak ditemukan!');
        }

        // Data untuk dropdown
        $tahunAjaran = DB::table('tahun_ajaran')
            ->select('id', 'nama')
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        $mataPelajaran = DB::table('mata_pelajaran')
            ->where('aktif', true)
            ->select('id', 'kode', 'nama', 'jenjang')
            ->orderBy('jenjang')
            ->orderBy('nama')
            ->get();

        return view('admin.kelas.edit', compact('kelas', 'tahunAjaran', 'mataPelajaran'));
    }

    public function putUpdate(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:20|unique:kelas,kode,' . $id,
            'jenjang' => 'required|in:SD,SMP,SMA,SMK',
            'tingkat' => 'required|integer|between:1,12',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
            'mata_pelajaran_id' => 'nullable|exists:mata_pelajaran,id',
            'kapasitas' => 'required|integer|min:1|max:50',
            'deskripsi' => 'nullable|string|max:1000'
        ]);

        try {
            DB::table('kelas')
                ->where('id', $id)
                ->update([
                    'nama' => $request->nama,
                    'kode' => $request->kode,
                    'jenjang' => $request->jenjang,
                    'tingkat' => $request->tingkat,
                    'tahun_ajaran_id' => $request->tahun_ajaran_id,
                    'mata_pelajaran_id' => $request->mata_pelajaran_id,
                    'kapasitas' => $request->kapasitas,
                    'deskripsi' => $request->deskripsi,
                    'updated_at' => now()
                ]);

            return redirect('/admin/kelas/')
                ->with('success', 'Kelas berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function deleteDestroy(string $id)
    {
        try {
            // Cek apakah kelas memiliki anggota
            $anggotaCount = DB::table('keanggotaan_kelas')->where('kelas_id', $id)->count();
            
            if ($anggotaCount > 0) {
                return redirect()->back()
                    ->with('error', 'Kelas tidak dapat dihapus karena masih memiliki ' . $anggotaCount . ' anggota!');
            }

            // Cek apakah kelas memiliki jadwal
            $jadwalCount = DB::table('jadwal_pelajaran')->where('kelas_id', $id)->count();
            
            if ($jadwalCount > 0) {
                return redirect()->back()
                    ->with('error', 'Kelas tidak dapat dihapus karena masih memiliki ' . $jadwalCount . ' jadwal pelajaran!');
            }

            DB::table('kelas')->where('id', $id)->delete();

            return redirect('/admin/kelas/')
                ->with('success', 'Kelas berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function patchToggleStatus(string $id)
    {
        try {
            $kelas = DB::table('kelas')->where('id', $id)->first();
            
            if (!$kelas) {
                return redirect()->back()->with('error', 'Data tidak ditemukan!');
            }

            // Toggle status tidak tersedia karena tabel kelas tidak memiliki kolom is_active
            return redirect('/admin/kelas/')
                ->with('error', 'Fitur toggle status tidak tersedia untuk kelas!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
