<?php

namespace App\Http\Controllers\guru;

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
     * Menampilkan daftar tugas untuk guru
     */
    public function getIndex(Request $request)
    {
        $guru_id = Auth::id();
        
        // Filter data
        $search = $request->input('search');
        $kelas_id = $request->input('kelas_id');
        $tahun_ajaran_id = $request->input('tahun_ajaran_id');
        
        // Query dasar - hanya ambil kelas yang diajar oleh guru ini
        $query = DB::table('tugas')
            ->join('kelas', 'tugas.kelas_id', '=', 'kelas.id')
            ->join('pengajar', function($join) use ($guru_id) {
                $join->on('kelas.id', '=', 'pengajar.kelas_id')
                     ->where('pengajar.guru_id', '=', $guru_id);
            })
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
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
                DB::raw('(SELECT COUNT(*) FROM pengumpulan_tugas WHERE pengumpulan_tugas.tugas_id = tugas.id) as jumlah_pengumpulan')
            )
            ->groupBy(
                'tugas.id',
                'tugas.judul',
                'tugas.instruksi',
                'tugas.tenggat_waktu',
                'tugas.created_at',
                'kelas.nama',
                'kelas.jenjang',
                'kelas.tingkat',
                'tahun_ajaran.nama'
            );
        
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
        
        if ($tahun_ajaran_id) {
            $query->where('kelas.tahun_ajaran_id', $tahun_ajaran_id);
        }
        
        // Ambil data untuk filter dropdown - hanya kelas yang diajar oleh guru ini
        $kelas = DB::table('kelas')
            ->join('pengajar', function($join) use ($guru_id) {
                $join->on('kelas.id', '=', 'pengajar.kelas_id')
                     ->where('pengajar.guru_id', '=', $guru_id);
            })
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->select('kelas.id', 'kelas.nama', 'kelas.jenjang', 'kelas.tingkat', 'tahun_ajaran.nama as tahun_ajaran')
            ->orderBy('kelas.jenjang')
            ->orderBy('kelas.tingkat')
            ->get();
            
        $tahunAjaran = DB::table('tahun_ajaran')
            ->select('id', 'nama')
            ->orderBy('tanggal_mulai', 'desc')
            ->get();
        
        // Ambil data tugas
        $tugas = $query->orderBy('tugas.created_at', 'desc')->paginate(10);
        
        return view('guru.tugas.index', compact('tugas', 'kelas', 'tahunAjaran'));
    }
    
    /**
     * Menampilkan form tambah tugas
     */
    public function getCreate()
    {
        $guru_id = Auth::id();
        
        // Ambil data kelas yang diajar oleh guru ini
        $kelas = DB::table('kelas')
            ->join('pengajar', function($join) use ($guru_id) {
                $join->on('kelas.id', '=', 'pengajar.kelas_id')
                     ->where('pengajar.guru_id', '=', $guru_id);
            })
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->where('kelas.is_active', true)
            ->select('kelas.id', 'kelas.nama', 'kelas.jenjang', 'kelas.tingkat', 'tahun_ajaran.nama as tahun_ajaran')
            ->orderBy('kelas.jenjang')
            ->orderBy('kelas.tingkat')
            ->get();
            
        return view('guru.tugas.create', compact('kelas'));
    }
    
    /**
     * Menyimpan tugas baru
     */
    public function postStore(Request $request)
    {
        $guru_id = Auth::id();
        
        // Validasi input
        $validator = Validator::make($request->all(), [
            'kelas_id' => 'required|exists:kelas,id',
            'judul' => 'required|string|max:255',
            'tenggat_waktu' => 'nullable|date',
            'instruksi' => 'nullable|string',
        ], [
            'kelas_id.required' => 'Kelas harus dipilih',
            'kelas_id.exists' => 'Kelas tidak valid',
            'judul.required' => 'Judul tugas harus diisi',
            'judul.max' => 'Judul tugas maksimal 255 karakter',
            'tenggat_waktu.date' => 'Format tanggal tidak valid',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Cek apakah guru mengajar di kelas ini
        $mengajar = DB::table('pengajar')
            ->where('guru_id', $guru_id)
            ->where('kelas_id', $request->kelas_id)
            ->exists();
            
        if (!$mengajar) {
            return redirect()->back()
                ->with('error', 'Anda tidak mengajar di kelas ini')
                ->withInput();
        }
        
        // Simpan tugas baru
        $tugas = new Tugas();
        $tugas->kelas_id = $request->kelas_id;
        $tugas->judul = $request->judul;
        $tugas->tenggat_waktu = $request->tenggat_waktu;
        $tugas->instruksi = $request->instruksi;
        $tugas->save();
        
        return redirect('/guru/tugas')->with('success', 'Tugas berhasil ditambahkan');
    }
    
    /**
     * Menampilkan detail tugas dan pengumpulan
     */
    public function getShow($id)
    {
        $guru_id = Auth::id();
        
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
            return redirect('/guru/tugas')->with('error', 'Tugas tidak ditemukan');
        }
        
        // Cek apakah guru mengajar di kelas ini
        $mengajar = DB::table('pengajar')
            ->where('guru_id', $guru_id)
            ->where('kelas_id', $tugas->kelas_id)
            ->exists();
            
        if (!$mengajar) {
            return redirect('/guru/tugas')->with('error', 'Anda tidak mengajar di kelas ini');
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
            
        // Ambil daftar siswa yang belum mengumpulkan
        $siswa_kelas = DB::table('keanggotaan_kelas')
            ->select('users.id', 'users.name', 'users.email')
            ->join('users', 'keanggotaan_kelas.user_id', '=', 'users.id')
            ->where('keanggotaan_kelas.kelas_id', $tugas->kelas_id)
            ->where('users.role', 'siswa')
            ->whereNotIn('users.id', $pengumpulan->pluck('siswa_id')->toArray())
            ->orderBy('users.name')
            ->get();
            
        // Buat pengumpulan kosong untuk siswa yang belum mengumpulkan
        foreach ($siswa_kelas as $siswa) {
            $pengumpulan_kosong = new \stdClass();
            $pengumpulan_kosong->id = null;
            $pengumpulan_kosong->status = 'not_submitted';
            $pengumpulan_kosong->path_file = null;
            $pengumpulan_kosong->waktu_pengumpulan = null;
            $pengumpulan_kosong->siswa_id = $siswa->id;
            $pengumpulan_kosong->siswa_nama = $siswa->name;
            $pengumpulan_kosong->siswa_email = $siswa->email;
            $pengumpulan_kosong->skor = null;
            $pengumpulan_kosong->umpan_balik = null;
            
            $pengumpulan->push($pengumpulan_kosong);
        }
        
        // Urutkan pengumpulan berdasarkan nama siswa
        $pengumpulan = $pengumpulan->sortBy('siswa_nama');
        
        return view('guru.tugas.show', compact('tugas', 'pengumpulan'));
    }
    
    /**
     * Menampilkan form edit tugas
     */
    public function getEdit($id)
    {
        $guru_id = Auth::id();
        
        // Ambil data tugas
        $tugas = Tugas::findOrFail($id);
        
        // Cek apakah guru mengajar di kelas ini
        $mengajar = DB::table('pengajar')
            ->where('guru_id', $guru_id)
            ->where('kelas_id', $tugas->kelas_id)
            ->exists();
            
        if (!$mengajar) {
            return redirect('/guru/tugas')->with('error', 'Anda tidak mengajar di kelas ini');
        }
        
        // Data untuk dropdown
        $kelas = DB::table('kelas')
            ->join('pengajar', function($join) use ($guru_id) {
                $join->on('kelas.id', '=', 'pengajar.kelas_id')
                     ->where('pengajar.guru_id', '=', $guru_id);
            })
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->where('kelas.is_active', true)
            ->select('kelas.id', 'kelas.nama', 'kelas.jenjang', 'kelas.tingkat', 'tahun_ajaran.nama as tahun_ajaran')
            ->orderBy('kelas.jenjang')
            ->orderBy('kelas.tingkat')
            ->get();
            
        return view('guru.tugas.edit', compact('tugas', 'kelas'));
    }
    
    /**
     * Menyimpan perubahan tugas
     */
    public function postUpdate(Request $request, $id)
    {
        $guru_id = Auth::id();
        
        // Validasi input
        $validator = Validator::make($request->all(), [
            'kelas_id' => 'required|exists:kelas,id',
            'judul' => 'required|string|max:255',
            'tenggat_waktu' => 'nullable|date',
            'instruksi' => 'nullable|string',
        ], [
            'kelas_id.required' => 'Kelas harus dipilih',
            'kelas_id.exists' => 'Kelas tidak valid',
            'judul.required' => 'Judul tugas harus diisi',
            'judul.max' => 'Judul tugas maksimal 255 karakter',
            'tenggat_waktu.date' => 'Format tanggal tidak valid',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Ambil data tugas
        $tugas = Tugas::findOrFail($id);
        
        // Cek apakah guru mengajar di kelas ini (kelas lama)
        $mengajar_lama = DB::table('pengajar')
            ->where('guru_id', $guru_id)
            ->where('kelas_id', $tugas->kelas_id)
            ->exists();
            
        if (!$mengajar_lama) {
            return redirect('/guru/tugas')->with('error', 'Anda tidak mengajar di kelas ini');
        }
        
        // Cek apakah guru mengajar di kelas baru (jika kelas diubah)
        if ($tugas->kelas_id != $request->kelas_id) {
            $mengajar_baru = DB::table('pengajar')
                ->where('guru_id', $guru_id)
                ->where('kelas_id', $request->kelas_id)
                ->exists();
                
            if (!$mengajar_baru) {
                return redirect()->back()
                    ->with('error', 'Anda tidak mengajar di kelas yang dipilih')
                    ->withInput();
            }
        }
        
        // Update tugas
        $tugas->kelas_id = $request->kelas_id;
        $tugas->judul = $request->judul;
        $tugas->tenggat_waktu = $request->tenggat_waktu;
        $tugas->instruksi = $request->instruksi;
        $tugas->save();
        
        return redirect('/guru/tugas/show/' . $id)->with('success', 'Tugas berhasil diperbarui');
    }
    
    /**
     * Menghapus tugas
     */
    public function getDelete($id)
    {
        $guru_id = Auth::id();
        
        $tugas = Tugas::findOrFail($id);
        
        // Cek apakah guru mengajar di kelas ini
        $mengajar = DB::table('pengajar')
            ->where('guru_id', $guru_id)
            ->where('kelas_id', $tugas->kelas_id)
            ->exists();
            
        if (!$mengajar) {
            return redirect('/guru/tugas')->with('error', 'Anda tidak mengajar di kelas ini');
        }
        
        // Cek apakah ada pengumpulan tugas
        $pengumpulan = PengumpulanTugas::where('tugas_id', $id)->get();
        
        // Hapus file pengumpulan jika ada
        foreach ($pengumpulan as $p) {
            if ($p->path_file && Storage::exists($p->path_file)) {
                Storage::delete($p->path_file);
            }
            
            // Hapus nilai terkait
            Nilai::where('pengumpulan_id', $p->id)->delete();
        }
        
        // Hapus pengumpulan tugas
        PengumpulanTugas::where('tugas_id', $id)->delete();
        
        // Hapus tugas
        $tugas->delete();
        
        return redirect('/guru/tugas')->with('success', 'Tugas berhasil dihapus');
    }
    
    /**
     * Menampilkan form penilaian tugas
     */
    public function getNilai($id)
    {
        $guru_id = Auth::id();
        
        // Ambil data pengumpulan tugas
        $pengumpulan = DB::table('pengumpulan_tugas')
            ->join('users', 'pengumpulan_tugas.siswa_id', '=', 'users.id')
            ->join('tugas', 'pengumpulan_tugas.tugas_id', '=', 'tugas.id')
            ->join('kelas', 'tugas.kelas_id', '=', 'kelas.id')
            ->leftJoin('nilai', 'pengumpulan_tugas.id', '=', 'nilai.pengumpulan_id')
            ->select(
                'pengumpulan_tugas.*',
                'users.name as siswa_nama',
                'users.email as siswa_email',
                'tugas.judul as tugas_judul',
                'tugas.kelas_id',
                'nilai.skor',
                'nilai.umpan_balik'
            )
            ->where('pengumpulan_tugas.id', $id)
            ->first();
            
        if (!$pengumpulan) {
            return redirect('/guru/tugas')->with('error', 'Pengumpulan tugas tidak ditemukan');
        }
        
        // Cek apakah guru mengajar di kelas ini
        $mengajar = DB::table('pengajar')
            ->where('guru_id', $guru_id)
            ->where('kelas_id', $pengumpulan->kelas_id)
            ->exists();
            
        if (!$mengajar) {
            return redirect('/guru/tugas')->with('error', 'Anda tidak mengajar di kelas ini');
        }
        
        return view('guru.tugas.nilai', compact('pengumpulan'));
    }
    
    /**
     * Menyimpan nilai tugas
     */
    public function postNilai(Request $request, $id)
    {
        $guru_id = Auth::id();
        
        // Validasi input
        $validator = Validator::make($request->all(), [
            'skor' => 'required|numeric|min:0|max:100',
            'umpan_balik' => 'nullable|string',
        ], [
            'skor.required' => 'Nilai harus diisi',
            'skor.numeric' => 'Nilai harus berupa angka',
            'skor.min' => 'Nilai minimal 0',
            'skor.max' => 'Nilai maksimal 100',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Ambil data pengumpulan tugas
        $pengumpulan = PengumpulanTugas::findOrFail($id);
        
        // Ambil data tugas
        $tugas = Tugas::findOrFail($pengumpulan->tugas_id);
        
        // Cek apakah guru mengajar di kelas ini
        $mengajar = DB::table('pengajar')
            ->where('guru_id', $guru_id)
            ->where('kelas_id', $tugas->kelas_id)
            ->exists();
            
        if (!$mengajar) {
            return redirect('/guru/tugas')->with('error', 'Anda tidak mengajar di kelas ini');
        }
        
        // Cek apakah sudah ada nilai
        $nilai = Nilai::where('pengumpulan_id', $id)->first();
        
        if (!$nilai) {
            // Buat nilai baru
            $nilai = new Nilai();
            $nilai->pengumpulan_id = $id;
            $nilai->penilai_id = $guru_id;
        }
        
        // Update nilai
        $nilai->skor = $request->skor;
        $nilai->umpan_balik = $request->umpan_balik;
        $nilai->dinilai_pada = now();
        $nilai->save();
        
        return redirect('/guru/tugas/show/' . $pengumpulan->tugas_id)->with('success', 'Nilai berhasil disimpan');
    }
}