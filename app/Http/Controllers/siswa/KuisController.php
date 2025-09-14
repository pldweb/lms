<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kuis;
use App\Models\PertanyaanKuis;
use App\Models\JawabanKuis;
use App\Models\JawabanSiswaKuis;
use App\Models\HasilKuis;
use App\Models\Tugas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KuisController extends Controller
{
    public function getIndex(Request $request)
    {
        $user = Auth::user();
        
        // Ambil tugas kuis yang diberikan kepada kelas siswa
        $tugas = Tugas::with(['kelas', 'kuis'])
            ->whereHas('kelas.siswa', function($query) use ($user) {
                $query->where('users.id', $user->id);
            })
            ->where('is_kuis', true)
            ->where('kuis_id', '!=', null)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('siswa.kuis.index', compact('tugas'));
    }
    
    public function getMulaiKuis($tugasId)
    {
        $user = Auth::user();
        $tugas = Tugas::with('kuis')->findOrFail($tugasId);
        
        // Cek apakah tugas ini adalah kuis
        if (!$tugas->is_kuis || !$tugas->kuis_id) {
            return redirect('/siswa/tugas')->with('error', 'Tugas ini bukan kuis');
        }
        
        // Cek apakah siswa adalah anggota kelas
        $isSiswaKelas = DB::table('kelas_siswa')
            ->where('kelas_id', $tugas->kelas_id)
            ->where('siswa_id', $user->id)
            ->exists();
            
        if (!$isSiswaKelas) {
            return redirect('/siswa/kuis')->with('error', 'Anda tidak terdaftar di kelas ini');
        }
        
        // Cek apakah waktu pengerjaan sudah dimulai
        $now = Carbon::now();
        if ($tugas->waktu_mulai && $now->lt(Carbon::parse($tugas->waktu_mulai))) {
            return redirect('/siswa/kuis')->with('error', 'Kuis belum dimulai');
        }
        
        // Cek apakah waktu pengerjaan sudah berakhir
        if ($tugas->waktu_selesai && $now->gt(Carbon::parse($tugas->waktu_selesai))) {
            return redirect('/siswa/kuis')->with('error', 'Waktu pengerjaan kuis sudah berakhir');
        }
        
        // Cek apakah siswa sudah pernah mengerjakan kuis ini
        $hasilKuis = HasilKuis::where('siswa_id', $user->id)
            ->where('tugas_id', $tugasId)
            ->where('kuis_id', $tugas->kuis_id)
            ->where('status', 'selesai')
            ->first();
            
        if ($hasilKuis) {
            return redirect('/siswa/kuis/hasil/' . $hasilKuis->id)->with('info', 'Anda sudah mengerjakan kuis ini');
        }
        
        // Cek apakah siswa sedang mengerjakan kuis ini
        $hasilKuisBerlangsung = HasilKuis::where('siswa_id', $user->id)
            ->where('tugas_id', $tugasId)
            ->where('kuis_id', $tugas->kuis_id)
            ->where('status', 'berlangsung')
            ->first();
            
        if ($hasilKuisBerlangsung) {
            // Lanjutkan pengerjaan kuis
            return redirect('/siswa/kuis/kerjakan/' . $tugasId . '/' . $hasilKuisBerlangsung->id);
        }
        
        // Buat record hasil kuis baru
        $hasilKuis = new HasilKuis();
        $hasilKuis->tugas_id = $tugasId;
        $hasilKuis->kuis_id = $tugas->kuis_id;
        $hasilKuis->siswa_id = $user->id;
        $hasilKuis->nilai_total = 0;
        $hasilKuis->jumlah_benar = 0;
        $hasilKuis->jumlah_salah = 0;
        $hasilKuis->jumlah_tidak_dijawab = 0;
        $hasilKuis->waktu_mulai = Carbon::now();
        $hasilKuis->status = 'berlangsung';
        $hasilKuis->save();
        
        return redirect('/siswa/kuis/kerjakan/' . $tugasId . '/' . $hasilKuis->id);
    }
    
    public function getKerjakanKuis($tugasId, $hasilId)
    {
        $user = Auth::user();
        $hasil = HasilKuis::with(['kuis', 'tugas'])
            ->where('id', $hasilId)
            ->where('siswa_id', $user->id)
            ->where('tugas_id', $tugasId)
            ->where('status', 'berlangsung')
            ->firstOrFail();
        
        $tugas = $hasil->tugas;
        $kuis = $hasil->kuis;
        
        // Ambil pertanyaan kuis
        $pertanyaan = PertanyaanKuis::with(['jawaban' => function($query) {
            $query->orderBy('urutan', 'asc');
        }])
        ->where('kuis_id', $kuis->id);
        
        // Jika kuis diatur untuk acak soal
        if ($kuis->acak_soal) {
            $pertanyaan = $pertanyaan->inRandomOrder();
        } else {
            $pertanyaan = $pertanyaan->orderBy('urutan', 'asc');
        }
        
        // Batasi jumlah soal jika diatur
        if ($kuis->jumlah_soal > 0) {
            $pertanyaan = $pertanyaan->limit($kuis->jumlah_soal);
        }
        
        $pertanyaan = $pertanyaan->get();
        
        // Ambil jawaban siswa yang sudah ada
        $jawabanSiswa = JawabanSiswaKuis::where('siswa_id', $user->id)
            ->where('kuis_id', $kuis->id)
            ->pluck('jawaban_id', 'pertanyaan_id')
            ->toArray();
        
        // Hitung sisa waktu jika ada durasi
        $sisaWaktu = null;
        if ($tugas->durasi_menit > 0) {
            $waktuMulai = Carbon::parse($hasil->waktu_mulai);
            $waktuSelesai = $waktuMulai->copy()->addMinutes($tugas->durasi_menit);
            $now = Carbon::now();
            
            // Jika waktu sudah habis, selesaikan kuis
            if ($now->gt($waktuSelesai)) {
                return $this->selesaikanKuis($hasilId);
            }
            
            $sisaWaktu = $now->diffInSeconds($waktuSelesai);
        }
        
        return view('siswa.kuis.kerjakan', compact('tugas', 'kuis', 'pertanyaan', 'jawabanSiswa', 'hasil', 'sisaWaktu'));
    }
    
    public function postJawabPertanyaan(Request $request, $hasilId)
    {
        $user = Auth::user();
        $hasil = HasilKuis::where('id', $hasilId)
            ->where('siswa_id', $user->id)
            ->where('status', 'berlangsung')
            ->firstOrFail();
        
        $pertanyaanId = $request->pertanyaan_id;
        $pertanyaan = PertanyaanKuis::findOrFail($pertanyaanId);
        
        // Hapus jawaban sebelumnya jika ada
        JawabanSiswaKuis::where('siswa_id', $user->id)
            ->where('pertanyaan_id', $pertanyaanId)
            ->delete();
        
        $jawabanSiswa = new JawabanSiswaKuis();
        $jawabanSiswa->siswa_id = $user->id;
        $jawabanSiswa->pertanyaan_id = $pertanyaanId;
        $jawabanSiswa->waktu_mulai = Carbon::now();
        
        // Proses jawaban berdasarkan tipe pertanyaan
        switch ($pertanyaan->tipe) {
            case 'pilihan_ganda':
            case 'benar_salah':
                if ($request->filled('jawaban_id')) {
                    $jawabanId = $request->jawaban_id;
                    $jawaban = JawabanKuis::findOrFail($jawabanId);
                    
                    $jawabanSiswa->jawaban_id = $jawabanId;
                    $jawabanSiswa->is_benar = $jawaban->is_benar;
                    $jawabanSiswa->nilai = $jawaban->is_benar ? $pertanyaan->bobot_nilai : 0;
                }
                break;
                
            case 'isian':
            case 'esai':
                if ($request->filled('jawaban_teks')) {
                    $jawabanSiswa->jawaban_teks = $request->jawaban_teks;
                    
                    // Untuk isian, cek jawaban benar
                    if ($pertanyaan->tipe == 'isian') {
                        $jawabanBenar = JawabanKuis::where('pertanyaan_id', $pertanyaanId)
                            ->where('is_benar', true)
                            ->first();
                            
                        if ($jawabanBenar) {
                            // Cek apakah jawaban siswa sama dengan jawaban benar (case insensitive)
                            $isBenar = strtolower(trim($request->jawaban_teks)) == strtolower(trim($jawabanBenar->jawaban));
                            $jawabanSiswa->is_benar = $isBenar;
                            $jawabanSiswa->nilai = $isBenar ? $pertanyaan->bobot_nilai : 0;
                        }
                    }
                    // Untuk esai, nilai akan diisi oleh guru
                }
                break;
        }
        
        $jawabanSiswa->waktu_selesai = Carbon::now();
        $jawabanSiswa->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Jawaban berhasil disimpan'
        ]);
    }
    
    public function postSelesaikanKuis(Request $request, $hasilId)
    {
        return $this->selesaikanKuis($hasilId);
    }
    
    private function selesaikanKuis($hasilId)
    {
        $user = Auth::user();
        $hasil = HasilKuis::with(['kuis', 'tugas'])
            ->where('id', $hasilId)
            ->where('siswa_id', $user->id)
            ->where('status', 'berlangsung')
            ->firstOrFail();
        
        // Hitung hasil kuis
        $jawabanSiswa = JawabanSiswaKuis::where('siswa_id', $user->id)
            ->where('pertanyaan_id', 'in', function($query) use ($hasil) {
                $query->select('id')
                    ->from('pertanyaan_kuis')
                    ->where('kuis_id', $hasil->kuis_id);
            })
            ->get();
        
        $jumlahBenar = $jawabanSiswa->where('is_benar', true)->count();
        $jumlahSalah = $jawabanSiswa->where('is_benar', false)->count();
        
        // Hitung jumlah pertanyaan yang tidak dijawab
        $pertanyaanIds = PertanyaanKuis::where('kuis_id', $hasil->kuis_id)->pluck('id');
        $jawabanPertanyaanIds = $jawabanSiswa->pluck('pertanyaan_id');
        $jumlahTidakDijawab = $pertanyaanIds->diff($jawabanPertanyaanIds)->count();
        
        // Hitung nilai total
        $nilaiTotal = $jawabanSiswa->sum('nilai');
        
        // Update hasil kuis
        $hasil->nilai_total = $nilaiTotal;
        $hasil->jumlah_benar = $jumlahBenar;
        $hasil->jumlah_salah = $jumlahSalah;
        $hasil->jumlah_tidak_dijawab = $jumlahTidakDijawab;
        $hasil->waktu_selesai = Carbon::now();
        $hasil->status = 'selesai';
        $hasil->save();
        
        return redirect('/siswa/kuis/hasil/' . $hasilId)->with('success', 'Kuis berhasil diselesaikan');
    }
    
    public function getHasilKuis($hasilId)
    {
        $user = Auth::user();
        $hasil = HasilKuis::with(['kuis', 'tugas', 'siswa'])
            ->where('id', $hasilId)
            ->where('siswa_id', $user->id)
            ->firstOrFail();
        
        // Jika kuis belum selesai, redirect ke halaman pengerjaan
        if ($hasil->status == 'berlangsung') {
            return redirect('/siswa/kuis/kerjakan/' . $hasil->tugas_id . '/' . $hasil->id);
        }
        
        // Ambil jawaban siswa
        $jawabanSiswa = JawabanSiswaKuis::with(['pertanyaan', 'jawaban'])
            ->where('siswa_id', $user->id)
            ->whereHas('pertanyaan', function($query) use ($hasil) {
                $query->where('kuis_id', $hasil->kuis_id);
            })
            ->get();
        
        // Cek apakah hasil kuis boleh ditampilkan
        $tampilkanHasil = $hasil->kuis->tampilkan_hasil;
        
        return view('siswa.kuis.hasil', compact('hasil', 'jawabanSiswa', 'tampilkanHasil'));
    }
    
    public function getRiwayatKuis()
    {
        $user = Auth::user();
        $hasilKuis = HasilKuis::with(['kuis', 'tugas'])
            ->where('siswa_id', $user->id)
            ->where('status', 'selesai')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('siswa.kuis.riwayat', compact('hasilKuis'));
    }
}