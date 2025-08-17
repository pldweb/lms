<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ERaportController extends Controller
{
    /**
     * Halaman utama E-Raport
     */
    public function getIndex(Request $request)
    {
        $data = [
            'title' => 'E-Raport - Laporan Nilai Siswa',
            'active_menu' => 'e-raport'
        ];

        // Ambil data kelas untuk filter
        $data['kelas'] = DB::table('kelas')
            ->join('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->select('kelas.*', 'tahun_ajaran.nama as tahun_ajaran_nama')
            ->where('kelas.deleted_at', null)
            ->where('tahun_ajaran.deleted_at', null)
            ->orderBy('kelas.jenjang')
            ->orderBy('kelas.tingkat')
            ->orderBy('kelas.nama')
            ->get();

        // Ambil data siswa berdasarkan filter
        $kelasId = $request->input('kelas_id');
        $semester = $request->input('semester', 1);
        
        if ($kelasId) {
            $data['siswa'] = DB::table('keanggotaan_kelas')
                ->join('users', 'keanggotaan_kelas.siswa_id', '=', 'users.id')
                ->join('kelas', 'keanggotaan_kelas.kelas_id', '=', 'kelas.id')
                ->join('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
                ->select(
                    'users.id as siswa_id',
                    'users.nama as siswa_nama',
                    'users.email as siswa_email',
                    'kelas.id as kelas_id',
                    'kelas.nama as kelas_nama',
                    'kelas.jenjang',
                    'kelas.tingkat',
                    'tahun_ajaran.nama as tahun_ajaran_nama'
                )
                ->where('keanggotaan_kelas.kelas_id', $kelasId)
                ->where('keanggotaan_kelas.deleted_at', null)
                ->where('users.deleted_at', null)
                ->where('kelas.deleted_at', null)
                ->orderBy('users.nama')
                ->get();

            // Ambil statistik nilai per siswa
            foreach ($data['siswa'] as $siswa) {
                $stats = DB::table('nilai_siswa')
                    ->where('siswa_id', $siswa->siswa_id)
                    ->where('kelas_id', $kelasId)
                    ->where('semester', $semester)
                    ->where('deleted_at', null)
                    ->selectRaw('
                        COUNT(*) as total_nilai,
                        AVG(nilai) as rata_rata,
                        MAX(nilai) as nilai_tertinggi,
                        MIN(nilai) as nilai_terendah,
                        COUNT(CASE WHEN nilai >= 75 THEN 1 END) as tuntas,
                        COUNT(CASE WHEN nilai < 75 THEN 1 END) as belum_tuntas
                    ')
                    ->first();
                
                $siswa->statistik = $stats;
            }
        } else {
            $data['siswa'] = collect();
        }

        $data['kelas_id'] = $kelasId;
        $data['semester'] = $semester;

        return view('admin.e-raport.index', $data);
    }

    /**
     * Preview raport siswa
     */
    public function getPreview(Request $request, $siswa_id)
    {
        $semester = $request->input('semester', 1);
        $kelas_id = $request->input('kelas_id');
        
        if (!$kelas_id) {
            return redirect('/admin/e-raport/')->with('error', 'Kelas harus dipilih!');
        }

        $data = $this->getRaportData($siswa_id, $kelas_id, $semester);
        
        if (!$data['siswa']) {
            return redirect('/admin/e-raport/')->with('error', 'Data siswa tidak ditemukan!');
        }

        $data['title'] = 'Preview E-Raport - ' . $data['siswa']->siswa_nama;
        $data['active_menu'] = 'e-raport';

        return view('admin.e-raport.preview', $data);
    }

    /**
     * Download PDF raport siswa
     */
    public function downloadPDF(Request $request, $siswa_id)
    {
        $semester = $request->input('semester', 1);
        $kelas_id = $request->input('kelas_id');
        
        if (!$kelas_id) {
            return redirect('/admin/e-raport/')->with('error', 'Kelas harus dipilih!');
        }

        $data = $this->getRaportData($siswa_id, $kelas_id, $semester);
        
        if (!$data['siswa']) {
            return redirect('/admin/e-raport/')->with('error', 'Data siswa tidak ditemukan!');
        }

        // Generate PDF
        $pdf = PDF::loadView('admin.e-raport.pdf', $data)
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'defaultFont' => 'sans-serif'
            ]);

        $filename = 'E-Raport_' . str_replace(' ', '_', $data['siswa']->siswa_nama) . 
                   '_Semester_' . $semester . '_' . date('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Download PDF raport untuk semua siswa dalam kelas
     */
    public function downloadClassPDF(Request $request)
    {
        $kelas_id = $request->input('kelas_id');
        $semester = $request->input('semester', 1);
        
        if (!$kelas_id) {
            return redirect('/admin/e-raport/')->with('error', 'Kelas harus dipilih!');
        }

        // Ambil data kelas
        $kelas = DB::table('kelas')
            ->join('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->select('kelas.*', 'tahun_ajaran.nama as tahun_ajaran_nama')
            ->where('kelas.id', $kelas_id)
            ->where('kelas.deleted_at', null)
            ->first();

        if (!$kelas) {
            return redirect('/admin/e-raport/')->with('error', 'Data kelas tidak ditemukan!');
        }

        // Ambil semua siswa dalam kelas
        $siswa_list = DB::table('keanggotaan_kelas')
            ->join('users', 'keanggotaan_kelas.siswa_id', '=', 'users.id')
            ->select('users.id as siswa_id', 'users.nama as siswa_nama')
            ->where('keanggotaan_kelas.kelas_id', $kelas_id)
            ->where('keanggotaan_kelas.deleted_at', null)
            ->where('users.deleted_at', null)
            ->orderBy('users.nama')
            ->get();

        $data = [
            'kelas' => $kelas,
            'semester' => $semester,
            'siswa_list' => $siswa_list,
            'raport_data' => []
        ];

        // Ambil data raport untuk setiap siswa
        foreach ($siswa_list as $siswa) {
            $raport = $this->getRaportData($siswa->siswa_id, $kelas_id, $semester);
            $data['raport_data'][] = $raport;
        }

        // Generate PDF
        $pdf = PDF::loadView('admin.e-raport.class-pdf', $data)
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'defaultFont' => 'sans-serif'
            ]);

        $filename = 'E-Raport_Kelas_' . str_replace(' ', '_', $kelas->jenjang . '_' . $kelas->tingkat . '_' . $kelas->nama) . 
                   '_Semester_' . $semester . '_' . date('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * API: Statistik nilai kelas
     */
    public function getKelasStats(Request $request)
    {
        $kelas_id = $request->input('kelas_id');
        $semester = $request->input('semester', 1);

        if (!$kelas_id) {
            return response()->json(['error' => 'Kelas ID diperlukan'], 400);
        }

        // Statistik umum
        $stats = DB::table('nilai_siswa')
            ->join('keanggotaan_kelas', function($join) {
                $join->on('nilai_siswa.siswa_id', '=', 'keanggotaan_kelas.siswa_id')
                     ->on('nilai_siswa.kelas_id', '=', 'keanggotaan_kelas.kelas_id');
            })
            ->where('nilai_siswa.kelas_id', $kelas_id)
            ->where('nilai_siswa.semester', $semester)
            ->where('nilai_siswa.deleted_at', null)
            ->where('keanggotaan_kelas.deleted_at', null)
            ->selectRaw('
                COUNT(DISTINCT nilai_siswa.siswa_id) as total_siswa,
                COUNT(*) as total_nilai,
                AVG(nilai_siswa.nilai) as rata_rata_kelas,
                MAX(nilai_siswa.nilai) as nilai_tertinggi,
                MIN(nilai_siswa.nilai) as nilai_terendah,
                COUNT(CASE WHEN nilai_siswa.nilai >= 75 THEN 1 END) as total_tuntas,
                COUNT(CASE WHEN nilai_siswa.nilai < 75 THEN 1 END) as total_belum_tuntas
            ')
            ->first();

        // Distribusi grade
        $gradeDistribution = DB::table('nilai_siswa')
            ->where('kelas_id', $kelas_id)
            ->where('semester', $semester)
            ->where('deleted_at', null)
            ->selectRaw('
                COUNT(CASE WHEN nilai >= 90 THEN 1 END) as grade_a,
                COUNT(CASE WHEN nilai >= 80 AND nilai < 90 THEN 1 END) as grade_b,
                COUNT(CASE WHEN nilai >= 70 AND nilai < 80 THEN 1 END) as grade_c,
                COUNT(CASE WHEN nilai >= 60 AND nilai < 70 THEN 1 END) as grade_d,
                COUNT(CASE WHEN nilai < 60 THEN 1 END) as grade_e
            ')
            ->first();

        // Mata pelajaran dengan nilai tertinggi dan terendah
        $mataPelajaranStats = DB::table('nilai_siswa')
            ->join('mata_pelajaran', 'nilai_siswa.mata_pelajaran_id', '=', 'mata_pelajaran.id')
            ->where('nilai_siswa.kelas_id', $kelas_id)
            ->where('nilai_siswa.semester', $semester)
            ->where('nilai_siswa.deleted_at', null)
            ->groupBy('mata_pelajaran.id', 'mata_pelajaran.nama', 'mata_pelajaran.kode')
            ->selectRaw('
                mata_pelajaran.nama as mata_pelajaran,
                mata_pelajaran.kode as kode,
                AVG(nilai_siswa.nilai) as rata_rata,
                COUNT(*) as total_nilai,
                COUNT(CASE WHEN nilai_siswa.nilai >= 75 THEN 1 END) as tuntas,
                COUNT(CASE WHEN nilai_siswa.nilai < 75 THEN 1 END) as belum_tuntas
            ')
            ->orderBy('rata_rata', 'desc')
            ->get();

        return response()->json([
            'statistik_umum' => $stats,
            'distribusi_grade' => $gradeDistribution,
            'mata_pelajaran_stats' => $mataPelajaranStats
        ]);
    }

    /**
     * Private method untuk mengambil data raport siswa
     */
    private function getRaportData($siswa_id, $kelas_id, $semester)
    {
        // Data siswa dan kelas
        $siswa = DB::table('keanggotaan_kelas')
            ->join('users', 'keanggotaan_kelas.siswa_id', '=', 'users.id')
            ->join('kelas', 'keanggotaan_kelas.kelas_id', '=', 'kelas.id')
            ->join('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->select(
                'users.id as siswa_id',
                'users.nama as siswa_nama',
                'users.email as siswa_email',
                'kelas.id as kelas_id',
                'kelas.nama as kelas_nama',
                'kelas.jenjang',
                'kelas.tingkat',
                'tahun_ajaran.nama as tahun_ajaran_nama'
            )
            ->where('keanggotaan_kelas.siswa_id', $siswa_id)
            ->where('keanggotaan_kelas.kelas_id', $kelas_id)
            ->where('keanggotaan_kelas.deleted_at', null)
            ->where('users.deleted_at', null)
            ->where('kelas.deleted_at', null)
            ->first();

        if (!$siswa) {
            return ['siswa' => null];
        }

        // Nilai siswa per mata pelajaran
        $nilai = DB::table('nilai_siswa')
            ->join('mata_pelajaran', 'nilai_siswa.mata_pelajaran_id', '=', 'mata_pelajaran.id')
            ->select(
                'mata_pelajaran.nama as mata_pelajaran',
                'mata_pelajaran.kode as kode_mata_pelajaran',
                'nilai_siswa.jenis_nilai',
                'nilai_siswa.nilai',
                'nilai_siswa.tanggal_nilai',
                'nilai_siswa.keterangan'
            )
            ->where('nilai_siswa.siswa_id', $siswa_id)
            ->where('nilai_siswa.kelas_id', $kelas_id)
            ->where('nilai_siswa.semester', $semester)
            ->where('nilai_siswa.deleted_at', null)
            ->orderBy('mata_pelajaran.nama')
            ->orderBy('nilai_siswa.jenis_nilai')
            ->get();

        // Group nilai per mata pelajaran
        $nilaiPerMapel = $nilai->groupBy('mata_pelajaran');

        // Hitung rata-rata per mata pelajaran
        $rataRataMapel = [];
        foreach ($nilaiPerMapel as $mapel => $nilaiMapel) {
            $rataRataMapel[$mapel] = [
                'kode' => $nilaiMapel->first()->kode_mata_pelajaran,
                'rata_rata' => $nilaiMapel->avg('nilai'),
                'total_nilai' => $nilaiMapel->count(),
                'nilai_detail' => $nilaiMapel,
                'tuntas' => $nilaiMapel->avg('nilai') >= 75
            ];
        }

        // Statistik keseluruhan
        $statistikSiswa = DB::table('nilai_siswa')
            ->where('siswa_id', $siswa_id)
            ->where('kelas_id', $kelas_id)
            ->where('semester', $semester)
            ->where('deleted_at', null)
            ->selectRaw('
                COUNT(*) as total_nilai,
                AVG(nilai) as rata_rata,
                MAX(nilai) as nilai_tertinggi,
                MIN(nilai) as nilai_terendah,
                COUNT(CASE WHEN nilai >= 75 THEN 1 END) as tuntas,
                COUNT(CASE WHEN nilai < 75 THEN 1 END) as belum_tuntas,
                COUNT(CASE WHEN nilai >= 90 THEN 1 END) as grade_a,
                COUNT(CASE WHEN nilai >= 80 AND nilai < 90 THEN 1 END) as grade_b,
                COUNT(CASE WHEN nilai >= 70 AND nilai < 80 THEN 1 END) as grade_c,
                COUNT(CASE WHEN nilai >= 60 AND nilai < 70 THEN 1 END) as grade_d,
                COUNT(CASE WHEN nilai < 60 THEN 1 END) as grade_e
            ')
            ->first();

        // Ranking dalam kelas
        $ranking = DB::table('nilai_siswa')
            ->join('keanggotaan_kelas', function($join) {
                $join->on('nilai_siswa.siswa_id', '=', 'keanggotaan_kelas.siswa_id')
                     ->on('nilai_siswa.kelas_id', '=', 'keanggotaan_kelas.kelas_id');
            })
            ->where('nilai_siswa.kelas_id', $kelas_id)
            ->where('nilai_siswa.semester', $semester)
            ->where('nilai_siswa.deleted_at', null)
            ->where('keanggotaan_kelas.deleted_at', null)
            ->groupBy('nilai_siswa.siswa_id')
            ->selectRaw('
                nilai_siswa.siswa_id,
                AVG(nilai_siswa.nilai) as rata_rata_siswa
            ')
            ->orderBy('rata_rata_siswa', 'desc')
            ->get();

        $posisiRanking = $ranking->search(function($item) use ($siswa_id) {
            return $item->siswa_id == $siswa_id;
        }) + 1;

        return [
            'siswa' => $siswa,
            'semester' => $semester,
            'nilai_per_mapel' => $rataRataMapel,
            'statistik' => $statistikSiswa,
            'ranking' => $posisiRanking,
            'total_siswa_kelas' => $ranking->count(),
            'tanggal_cetak' => Carbon::now()->format('d F Y')
        ];
    }
}
