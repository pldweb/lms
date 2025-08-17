<?php

namespace App\Http\Controllers\Siswa;

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
    /**
     * Menampilkan daftar nilai tugas siswa
     */
    public function getIndex(Request $request)
    {
        // Mendapatkan ID siswa yang sedang login
        $siswa_id = Auth::id();
        
        // Query dasar untuk nilai
        $query = Nilai::with(['pengumpulanTugas.tugas.kelas'])
            ->whereHas('pengumpulanTugas', function($q) use ($siswa_id) {
                $q->where('siswa_id', $siswa_id);
            });
        
        // Filter berdasarkan pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->whereHas('pengumpulanTugas.tugas', function($q) use ($search) {
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
        $kelas = Kelas::whereHas('anggota', function($q) use ($siswa_id) {
            $q->where('user_id', $siswa_id);
        })->get();
        
        // Export data jika diminta
        if ($request->has('export')) {
            $nilai_all = $query->get();
            
            if ($request->export == 'csv') {
                return $this->exportCSV($nilai_all);
            } elseif ($request->export == 'json') {
                return $this->exportJSON($nilai_all);
            }
        }
        
        return view('siswa.nilai.index', compact('nilai', 'kelas'));
    }
    
    /**
     * Menampilkan detail nilai tugas
     */
    public function getShow($id)
    {
        // Mendapatkan ID siswa yang sedang login
        $siswa_id = Auth::id();
        
        // Mendapatkan data nilai
        $nilai = Nilai::with(['pengumpulanTugas.tugas.kelas', 'pengumpulanTugas.siswa'])
            ->findOrFail($id);
        
        // Verifikasi bahwa nilai tersebut milik siswa yang sedang login
        if ($nilai->pengumpulanTugas->siswa_id != $siswa_id) {
            return redirect('/siswa/nilai')->with('error', 'Anda tidak memiliki akses ke nilai ini');
        }
        
        return view('siswa.nilai.show', compact('nilai'));
    }
    
    /**
     * Export data nilai ke CSV
     */
    public function exportCSV($nilai = null)
    {
        if (!$nilai) {
            // Mendapatkan ID siswa yang sedang login
            $siswa_id = Auth::id();
            
            // Mendapatkan semua data nilai
            $nilai = Nilai::with(['pengumpulanTugas.tugas.kelas'])
                ->whereHas('pengumpulanTugas', function($q) use ($siswa_id) {
                    $q->where('siswa_id', $siswa_id);
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
            fputcsv($file, ['ID', 'Judul Tugas', 'Kelas', 'Nilai', 'Tanggal Penilaian']);
            
            foreach ($nilai as $n) {
                fputcsv($file, [
                    $n->id,
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
            // Mendapatkan ID siswa yang sedang login
            $siswa_id = Auth::id();
            
            // Mendapatkan semua data nilai
            $nilai = Nilai::with(['pengumpulanTugas.tugas.kelas'])
                ->whereHas('pengumpulanTugas', function($q) use ($siswa_id) {
                    $q->where('siswa_id', $siswa_id);
                })
                ->get();
        }
        
        $data = [];
        
        foreach ($nilai as $n) {
            $data[] = [
                'id' => $n->id,
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