<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nilai;
use App\Models\PengumpulanTugas;
use App\Models\Tugas;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NilaiController extends Controller
{
    
    public function getIndex(Request $request)
    {
        // Mendapatkan ID guru yang sedang login
        $guru_id = Auth::id();
        
        // Mendapatkan kelas yang diajar oleh guru
        $kelas_ids = Kelas::where('guru_id', $guru_id)->pluck('id');
        
        // Query dasar untuk nilai
        $query = Nilai::with(['pengumpulanTugas.tugas.kelas', 'pengumpulanTugas.siswa'])
            ->whereHas('pengumpulanTugas.tugas', function($q) use ($kelas_ids) {
                $q->whereIn('kelas_id', $kelas_ids);
            });
        
        // Filter berdasarkan pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->whereHas('pengumpulanTugas.siswa', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhereHas('pengumpulanTugas.tugas', function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%");
            });
        }
        
        // Filter berdasarkan kelas
        if ($request->has('kelas_id') && !empty($request->kelas_id)) {
            $query->whereHas('pengumpulanTugas.tugas', function($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }
        
        // Filter berdasarkan rentang nilai
        if ($request->has('min_score') && !empty($request->min_score)) {
            $query->where('skor', '>=', $request->min_score);
        }
        
        if ($request->has('max_score') && !empty($request->max_score)) {
            $query->where('skor', '<=', $request->max_score);
        }
        
        // Mendapatkan data nilai dengan pagination
        $nilai = $query->orderBy('dinilai_pada', 'desc')->paginate(10);
        
        // Mendapatkan daftar kelas untuk filter
        $kelas = Kelas::where('guru_id', $guru_id)->get();
        
        // Export data jika diminta
        if ($request->has('export')) {
            $nilai_all = $query->get();
            
            if ($request->export == 'csv') {
                return $this->exportCSV($nilai_all);
            } elseif ($request->export == 'json') {
                return $this->exportJSON($nilai_all);
            }
        }
        
        return view('guru.nilai.index', compact('nilai', 'kelas'));
    }
    
    /**
     * Menampilkan detail nilai tugas
     */
    public function getShow($id)
    {
        // Mendapatkan ID guru yang sedang login
        $guru_id = Auth::id();
        
        // Mendapatkan data nilai
        $nilai = Nilai::with(['pengumpulanTugas.tugas.kelas', 'pengumpulanTugas.siswa'])
            ->findOrFail($id);
        
        // Verifikasi bahwa guru mengajar kelas tersebut
        $kelas_id = $nilai->pengumpulanTugas->tugas->kelas_id;
        $kelas = Kelas::where('id', $kelas_id)
            ->where('guru_id', $guru_id)
            ->first();
        
        if (!$kelas) {
            return redirect('/guru/nilai')->with('error', 'Anda tidak memiliki akses ke nilai ini');
        }
        
        return view('guru.nilai.show', compact('nilai'));
    }
    
    /**
     * Menampilkan form untuk mengedit nilai
     */
    public function getEdit($id)
    {
        // Mendapatkan ID guru yang sedang login
        $guru_id = Auth::id();
        
        // Mendapatkan data nilai
        $nilai = Nilai::with(['pengumpulanTugas.tugas.kelas', 'pengumpulanTugas.siswa'])
            ->findOrFail($id);
        
        // Verifikasi bahwa guru mengajar kelas tersebut
        $kelas_id = $nilai->pengumpulanTugas->tugas->kelas_id;
        $kelas = Kelas::where('id', $kelas_id)
            ->where('guru_id', $guru_id)
            ->first();
        
        if (!$kelas) {
            return redirect('/guru/nilai')->with('error', 'Anda tidak memiliki akses ke nilai ini');
        }
        
        return view('guru.nilai.edit', compact('nilai'));
    }
    
    /**
     * Menyimpan perubahan nilai
     */
    public function postUpdate(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'skor' => 'required|numeric|min:0|max:100',
            'umpan_balik' => 'nullable|string',
        ]);
        
        // Mendapatkan ID guru yang sedang login
        $guru_id = Auth::id();
        
        // Mendapatkan data nilai
        $nilai = Nilai::with(['pengumpulanTugas.tugas.kelas'])
            ->findOrFail($id);
        
        // Verifikasi bahwa guru mengajar kelas tersebut
        $kelas_id = $nilai->pengumpulanTugas->tugas->kelas_id;
        $kelas = Kelas::where('id', $kelas_id)
            ->where('guru_id', $guru_id)
            ->first();
        
        if (!$kelas) {
            return redirect('/guru/nilai')->with('error', 'Anda tidak memiliki akses ke nilai ini');
        }
        
        // Update nilai
        $nilai->skor = $request->skor;
        $nilai->umpan_balik = $request->umpan_balik;
        $nilai->dinilai_pada = now();
        $nilai->save();
        
        return redirect('/guru/nilai')->with('success', 'Nilai berhasil diperbarui');
    }
    
    /**
     * Export data nilai ke CSV
     */
    public function exportCSV($nilai = null)
    {
        if (!$nilai) {
            // Mendapatkan ID guru yang sedang login
            $guru_id = Auth::id();
            
            // Mendapatkan kelas yang diajar oleh guru
            $kelas_ids = Kelas::where('guru_id', $guru_id)->pluck('id');
            
            // Mendapatkan semua data nilai
            $nilai = Nilai::with(['pengumpulanTugas.tugas.kelas', 'pengumpulanTugas.siswa'])
                ->whereHas('pengumpulanTugas.tugas', function($q) use ($kelas_ids) {
                    $q->whereIn('kelas_id', $kelas_ids);
                })
                ->get();
        }
        
        $filename = 'nilai_' . date('YmdHis') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($nilai) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Nama Siswa', 'Email', 'Judul Tugas', 'Kelas', 'Nilai', 'Tanggal Penilaian']);
            
            foreach ($nilai as $n) {
                fputcsv($file, [
                    $n->id,
                    $n->pengumpulanTugas->siswa->name,
                    $n->pengumpulanTugas->siswa->email,
                    $n->pengumpulanTugas->tugas->judul,
                    $n->pengumpulanTugas->tugas->kelas->nama,
                    $n->skor,
                    date('d/m/Y H:i', strtotime($n->dinilai_pada)),
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
    
    /**
     * Export data nilai ke JSON
     */
    public function exportJSON($nilai = null)
    {
        if (!$nilai) {
            // Mendapatkan ID guru yang sedang login
            $guru_id = Auth::id();
            
            // Mendapatkan kelas yang diajar oleh guru
            $kelas_ids = Kelas::where('guru_id', $guru_id)->pluck('id');
            
            // Mendapatkan semua data nilai
            $nilai = Nilai::with(['pengumpulanTugas.tugas.kelas', 'pengumpulanTugas.siswa'])
                ->whereHas('pengumpulanTugas.tugas', function($q) use ($kelas_ids) {
                    $q->whereIn('kelas_id', $kelas_ids);
                })
                ->get();
        }
        
        $data = [];
        
        foreach ($nilai as $n) {
            $data[] = [
                'id' => $n->id,
                'siswa' => [
                    'id' => $n->pengumpulanTugas->siswa->id,
                    'name' => $n->pengumpulanTugas->siswa->name,
                    'email' => $n->pengumpulanTugas->siswa->email,
                ],
                'tugas' => [
                    'id' => $n->pengumpulanTugas->tugas->id,
                    'judul' => $n->pengumpulanTugas->tugas->judul,
                    'kelas' => $n->pengumpulanTugas->tugas->kelas->nama,
                ],
                'skor' => $n->skor,
                'dinilai_pada' => date('Y-m-d H:i:s', strtotime($n->dinilai_pada)),
            ];
        }
        
        $filename = 'nilai_' . date('YmdHis') . '.json';
        $headers = [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        return response()->json($data, 200, $headers);
    }
}