<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function getIndex()
    {
        $tahunAjaranAktif = DB::table('tahun_ajaran')->where('status', 'aktif')->first();
        $totalGuru = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('roles.name', 'Guru')
            ->count();
        $totalSiswa = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('roles.name', 'Siswa')
            ->count();
        $totalKelas = DB::table('kelas')->count();
        $totalMapel = DB::table('mata_pelajaran')->where('aktif', true)->count();

        $aktivitas = [];
        // Tugas terbaru
        $tugasTerbaru = DB::table('tugas')
            ->join('kelas', 'tugas.kelas_id', '=', 'kelas.id')
            ->leftJoin('users', 'kelas.guru_id', '=', 'users.id')
            ->select('tugas.*', 'users.nama as nama_guru', 'kelas.nama as nama_kelas')
            ->orderBy('tugas.created_at', 'desc')
            ->limit(3)
            ->get();
        foreach($tugasTerbaru as $tugas) {
            $aktivitas[] = [
                'tipe' => 'tugas',
                'pesan' => $tugas->nama_guru . ' telah mengumumkan tugas ' . $tugas->judul . ' untuk Kelas ' . $tugas->nama_kelas,
                'waktu' => $tugas->created_at,
                'icon' => 'ph-note-pencil',
                'color' => 'warning'
            ];
        }
        // Materi terbaru
        $materiTerbaru = DB::table('materi_kelas')
            ->join('kelas', 'materi_kelas.kelas_id', '=', 'kelas.id')
            ->leftJoin('users', 'kelas.guru_id', '=', 'users.id')
            ->select('materi_kelas.*', 'users.nama as nama_guru', 'kelas.nama as nama_kelas')
            ->orderBy('materi_kelas.created_at', 'desc')
            ->limit(3)
            ->get();
        foreach($materiTerbaru as $materi) {
            $aktivitas[] = [
                'tipe' => 'materi',
                'pesan' => $materi->nama_guru . ' telah mengunggah materi baru untuk Kelas ' . $materi->nama_kelas,
                'waktu' => $materi->created_at,
                'icon' => 'ph-book-open',
                'color' => 'primary'
            ];
        }
        // Nilai terbaru
        $nilaiTerbaru = DB::table('nilai')
            ->join('pengumpulan_tugas', 'nilai.pengumpulan_id', '=', 'pengumpulan_tugas.id')
            ->join('tugas', 'pengumpulan_tugas.tugas_id', '=', 'tugas.id')
            ->join('kelas', 'tugas.kelas_id', '=', 'kelas.id')
            ->join('users as siswa', 'pengumpulan_tugas.siswa_id', '=', 'siswa.id')
            ->join('users as guru', 'nilai.penilai_id', '=', 'guru.id')
            ->select('nilai.*', 'guru.nama as nama_guru', 'siswa.nama as nama_siswa', 'kelas.nama as nama_kelas')
            ->orderBy('nilai.created_at', 'desc')
            ->limit(3)
            ->get();
        foreach($nilaiTerbaru as $nilai) {
            $aktivitas[] = [
                'tipe' => 'nilai',
                'pesan' => $nilai->nama_guru . ' telah memberikan nilai untuk ' . $nilai->nama_siswa . ' di Kelas ' . $nilai->nama_kelas,
                'waktu' => $nilai->created_at,
                'icon' => 'ph-exam',
                'color' => 'success'
            ];
        }
        // Urutkan berdasarkan waktu terbaru
        usort($aktivitas, function($a, $b) {
            return strtotime($b['waktu']) - strtotime($a['waktu']);
        });
        // Ambil 5 aktivitas terbaru
        $aktivitas = array_slice($aktivitas, 0, 5);

        return view('admin.dashboard', [
            'tahunAjaranAktif' => $tahunAjaranAktif,
            'totalGuru' => $totalGuru,
            'totalSiswa' => $totalSiswa,
            'totalKelas' => $totalKelas,
            'totalMapel' => $totalMapel,
            'aktivitas' => $aktivitas,
        ]);
    }
}
