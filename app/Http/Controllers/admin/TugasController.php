<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tugas;
use App\Models\Kelas;
use App\Models\PengumpulanTugas;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TugasController extends Controller
{
    public function getIndex(Request $request)
    {
        $query = DB::table('tugas')
            ->join('kelas', 'tugas.kelas_id', '=', 'kelas.id')
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->select(
                'tugas.*',
                'kelas.nama as kelas_nama',
                'kelas.jenjang',
                'kelas.tingkat',
                'tahun_ajaran.nama as tahun_ajaran_nama'
            );

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('tugas.judul', 'LIKE', "%{$search}%")
                  ->orWhere('kelas.nama', 'LIKE', "%{$search}%");
            });
        }

        // Filter berdasarkan kelas
        if ($request->filled('kelas_id')) {
            $query->where('tugas.kelas_id', $request->kelas_id);
        }

        // Filter berdasarkan tahun ajaran
        if ($request->filled('tahun_ajaran_id')) {
            $query->where('kelas.tahun_ajaran_id', $request->tahun_ajaran_id);
        }

        $tugas = $query->orderBy('tugas.tenggat_waktu', 'desc')
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

        return view('admin.tugas.index', compact('tugas', 'kelas', 'tahunAjaran'));
    }

    public function getCreate()
    {
        // Data untuk dropdown
        $kelas = DB::table('kelas')
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->select('kelas.id', 'kelas.nama', 'kelas.jenjang', 'kelas.tingkat', 'tahun_ajaran.nama as tahun_ajaran')
            ->orderBy('kelas.jenjang')
            ->orderBy('kelas.tingkat')
            ->get();

        return view('admin.tugas.create', compact('kelas'));
    }

    public function postStore(Request $request)
    {
        // Validasi input
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'judul' => 'required|string|max:255',
            'instruksi' => 'nullable|string',
            'tenggat_waktu' => 'nullable|date',
        ]);

        // Simpan tugas baru
        $tugas = new Tugas();
        $tugas->kelas_id = $request->kelas_id;
        $tugas->judul = $request->judul;
        $tugas->instruksi = $request->instruksi;
        $tugas->tenggat_waktu = $request->tenggat_waktu;
        $tugas->save();

        return redirect('/admin/tugas')->with('success', 'Tugas berhasil ditambahkan');
    }

    public function getShow($id)
    {
        $tugas = DB::table('tugas')
            ->join('kelas', 'tugas.kelas_id', '=', 'kelas.id')
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->select(
                'tugas.*',
                'kelas.nama as kelas_nama',
                'kelas.jenjang',
                'kelas.tingkat',
                'tahun_ajaran.nama as tahun_ajaran_nama'
            )
            ->where('tugas.id', $id)
            ->first();

        if (!$tugas) {
            return redirect('/admin/tugas')->with('error', 'Tugas tidak ditemukan');
        }

        // Ambil data pengumpulan tugas
        $pengumpulan = DB::table('pengumpulan_tugas')
            ->join('users', 'pengumpulan_tugas.siswa_id', '=', 'users.id')
            ->leftJoin('nilai', 'pengumpulan_tugas.id', '=', 'nilai.pengumpulan_id')
            ->select(
                'pengumpulan_tugas.*',
                'users.name as siswa_nama',
                'users.email as siswa_email',
                'nilai.skor',
                'nilai.umpan_balik'
            )
            ->where('pengumpulan_tugas.tugas_id', $id)
            ->orderBy('pengumpulan_tugas.waktu_pengumpulan', 'desc')
            ->get();

        return view('admin.tugas.show', compact('tugas', 'pengumpulan'));
    }

    public function getEdit($id)
    {
        $tugas = Tugas::findOrFail($id);

        // Data untuk dropdown
        $kelas = DB::table('kelas')
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->select('kelas.id', 'kelas.nama', 'kelas.jenjang', 'kelas.tingkat', 'tahun_ajaran.nama as tahun_ajaran')
            ->orderBy('kelas.jenjang')
            ->orderBy('kelas.tingkat')
            ->get();

        return view('admin.tugas.edit', compact('tugas', 'kelas'));
    }

    public function postUpdate(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'judul' => 'required|string|max:255',
            'instruksi' => 'nullable|string',
            'tenggat_waktu' => 'nullable|date',
        ]);

        // Update tugas
        $tugas = Tugas::findOrFail($id);
        $tugas->kelas_id = $request->kelas_id;
        $tugas->judul = $request->judul;
        $tugas->instruksi = $request->instruksi;
        $tugas->tenggat_waktu = $request->tenggat_waktu;
        $tugas->save();

        return redirect('/admin/tugas')->with('success', 'Tugas berhasil diperbarui');
    }

    public function getDelete($id)
    {
        $tugas = Tugas::findOrFail($id);
        $tugas->delete();

        return redirect('/admin/tugas')->with('success', 'Tugas berhasil dihapus');
    }

    public function getNilai($pengumpulanId)
    {
        $pengumpulan = DB::table('pengumpulan_tugas')
            ->join('users', 'pengumpulan_tugas.siswa_id', '=', 'users.id')
            ->join('tugas', 'pengumpulan_tugas.tugas_id', '=', 'tugas.id')
            ->leftJoin('nilai', 'pengumpulan_tugas.id', '=', 'nilai.pengumpulan_id')
            ->select(
                'pengumpulan_tugas.*',
                'users.name as siswa_nama',
                'users.email as siswa_email',
                'tugas.judul as tugas_judul',
                'nilai.skor',
                'nilai.umpan_balik'
            )
            ->where('pengumpulan_tugas.id', $pengumpulanId)
            ->first();

        if (!$pengumpulan) {
            return redirect('/admin/tugas')->with('error', 'Pengumpulan tugas tidak ditemukan');
        }

        return view('admin.tugas.nilai', compact('pengumpulan'));
    }

    public function postNilai(Request $request, $pengumpulanId)
    {
        // Validasi input
        $request->validate([
            'skor' => 'required|numeric|min:0|max:100',
            'umpan_balik' => 'nullable|string',
        ]);

        // Cek apakah pengumpulan ada
        $pengumpulan = PengumpulanTugas::findOrFail($pengumpulanId);

        // Cek apakah sudah ada nilai
        $nilai = DB::table('nilai')->where('pengumpulan_id', $pengumpulanId)->first();

        if ($nilai) {
            // Update nilai yang sudah ada
            DB::table('nilai')
                ->where('pengumpulan_id', $pengumpulanId)
                ->update([
                    'skor' => $request->skor,
                    'umpan_balik' => $request->umpan_balik,
                    'penilai_id' => Auth::id(),
                    'dinilai_pada' => now(),
                ]);
        } else {
            // Buat nilai baru
            DB::table('nilai')->insert([
                'pengumpulan_id' => $pengumpulanId,
                'skor' => $request->skor,
                'umpan_balik' => $request->umpan_balik,
                'penilai_id' => Auth::id(),
                'dinilai_pada' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect('/admin/tugas/show/' . $pengumpulan->tugas_id)->with('success', 'Nilai berhasil disimpan');
    }
}