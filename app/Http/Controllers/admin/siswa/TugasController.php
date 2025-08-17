<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tugas;
use App\Models\Kelas;
use App\Models\PengumpulanTugas;
use App\Models\User;
use App\Models\Nilai;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TugasController extends Controller
{
    /**
     * Menampilkan daftar tugas untuk siswa
     */
    public function getIndex(Request $request)
    {
        $siswa_id = Auth::id();
        
        // Filter data
        $search = $request->input('search');
        $kelas_id = $request->input('kelas_id');
        $status = $request->input('status');
        
        // Ambil kelas yang diikuti oleh siswa
        $kelas_siswa = DB::table('keanggotaan_kelas')
            ->where('user_id', $siswa_id)
            ->pluck('kelas_id')
            ->toArray();
        
        // Query dasar - hanya ambil tugas dari kelas yang diikuti siswa
        $query = DB::table('tugas')
            ->join('kelas', 'tugas.kelas_id', '=', 'kelas.id')
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->leftJoin('pengumpulan_tugas', function($join) use ($siswa_id) {
                $join->on('tugas.id', '=', 'pengumpulan_tugas.tugas_id')
                     ->where('pengumpulan_tugas.siswa_id', '=', $siswa_id);
            })
            ->leftJoin('nilai', 'pengumpulan_tugas.id', '=', 'nilai.pengumpulan_id')
            ->select(
                'tugas.id',
                'tugas.judul',
                'tugas.instruksi',
                'tugas.tenggat_waktu',
                'tugas.created_at',
                'kelas.nama as kelas_nama',
                'kelas.jenjang',
                'kelas.tingkat',
                'tahun_ajaran.nama as tahun_ajaran_nama',
                'pengumpulan_tugas.id as pengumpulan_id',
                'pengumpulan_tugas.status',
                'pengumpulan_tugas.waktu_pengumpulan',
                'nilai.skor'
            )
            ->whereIn('tugas.kelas_id', $kelas_siswa);
        
        // Terapkan filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('tugas.judul', 'like', "%$search%")
                  ->orWhere('kelas.nama', 'like', "%$search%");
            });
        }
        
        if ($kelas_id) {
            $query->where('tugas.kelas_id', $kelas_id);
        }
        
        if ($status) {
            if ($status == 'submitted') {
                $query->whereNotNull('pengumpulan_tugas.id');
            } elseif ($status == 'not_submitted') {
                $query->whereNull('pengumpulan_tugas.id');
            } elseif ($status == 'graded') {
                $query->whereNotNull('nilai.skor');
            }
        }
        
        // Ambil data untuk filter dropdown - hanya kelas yang diikuti siswa
        $kelas = DB::table('kelas')
            ->join('keanggotaan_kelas', function($join) use ($siswa_id) {
                $join->on('kelas.id', '=', 'keanggotaan_kelas.kelas_id')
                     ->where('keanggotaan_kelas.user_id', '=', $siswa_id);
            })
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->select('kelas.id', 'kelas.nama', 'kelas.jenjang', 'kelas.tingkat', 'tahun_ajaran.nama as tahun_ajaran')
            ->orderBy('kelas.jenjang')
            ->orderBy('kelas.tingkat')
            ->get();
        
        // Ambil data tugas
        $tugas = $query->orderBy('tugas.tenggat_waktu', 'asc')->paginate(10);
        
        return view('siswa.tugas.index', compact('tugas', 'kelas'));
    }
    
    /**
     * Menampilkan detail tugas
     */
    public function getShow($id)
    {
        $siswa_id = Auth::id();
        
        // Ambil data tugas
        $tugas = DB::table('tugas')
            ->join('kelas', 'tugas.kelas_id', '=', 'kelas.id')
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->select(
                'tugas.*',
                'kelas.nama as kelas_nama',
                'kelas.jenjang',
                'kelas.tingkat',
                'kelas.id as kelas_id',
                'tahun_ajaran.nama as tahun_ajaran_nama'
            )
            ->where('tugas.id', $id)
            ->first();
            
        if (!$tugas) {
            return redirect('/siswa/tugas')->with('error', 'Tugas tidak ditemukan');
        }
        
        // Cek apakah siswa terdaftar di kelas ini
        $terdaftar = DB::table('keanggotaan_kelas')
            ->where('user_id', $siswa_id)
            ->where('kelas_id', $tugas->kelas_id)
            ->exists();
            
        if (!$terdaftar) {
            return redirect('/siswa/tugas')->with('error', 'Anda tidak terdaftar di kelas ini');
        }
        
        // Ambil data pengumpulan tugas siswa ini
        $pengumpulan = DB::table('pengumpulan_tugas')
            ->leftJoin('nilai', 'pengumpulan_tugas.id', '=', 'nilai.pengumpulan_id')
            ->leftJoin('users as penilai', 'nilai.penilai_id', '=', 'penilai.id')
            ->select(
                'pengumpulan_tugas.*',
                'nilai.skor',
                'nilai.umpan_balik',
                'nilai.dinilai_pada',
                'penilai.name as penilai_nama'
            )
            ->where('pengumpulan_tugas.tugas_id', $id)
            ->where('pengumpulan_tugas.siswa_id', $siswa_id)
            ->first();
        
        return view('siswa.tugas.show', compact('tugas', 'pengumpulan'));
    }
    
    /**
     * Menampilkan form pengumpulan tugas
     */
    public function getSubmit($id)
    {
        $siswa_id = Auth::id();
        
        // Ambil data tugas
        $tugas = DB::table('tugas')
            ->join('kelas', 'tugas.kelas_id', '=', 'kelas.id')
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->select(
                'tugas.*',
                'kelas.nama as kelas_nama',
                'kelas.jenjang',
                'kelas.tingkat',
                'kelas.id as kelas_id',
                'tahun_ajaran.nama as tahun_ajaran_nama'
            )
            ->where('tugas.id', $id)
            ->first();
            
        if (!$tugas) {
            return redirect('/siswa/tugas')->with('error', 'Tugas tidak ditemukan');
        }
        
        // Cek apakah siswa terdaftar di kelas ini
        $terdaftar = DB::table('keanggotaan_kelas')
            ->where('user_id', $siswa_id)
            ->where('kelas_id', $tugas->kelas_id)
            ->exists();
            
        if (!$terdaftar) {
            return redirect('/siswa/tugas')->with('error', 'Anda tidak terdaftar di kelas ini');
        }
        
        // Ambil data pengumpulan tugas siswa ini
        $pengumpulan = DB::table('pengumpulan_tugas')
            ->where('tugas_id', $id)
            ->where('siswa_id', $siswa_id)
            ->first();
        
        return view('siswa.tugas.submit', compact('tugas', 'pengumpulan'));
    }
    
    /**
     * Menyimpan pengumpulan tugas
     */
    public function postSubmit(Request $request, $id)
    {
        $siswa_id = Auth::id();
        
        // Validasi input
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|max:10240', // Maksimal 10MB
        ], [
            'file.required' => 'File tugas harus diunggah',
            'file.file' => 'File tidak valid',
            'file.max' => 'Ukuran file maksimal 10MB',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Ambil data tugas
        $tugas = Tugas::findOrFail($id);
        
        // Cek apakah siswa terdaftar di kelas ini
        $terdaftar = DB::table('keanggotaan_kelas')
            ->where('user_id', $siswa_id)
            ->where('kelas_id', $tugas->kelas_id)
            ->exists();
            
        if (!$terdaftar) {
            return redirect('/siswa/tugas')->with('error', 'Anda tidak terdaftar di kelas ini');
        }
        
        // Cek apakah sudah ada pengumpulan
        $pengumpulan = PengumpulanTugas::where('tugas_id', $id)
            ->where('siswa_id', $siswa_id)
            ->first();
            
        // Tentukan status pengumpulan
        $status = 'submitted';
        if ($tugas->tenggat_waktu && now() > $tugas->tenggat_waktu) {
            $status = 'late';
        }
        
        // Upload file
        $file = $request->file('file');
        $fileName = time() . '_' . $siswa_id . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('pengumpulan_tugas', $fileName, 'public');
        
        if ($pengumpulan) {
            // Hapus file lama jika ada
            if ($pengumpulan->path_file && Storage::exists('public/' . $pengumpulan->path_file)) {
                Storage::delete('public/' . $pengumpulan->path_file);
            }
            
            // Update pengumpulan
            $pengumpulan->path_file = $path;
            $pengumpulan->status = $status;
            $pengumpulan->waktu_pengumpulan = now();
            $pengumpulan->save();
        } else {
            // Buat pengumpulan baru
            $pengumpulan = new PengumpulanTugas();
            $pengumpulan->tugas_id = $id;
            $pengumpulan->siswa_id = $siswa_id;
            $pengumpulan->path_file = $path;
            $pengumpulan->status = $status;
            $pengumpulan->waktu_pengumpulan = now();
            $pengumpulan->save();
        }
        
        return redirect('/siswa/tugas/show/' . $id)->with('success', 'Tugas berhasil dikumpulkan');
    }
}