<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalPelajaranController extends Controller
{
    public function getIndex(Request $request)
    {
        $query = DB::table('jadwal_pelajaran')
            ->join('kelas', 'jadwal_pelajaran.kelas_id', '=', 'kelas.id')
            ->join('mata_pelajaran', 'jadwal_pelajaran.mata_pelajaran_id', '=', 'mata_pelajaran.id')
            ->join('users', 'jadwal_pelajaran.guru_id', '=', 'users.id')
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->select(
                'jadwal_pelajaran.*',
                'kelas.nama as kelas_nama',
                'kelas.jenjang',
                'kelas.tingkat',
                'mata_pelajaran.nama as mata_pelajaran_nama',
                'mata_pelajaran.kode as mata_pelajaran_kode',
                'users.name as guru_nama',
                'tahun_ajaran.nama as tahun_ajaran_nama'
            );

        // Filter berdasarkan hari
        if ($request->filled('hari')) {
            $query->where('jadwal_pelajaran.hari', $request->hari);
        }

        // Filter berdasarkan kelas
        if ($request->filled('kelas_id')) {
            $query->where('jadwal_pelajaran.kelas_id', $request->kelas_id);
        }

        // Filter berdasarkan guru
        if ($request->filled('guru_id')) {
            $query->where('jadwal_pelajaran.guru_id', $request->guru_id);
        }

        // Filter berdasarkan jenjang
        if ($request->filled('jenjang')) {
            $query->where('kelas.jenjang', $request->jenjang);
        }

        $jadwal = $query->orderBy('jadwal_pelajaran.hari')
                       ->orderBy('jadwal_pelajaran.jam_mulai')
                       ->orderBy('kelas.jenjang')
                       ->orderBy('kelas.tingkat')
                       ->paginate(20);

        // Data untuk filter
        $kelas = DB::table('kelas')
            ->where('is_active', true)
            ->select('id', 'nama', 'jenjang', 'tingkat')
            ->orderBy('jenjang')
            ->orderBy('tingkat')
            ->get();

        $guru = DB::table('users')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('model_has_roles')
                      ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                      ->whereRaw('model_has_roles.model_id = users.id')
                      ->where('roles.name', 'Guru');
            })
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('admin.jadwal-pelajaran.index', compact('jadwal', 'kelas', 'guru'));
    }

    public function getCreate()
    {
        // Data untuk dropdown
        $kelas = DB::table('kelas')
            ->join('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->where('kelas.is_active', true)
            ->select('kelas.id', 'kelas.nama', 'kelas.jenjang', 'kelas.tingkat', 'tahun_ajaran.nama as tahun_ajaran')
            ->orderBy('kelas.jenjang')
            ->orderBy('kelas.tingkat')
            ->get();

        $mataPelajaran = DB::table('mata_pelajaran')
            ->where('is_active', true)
            ->select('id', 'kode', 'nama', 'jenjang')
            ->orderBy('jenjang')
            ->orderBy('nama')
            ->get();

        $guru = DB::table('users')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('model_has_roles')
                      ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                      ->whereRaw('model_has_roles.model_id = users.id')
                      ->where('roles.name', 'Guru');
            })
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('admin.jadwal-pelajaran.create', compact('kelas', 'mataPelajaran', 'guru'));
    }

    public function postStore(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'guru_id' => 'required|exists:users,id',
            'hari' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'ruangan' => 'nullable|string|max:100',
            'keterangan' => 'nullable|string|max:500'
        ]);

        // Cek bentrok jadwal untuk kelas yang sama
        $bentrokKelas = DB::table('jadwal_pelajaran')
            ->where('kelas_id', $request->kelas_id)
            ->where('hari', $request->hari)
            ->where(function($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                      ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                      ->orWhere(function($q) use ($request) {
                          $q->where('jam_mulai', '<=', $request->jam_mulai)
                            ->where('jam_selesai', '>=', $request->jam_selesai);
                      });
            })
            ->exists();

        if ($bentrokKelas) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jadwal bentrok dengan jadwal kelas yang sudah ada pada hari dan jam tersebut!');
        }

        // Cek bentrok jadwal untuk guru yang sama
        $bentrokGuru = DB::table('jadwal_pelajaran')
            ->where('guru_id', $request->guru_id)
            ->where('hari', $request->hari)
            ->where(function($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                      ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                      ->orWhere(function($q) use ($request) {
                          $q->where('jam_mulai', '<=', $request->jam_mulai)
                            ->where('jam_selesai', '>=', $request->jam_selesai);
                      });
            })
            ->exists();

        if ($bentrokGuru) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jadwal bentrok dengan jadwal guru yang sudah ada pada hari dan jam tersebut!');
        }

        try {
            DB::table('jadwal_pelajaran')->insert([
                'kelas_id' => $request->kelas_id,
                'mata_pelajaran_id' => $request->mata_pelajaran_id,
                'guru_id' => $request->guru_id,
                'hari' => $request->hari,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'ruangan' => $request->ruangan,
                'keterangan' => $request->keterangan,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return redirect('/admin/jadwal-pelajaran/')
                ->with('success', 'Jadwal pelajaran berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function getShow(string $id)
    {
        $jadwal = DB::table('jadwal_pelajaran')
            ->join('kelas', 'jadwal_pelajaran.kelas_id', '=', 'kelas.id')
            ->join('mata_pelajaran', 'jadwal_pelajaran.mata_pelajaran_id', '=', 'mata_pelajaran.id')
            ->join('users', 'jadwal_pelajaran.guru_id', '=', 'users.id')
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->select(
                'jadwal_pelajaran.*',
                'kelas.nama as kelas_nama',
                'kelas.jenjang',
                'kelas.tingkat',
                'kelas.kapasitas',
                'mata_pelajaran.nama as mata_pelajaran_nama',
                'mata_pelajaran.kode as mata_pelajaran_kode',
                'mata_pelajaran.bobot_sks',
                'users.name as guru_nama',
                'users.email as guru_email',
                'tahun_ajaran.nama as tahun_ajaran_nama'
            )
            ->where('jadwal_pelajaran.id', $id)
            ->first();
        
        if (!$jadwal) {
            return redirect('/admin/jadwal-pelajaran/')
                ->with('error', 'Data tidak ditemukan!');
        }

        // Jumlah siswa di kelas
        $jumlahSiswa = DB::table('keanggotaan_kelas')
            ->where('kelas_id', $jadwal->kelas_id)
            ->count();

        return view('admin.jadwal-pelajaran.show', compact('jadwal', 'jumlahSiswa'));
    }

    public function getEdit(string $id)
    {
        $jadwal = DB::table('jadwal_pelajaran')->where('id', $id)->first();
        
        if (!$jadwal) {
            return redirect('/admin/jadwal-pelajaran/')
                ->with('error', 'Data tidak ditemukan!');
        }

        // Data untuk dropdown
        $kelas = DB::table('kelas')
            ->join('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->where('kelas.is_active', true)
            ->select('kelas.id', 'kelas.nama', 'kelas.jenjang', 'kelas.tingkat', 'tahun_ajaran.nama as tahun_ajaran')
            ->orderBy('kelas.jenjang')
            ->orderBy('kelas.tingkat')
            ->get();

        $mataPelajaran = DB::table('mata_pelajaran')
            ->where('is_active', true)
            ->select('id', 'kode', 'nama', 'jenjang')
            ->orderBy('jenjang')
            ->orderBy('nama')
            ->get();

        $guru = DB::table('users')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('model_has_roles')
                      ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                      ->whereRaw('model_has_roles.model_id = users.id')
                      ->where('roles.name', 'Guru');
            })
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('admin.jadwal-pelajaran.edit', compact('jadwal', 'kelas', 'mataPelajaran', 'guru'));
    }

    public function putUpdate(Request $request, string $id)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
            'guru_id' => 'required|exists:users,id',
            'hari' => 'required|in:senin,selasa,rabu,kamis,jumat,sabtu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'ruangan' => 'nullable|string|max:100',
            'keterangan' => 'nullable|string|max:500'
        ]);

        // Cek bentrok jadwal untuk kelas yang sama (kecuali jadwal ini sendiri)
        $bentrokKelas = DB::table('jadwal_pelajaran')
            ->where('kelas_id', $request->kelas_id)
            ->where('hari', $request->hari)
            ->where('id', '!=', $id)
            ->where(function($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                      ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                      ->orWhere(function($q) use ($request) {
                          $q->where('jam_mulai', '<=', $request->jam_mulai)
                            ->where('jam_selesai', '>=', $request->jam_selesai);
                      });
            })
            ->exists();

        if ($bentrokKelas) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jadwal bentrok dengan jadwal kelas yang sudah ada pada hari dan jam tersebut!');
        }

        // Cek bentrok jadwal untuk guru yang sama (kecuali jadwal ini sendiri)
        $bentrokGuru = DB::table('jadwal_pelajaran')
            ->where('guru_id', $request->guru_id)
            ->where('hari', $request->hari)
            ->where('id', '!=', $id)
            ->where(function($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                      ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                      ->orWhere(function($q) use ($request) {
                          $q->where('jam_mulai', '<=', $request->jam_mulai)
                            ->where('jam_selesai', '>=', $request->jam_selesai);
                      });
            })
            ->exists();

        if ($bentrokGuru) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Jadwal bentrok dengan jadwal guru yang sudah ada pada hari dan jam tersebut!');
        }

        try {
            DB::table('jadwal_pelajaran')
                ->where('id', $id)
                ->update([
                    'kelas_id' => $request->kelas_id,
                    'mata_pelajaran_id' => $request->mata_pelajaran_id,
                    'guru_id' => $request->guru_id,
                    'hari' => $request->hari,
                    'jam_mulai' => $request->jam_mulai,
                    'jam_selesai' => $request->jam_selesai,
                    'ruangan' => $request->ruangan,
                    'keterangan' => $request->keterangan,
                    'updated_at' => now()
                ]);

            return redirect('/admin/jadwal-pelajaran/')
                ->with('success', 'Jadwal pelajaran berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function deleteDestroy(string $id)
    {
        try {
            DB::table('jadwal_pelajaran')->where('id', $id)->delete();

            return redirect('/admin/jadwal-pelajaran/')
                ->with('success', 'Jadwal pelajaran berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function patchToggleStatus(string $id)
    {
        try {
            $jadwal = DB::table('jadwal_pelajaran')->where('id', $id)->first();
            
            if (!$jadwal) {
                return redirect()->back()->with('error', 'Data tidak ditemukan!');
            }

            $newStatus = !$jadwal->is_active;
            
            DB::table('jadwal_pelajaran')
                ->where('id', $id)
                ->update([
                    'is_active' => $newStatus,
                    'updated_at' => now()
                ]);

            $statusText = $newStatus ? 'diaktifkan' : 'dinonaktifkan';
            
            return redirect('/admin/jadwal-pelajaran/')
                ->with('success', "Jadwal pelajaran berhasil {$statusText}!");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * API untuk mendapatkan jadwal berdasarkan kelas
     */
    public function getByKelas($kelasId)
    {
        $jadwal = DB::table('jadwal_pelajaran')
            ->join('mata_pelajaran', 'jadwal_pelajaran.mata_pelajaran_id', '=', 'mata_pelajaran.id')
            ->join('users', 'jadwal_pelajaran.guru_id', '=', 'users.id')
            ->where('jadwal_pelajaran.kelas_id', $kelasId)
            ->where('jadwal_pelajaran.is_active', true)
            ->select(
                'jadwal_pelajaran.*',
                'mata_pelajaran.nama as mata_pelajaran_nama',
                'mata_pelajaran.kode as mata_pelajaran_kode',
                'users.name as guru_nama'
            )
            ->orderBy('jadwal_pelajaran.hari')
            ->orderBy('jadwal_pelajaran.jam_mulai')
            ->get();

        return response()->json($jadwal);
    }

    /**
     * API untuk mendapatkan jadwal berdasarkan guru
     */
    public function getByGuru($guruId)
    {
        $jadwal = DB::table('jadwal_pelajaran')
            ->join('kelas', 'jadwal_pelajaran.kelas_id', '=', 'kelas.id')
            ->join('mata_pelajaran', 'jadwal_pelajaran.mata_pelajaran_id', '=', 'mata_pelajaran.id')
            ->where('jadwal_pelajaran.guru_id', $guruId)
            ->where('jadwal_pelajaran.is_active', true)
            ->select(
                'jadwal_pelajaran.*',
                'kelas.nama as kelas_nama',
                'kelas.jenjang',
                'kelas.tingkat',
                'mata_pelajaran.nama as mata_pelajaran_nama',
                'mata_pelajaran.kode as mata_pelajaran_kode'
            )
            ->orderBy('jadwal_pelajaran.hari')
            ->orderBy('jadwal_pelajaran.jam_mulai')
            ->get();

        return response()->json($jadwal);
    }
}
