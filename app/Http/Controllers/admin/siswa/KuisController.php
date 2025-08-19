<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kuis;
use App\Models\PertanyaanKuis;
use App\Models\JawabanKuis;
use App\Models\JawabanSiswaKuis;
use App\Models\Tugas;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KuisController extends Controller
{
    public function getKuis($tugasId)
    {
        // Cek apakah tugas ada dan merupakan kuis
        $tugas = Tugas::join('keanggotaan_kelas', function($join) {
                $join->on('tugas.kelas_id', '=', 'keanggotaan_kelas.kelas_id')
                    ->where('keanggotaan_kelas.siswa_id', '=', Auth::id());
            })
            ->where('tugas.id', $tugasId)
            ->where('tugas.is_kuis', true)
            ->select('tugas.*')
            ->first();
            
        if (!$tugas || !$tugas->kuis_id) {
            return redirect('/siswa/tugas')->with('error', 'Tugas tidak ditemukan atau bukan kuis');
        }

        // Cek apakah waktu pengerjaan kuis sudah dimulai
        $now = Carbon::now();
        if ($tugas->waktu_mulai && $now < Carbon::parse($tugas->waktu_mulai)) {
            return redirect('/siswa/tugas')->with('error', 'Kuis belum dimulai');
        }

        // Cek apakah waktu pengerjaan kuis sudah berakhir
        if ($tugas->waktu_selesai && $now > Carbon::parse($tugas->waktu_selesai)) {
            return redirect('/siswa/tugas/show/' . $tugasId)->with('error', 'Waktu pengerjaan kuis sudah berakhir');
        }

        // Ambil data kuis
        $kuis = Kuis::findOrFail($tugas->kuis_id);

        // Cek jumlah percobaan
        $jumlahPercobaanSiswa = JawabanSiswaKuis::where('tugas_id', $tugasId)
            ->where('siswa_id', Auth::id())
            ->select(DB::raw('COUNT(DISTINCT waktu_menjawab) as jumlah_percobaan'))
            ->first();

        if ($jumlahPercobaanSiswa && $jumlahPercobaanSiswa->jumlah_percobaan >= $kuis->jumlah_percobaan) {
            return redirect('/siswa/tugas/show/' . $tugasId)->with('error', 'Anda telah mencapai batas maksimum percobaan untuk kuis ini');
        }
        
        // Ambil pertanyaan kuis
        $pertanyaan = PertanyaanKuis::where('kuis_id', $kuis->id);
        
        // Jika kuis mengacak pertanyaan
        if ($kuis->acak_pertanyaan) {
            $pertanyaan = $pertanyaan->inRandomOrder();
        } else {
            $pertanyaan = $pertanyaan->orderBy('urutan', 'asc');
        }
        
        $pertanyaan = $pertanyaan->with(['jawaban' => function($query) use ($kuis) {
            // Jika kuis mengacak pertanyaan, acak juga jawaban
            if ($kuis->acak_pertanyaan) {
                $query->inRandomOrder();
            } else {
                $query->orderBy('urutan', 'asc');
            }
        }])->get();

        // Jika tidak ada pertanyaan
        if ($pertanyaan->isEmpty()) {
            return redirect('/siswa/tugas/show/' . $tugasId)->with('error', 'Kuis belum memiliki pertanyaan');
        }

        // Waktu mulai mengerjakan kuis
        $waktuMulai = Carbon::now()->toDateTimeString();
        session(['kuis_mulai_' . $tugasId => $waktuMulai]);
        
        return view('siswa.kuis.kerjakan', compact('tugas', 'kuis', 'pertanyaan', 'waktuMulai'));
    }
    
    public function postJawab(Request $request, $tugasId)
    {
        // Cek apakah tugas ada dan merupakan kuis
        $tugas = Tugas::join('keanggotaan_kelas', function($join) {
                $join->on('tugas.kelas_id', '=', 'keanggotaan_kelas.kelas_id')
                    ->where('keanggotaan_kelas.siswa_id', '=', Auth::id());
            })
            ->where('tugas.id', $tugasId)
            ->where('tugas.is_kuis', true)
            ->select('tugas.*')
            ->first();
            
        if (!$tugas || !$tugas->kuis_id) {
            return redirect('/siswa/tugas')->with('error', 'Tugas tidak ditemukan atau bukan kuis');
        }

        // Cek apakah waktu pengerjaan kuis sudah berakhir
        $now = Carbon::now();
        if ($tugas->waktu_selesai && $now > Carbon::parse($tugas->waktu_selesai)) {
            return redirect('/siswa/tugas/show/' . $tugasId)->with('error', 'Waktu pengerjaan kuis sudah berakhir');
        }

        // Ambil data kuis
        $kuis = Kuis::findOrFail($tugas->kuis_id);

        // Cek jumlah percobaan
        $jumlahPercobaanSiswa = JawabanSiswaKuis::where('tugas_id', $tugasId)
            ->where('siswa_id', Auth::id())
            ->select(DB::raw('COUNT(DISTINCT waktu_menjawab) as jumlah_percobaan'))
            ->first();

        if ($jumlahPercobaanSiswa && $jumlahPercobaanSiswa->jumlah_percobaan >= $kuis->jumlah_percobaan) {
            return redirect('/siswa/tugas/show/' . $tugasId)->with('error', 'Anda telah mencapai batas maksimum percobaan untuk kuis ini');
        }

        // Validasi input
        $request->validate([
            'waktu_mulai' => 'required|date',
            'jawaban' => 'required|array',
            'jawaban.*' => 'required',
        ]);

        // Cek durasi pengerjaan
        $waktuMulai = Carbon::parse($request->waktu_mulai);
        $waktuSelesai = Carbon::now();
        $durasiMenit = $waktuSelesai->diffInMinutes($waktuMulai);

        // Jika durasi melebihi batas waktu
        if ($tugas->durasi_menit && $durasiMenit > $tugas->durasi_menit) {
            return redirect('/siswa/tugas/show/' . $tugasId)->with('error', 'Waktu pengerjaan kuis telah habis');
        }
        
        // Ambil semua pertanyaan kuis
        $pertanyaan = PertanyaanKuis::where('kuis_id', $kuis->id)
            ->with('jawaban')
            ->get()
            ->keyBy('id');

        // Proses jawaban
        $totalNilai = 0;
        $totalBenar = 0;
        $totalSalah = 0;

        foreach ($request->jawaban as $pertanyaanId => $jawaban) {
            // Skip jika pertanyaan tidak valid
            if (!isset($pertanyaan[$pertanyaanId])) {
                continue;
            }

            $p = $pertanyaan[$pertanyaanId];
            $isBenar = false;
            $nilai = 0;
            $jawabanId = null;
            $jawabanTeks = null;

            // Proses berdasarkan tipe pertanyaan
            switch ($p->tipe) {
                case 'pilihan_ganda':
                case 'benar_salah':
                    // Jawaban berupa ID jawaban
                    $jawabanId = $jawaban;
                    $jawabanObj = $p->jawaban->firstWhere('id', $jawabanId);
                    
                    if ($jawabanObj) {
                        $isBenar = $jawabanObj->is_benar;
                        $nilai = $isBenar ? $p->bobot_nilai : 0;
                    }
                    break;

                case 'isian':
                    // Jawaban berupa teks
                    $jawabanTeks = $jawaban;
                    
                    // Cek jawaban benar (case insensitive)
                    foreach ($p->jawaban as $j) {
                        if (strtolower(trim($jawabanTeks)) == strtolower(trim($j->jawaban))) {
                            $isBenar = true;
                            $nilai = $p->bobot_nilai;
                            break;
                        }
                    }
                    break;

                case 'esai':
                    // Jawaban berupa teks, nilai ditentukan oleh guru
                    $jawabanTeks = $jawaban;
                    $nilai = 0; // Nilai awal 0, akan dinilai oleh guru
                    break;
            }

            // Simpan jawaban siswa
            $jawabanSiswa = new JawabanSiswaKuis();
            $jawabanSiswa->tugas_id = $tugasId;
            $jawabanSiswa->kuis_id = $kuis->id;
            $jawabanSiswa->pertanyaan_id = $pertanyaanId;
            $jawabanSiswa->siswa_id = Auth::id();
            $jawabanSiswa->jawaban_id = $jawabanId;
            $jawabanSiswa->jawaban_teks = $jawabanTeks;
            $jawabanSiswa->is_benar = $isBenar;
            $jawabanSiswa->nilai = $nilai;
            $jawabanSiswa->waktu_menjawab = $waktuSelesai;
            $jawabanSiswa->save();

            // Hitung total nilai
            $totalNilai += $nilai;
            if ($isBenar) {
                $totalBenar++;
            } else {
                $totalSalah++;
            }
        }
        
        // Redirect ke halaman hasil jika tampilkan hasil langsung
        if ($kuis->tampilkan_hasil_langsung) {
            return redirect('/siswa/kuis/hasil/' . $tugasId)->with('success', 'Kuis berhasil diselesaikan');
        }

        return redirect('/siswa/tugas/show/' . $tugasId)->with('success', 'Kuis berhasil diselesaikan');
    }
    
    public function getHasil($tugasId)
    {
        // Cek apakah tugas ada dan merupakan kuis
        $tugas = Tugas::join('keanggotaan_kelas', function($join) {
                $join->on('tugas.kelas_id', '=', 'keanggotaan_kelas.kelas_id')
                    ->where('keanggotaan_kelas.siswa_id', '=', Auth::id());
            })
            ->where('tugas.id', $tugasId)
            ->where('tugas.is_kuis', true)
            ->select('tugas.*')
            ->first();
            
        if (!$tugas || !$tugas->kuis_id) {
            return redirect('/siswa/tugas')->with('error', 'Tugas tidak ditemukan atau bukan kuis');
        }

        // Ambil data kuis
        $kuis = Kuis::findOrFail($tugas->kuis_id);

        // Cek apakah siswa sudah mengerjakan kuis
        $jawabanSiswa = JawabanSiswaKuis::where('tugas_id', $tugasId)
            ->where('siswa_id', Auth::id())
            ->first();

        if (!$jawabanSiswa) {
            return redirect('/siswa/tugas/show/' . $tugasId)->with('error', 'Anda belum mengerjakan kuis ini');
        }

        // Cek apakah hasil boleh ditampilkan
        if (!$kuis->tampilkan_hasil_langsung && !$tugas->tampilkan_nilai) {
            return redirect('/siswa/tugas/show/' . $tugasId)->with('error', 'Hasil kuis belum dapat ditampilkan');
        }

        // Ambil waktu pengerjaan terakhir
        $waktuPengerjaan = JawabanSiswaKuis::where('tugas_id', $tugasId)
            ->where('siswa_id', Auth::id())
            ->max('waktu_menjawab');

        // Ambil semua jawaban siswa untuk pengerjaan terakhir
        $jawabanSiswa = JawabanSiswaKuis::where('tugas_id', $tugasId)
            ->where('siswa_id', Auth::id())
            ->where('waktu_menjawab', $waktuPengerjaan)
            ->with(['pertanyaan' => function($query) {
                $query->orderBy('urutan', 'asc');
            }, 'pertanyaan.jawaban' => function($query) {
                $query->orderBy('urutan', 'asc');
            }, 'jawaban'])
            ->get();

        // Hitung total nilai dan statistik
        $totalNilai = $jawabanSiswa->sum('nilai');
        $totalBenar = $jawabanSiswa->where('is_benar', true)->count();
        $totalSalah = $jawabanSiswa->where('is_benar', false)->count();
        $totalPertanyaan = $jawabanSiswa->count();

        // Hitung nilai maksimum yang mungkin
        $nilaiMaksimum = PertanyaanKuis::where('kuis_id', $kuis->id)
            ->sum('bobot_nilai');

        // Hitung persentase nilai
        $persentaseNilai = $nilaiMaksimum > 0 ? ($totalNilai / $nilaiMaksimum) * 100 : 0;

        return view('siswa.kuis.hasil', compact(
            'tugas', 
            'kuis', 
            'jawabanSiswa', 
            'totalNilai', 
            'totalBenar', 
            'totalSalah', 
            'totalPertanyaan', 
            'nilaiMaksimum', 
            'persentaseNilai', 
            'waktuPengerjaan'
        ));
    }
}