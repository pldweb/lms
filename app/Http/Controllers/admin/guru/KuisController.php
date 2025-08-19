<?php

namespace App\Http\Controllers\guru;

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

class KuisController extends Controller
{
    public function getIndex(Request $request)
    {
        // Ambil kuis yang dibuat oleh guru yang sedang login
        $query = Kuis::where('created_by', Auth::id())
            ->select('kuis.*');

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'LIKE', "%{$search}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$search}%");
            });
        }

        $kuis = $query->orderBy('created_at', 'desc')
                      ->paginate(20);

        return view('guru.kuis.index', compact('kuis'));
    }

    public function getCreate($tugasId = null)
    {
        $tugas = null;
        if ($tugasId) {
            // Cek apakah tugas milik guru yang sedang login
            $tugas = Tugas::join('kelas', 'tugas.kelas_id', '=', 'kelas.id')
                ->join('pengajar', function($join) {
                    $join->on('kelas.id', '=', 'pengajar.kelas_id')
                        ->where('pengajar.guru_id', '=', Auth::id());
                })
                ->where('tugas.id', $tugasId)
                ->select('tugas.*')
                ->first();
                
            if (!$tugas) {
                return redirect('/guru/tugas')->with('error', 'Tugas tidak ditemukan atau bukan milik Anda');
            }
        }

        return view('guru.kuis.create', compact('tugas'));
    }

    public function postStore(Request $request)
    {
        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'waktu_pengerjaan_menit' => 'nullable|integer|min:1',
            'acak_pertanyaan' => 'nullable|boolean',
            'tampilkan_hasil_langsung' => 'nullable|boolean',
            'tampilkan_jawaban_benar' => 'nullable|boolean',
            'jumlah_percobaan' => 'nullable|integer|min:1',
            'tugas_id' => 'nullable|exists:tugas,id',
        ]);

        // Jika ada tugas_id, cek apakah tugas milik guru yang sedang login
        if ($request->filled('tugas_id')) {
            $tugas = Tugas::join('kelas', 'tugas.kelas_id', '=', 'kelas.id')
                ->join('pengajar', function($join) {
                    $join->on('kelas.id', '=', 'pengajar.kelas_id')
                        ->where('pengajar.guru_id', '=', Auth::id());
                })
                ->where('tugas.id', $request->tugas_id)
                ->select('tugas.*')
                ->first();
                
            if (!$tugas) {
                return redirect('/guru/tugas')->with('error', 'Tugas tidak ditemukan atau bukan milik Anda');
            }
        }

        // Simpan kuis baru
        $kuis = new Kuis();
        $kuis->judul = $request->judul;
        $kuis->deskripsi = $request->deskripsi;
        $kuis->waktu_pengerjaan_menit = $request->waktu_pengerjaan_menit;
        $kuis->acak_pertanyaan = $request->has('acak_pertanyaan') ? $request->acak_pertanyaan : false;
        $kuis->tampilkan_hasil_langsung = $request->has('tampilkan_hasil_langsung') ? $request->tampilkan_hasil_langsung : false;
        $kuis->tampilkan_jawaban_benar = $request->has('tampilkan_jawaban_benar') ? $request->tampilkan_jawaban_benar : false;
        $kuis->jumlah_percobaan = $request->jumlah_percobaan ?? 1;
        $kuis->created_by = Auth::id();
        $kuis->save();

        // Jika ada tugas_id, update tugas dengan kuis_id
        if ($request->filled('tugas_id')) {
            $tugas = Tugas::findOrFail($request->tugas_id);
            $tugas->kuis_id = $kuis->id;
            $tugas->save();

            return redirect('/guru/kuis/pertanyaan/' . $kuis->id)->with('success', 'Kuis berhasil dibuat. Silakan tambahkan pertanyaan.');
        }

        return redirect('/guru/kuis/pertanyaan/' . $kuis->id)->with('success', 'Kuis berhasil dibuat. Silakan tambahkan pertanyaan.');
    }

    public function getShow($id)
    {
        // Cek apakah kuis milik guru yang sedang login
        $kuis = Kuis::where('id', $id)
            ->where('created_by', Auth::id())
            ->with(['pertanyaan' => function($query) {
                $query->orderBy('urutan', 'asc');
            }, 'pertanyaan.jawaban' => function($query) {
                $query->orderBy('urutan', 'asc');
            }])
            ->first();
            
        if (!$kuis) {
            return redirect('/guru/kuis')->with('error', 'Kuis tidak ditemukan atau bukan milik Anda');
        }

        // Cek apakah kuis ini terhubung dengan tugas
        $tugas = Tugas::where('kuis_id', $id)->first();

        return view('guru.kuis.show', compact('kuis', 'tugas'));
    }

    public function getEdit($id)
    {
        // Cek apakah kuis milik guru yang sedang login
        $kuis = Kuis::where('id', $id)
            ->where('created_by', Auth::id())
            ->first();
            
        if (!$kuis) {
            return redirect('/guru/kuis')->with('error', 'Kuis tidak ditemukan atau bukan milik Anda');
        }

        // Cek apakah kuis ini terhubung dengan tugas
        $tugas = Tugas::where('kuis_id', $id)->first();

        return view('guru.kuis.edit', compact('kuis', 'tugas'));
    }

    public function postUpdate(Request $request, $id)
    {
        // Cek apakah kuis milik guru yang sedang login
        $kuis = Kuis::where('id', $id)
            ->where('created_by', Auth::id())
            ->first();
            
        if (!$kuis) {
            return redirect('/guru/kuis')->with('error', 'Kuis tidak ditemukan atau bukan milik Anda');
        }

        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'waktu_pengerjaan_menit' => 'nullable|integer|min:1',
            'acak_pertanyaan' => 'nullable|boolean',
            'tampilkan_hasil_langsung' => 'nullable|boolean',
            'tampilkan_jawaban_benar' => 'nullable|boolean',
            'jumlah_percobaan' => 'nullable|integer|min:1',
        ]);

        // Update kuis
        $kuis->judul = $request->judul;
        $kuis->deskripsi = $request->deskripsi;
        $kuis->waktu_pengerjaan_menit = $request->waktu_pengerjaan_menit;
        $kuis->acak_pertanyaan = $request->has('acak_pertanyaan') ? $request->acak_pertanyaan : false;
        $kuis->tampilkan_hasil_langsung = $request->has('tampilkan_hasil_langsung') ? $request->tampilkan_hasil_langsung : false;
        $kuis->tampilkan_jawaban_benar = $request->has('tampilkan_jawaban_benar') ? $request->tampilkan_jawaban_benar : false;
        $kuis->jumlah_percobaan = $request->jumlah_percobaan ?? 1;
        $kuis->save();

        return redirect('/guru/kuis')->with('success', 'Kuis berhasil diperbarui');
    }

    public function getDelete($id)
    {
        // Cek apakah kuis milik guru yang sedang login
        $kuis = Kuis::where('id', $id)
            ->where('created_by', Auth::id())
            ->first();
            
        if (!$kuis) {
            return redirect('/guru/kuis')->with('error', 'Kuis tidak ditemukan atau bukan milik Anda');
        }

        // Cek apakah kuis ini terhubung dengan tugas
        $tugas = Tugas::where('kuis_id', $id)->first();
        if ($tugas) {
            return redirect('/guru/kuis')->with('error', 'Kuis tidak dapat dihapus karena masih terhubung dengan tugas');
        }

        // Hapus semua pertanyaan dan jawaban terkait
        $pertanyaan = PertanyaanKuis::where('kuis_id', $id)->get();
        foreach ($pertanyaan as $p) {
            JawabanKuis::where('pertanyaan_id', $p->id)->delete();
            $p->delete();
        }

        // Hapus jawaban siswa terkait
        JawabanSiswaKuis::where('kuis_id', $id)->delete();

        // Hapus kuis
        $kuis->delete();

        return redirect('/guru/kuis')->with('success', 'Kuis berhasil dihapus');
    }

    public function getPertanyaan($kuisId)
    {
        // Cek apakah kuis milik guru yang sedang login
        $kuis = Kuis::where('id', $kuisId)
            ->where('created_by', Auth::id())
            ->with(['pertanyaan' => function($query) {
                $query->orderBy('urutan', 'asc');
            }, 'pertanyaan.jawaban' => function($query) {
                $query->orderBy('urutan', 'asc');
            }])
            ->first();
            
        if (!$kuis) {
            return redirect('/guru/kuis')->with('error', 'Kuis tidak ditemukan atau bukan milik Anda');
        }

        return view('guru.kuis.pertanyaan', compact('kuis'));
    }

    public function postTambahPertanyaan(Request $request, $kuisId)
    {
        // Cek apakah kuis milik guru yang sedang login
        $kuis = Kuis::where('id', $kuisId)
            ->where('created_by', Auth::id())
            ->first();
            
        if (!$kuis) {
            return redirect('/guru/kuis')->with('error', 'Kuis tidak ditemukan atau bukan milik Anda');
        }

        // Validasi input
        $request->validate([
            'pertanyaan' => 'required|string',
            'tipe' => 'required|in:pilihan_ganda,benar_salah,isian,esai',
            'bobot_nilai' => 'required|numeric|min:0',
        ]);

        // Hitung urutan terakhir
        $lastUrutan = PertanyaanKuis::where('kuis_id', $kuisId)->max('urutan') ?? 0;

        // Simpan pertanyaan baru
        $pertanyaan = new PertanyaanKuis();
        $pertanyaan->kuis_id = $kuisId;
        $pertanyaan->pertanyaan = $request->pertanyaan;
        $pertanyaan->tipe = $request->tipe;
        $pertanyaan->bobot_nilai = $request->bobot_nilai;
        $pertanyaan->urutan = $lastUrutan + 1;
        $pertanyaan->save();

        // Jika tipe pertanyaan adalah benar/salah, buat jawaban otomatis
        if ($request->tipe == 'benar_salah') {
            // Jawaban Benar
            $jawabanBenar = new JawabanKuis();
            $jawabanBenar->pertanyaan_id = $pertanyaan->id;
            $jawabanBenar->jawaban = 'Benar';
            $jawabanBenar->is_benar = true;
            $jawabanBenar->urutan = 1;
            $jawabanBenar->save();

            // Jawaban Salah
            $jawabanSalah = new JawabanKuis();
            $jawabanSalah->pertanyaan_id = $pertanyaan->id;
            $jawabanSalah->jawaban = 'Salah';
            $jawabanSalah->is_benar = false;
            $jawabanSalah->urutan = 2;
            $jawabanSalah->save();
        }

        return redirect('/guru/kuis/jawaban/' . $pertanyaan->id)->with('success', 'Pertanyaan berhasil ditambahkan. Silakan tambahkan jawaban.');
    }

    public function getEditPertanyaan($pertanyaanId)
    {
        // Cek apakah pertanyaan milik kuis yang dibuat oleh guru yang sedang login
        $pertanyaan = PertanyaanKuis::join('kuis', 'pertanyaan_kuis.kuis_id', '=', 'kuis.id')
            ->where('pertanyaan_kuis.id', $pertanyaanId)
            ->where('kuis.created_by', Auth::id())
            ->select('pertanyaan_kuis.*')
            ->first();
            
        if (!$pertanyaan) {
            return redirect('/guru/kuis')->with('error', 'Pertanyaan tidak ditemukan atau bukan milik Anda');
        }

        return view('guru.kuis.edit_pertanyaan', compact('pertanyaan'));
    }

    public function postUpdatePertanyaan(Request $request, $pertanyaanId)
    {
        // Cek apakah pertanyaan milik kuis yang dibuat oleh guru yang sedang login
        $pertanyaan = PertanyaanKuis::join('kuis', 'pertanyaan_kuis.kuis_id', '=', 'kuis.id')
            ->where('pertanyaan_kuis.id', $pertanyaanId)
            ->where('kuis.created_by', Auth::id())
            ->select('pertanyaan_kuis.*')
            ->first();
            
        if (!$pertanyaan) {
            return redirect('/guru/kuis')->with('error', 'Pertanyaan tidak ditemukan atau bukan milik Anda');
        }

        // Validasi input
        $request->validate([
            'pertanyaan' => 'required|string',
            'tipe' => 'required|in:pilihan_ganda,benar_salah,isian,esai',
            'bobot_nilai' => 'required|numeric|min:0',
        ]);

        // Update pertanyaan
        $oldTipe = $pertanyaan->tipe;
        $pertanyaan->pertanyaan = $request->pertanyaan;
        $pertanyaan->tipe = $request->tipe;
        $pertanyaan->bobot_nilai = $request->bobot_nilai;
        $pertanyaan->save();

        // Jika tipe pertanyaan berubah menjadi benar/salah, buat jawaban otomatis
        if ($oldTipe != 'benar_salah' && $request->tipe == 'benar_salah') {
            // Hapus jawaban lama
            JawabanKuis::where('pertanyaan_id', $pertanyaanId)->delete();

            // Jawaban Benar
            $jawabanBenar = new JawabanKuis();
            $jawabanBenar->pertanyaan_id = $pertanyaan->id;
            $jawabanBenar->jawaban = 'Benar';
            $jawabanBenar->is_benar = true;
            $jawabanBenar->urutan = 1;
            $jawabanBenar->save();

            // Jawaban Salah
            $jawabanSalah = new JawabanKuis();
            $jawabanSalah->pertanyaan_id = $pertanyaan->id;
            $jawabanSalah->jawaban = 'Salah';
            $jawabanSalah->is_benar = false;
            $jawabanSalah->urutan = 2;
            $jawabanSalah->save();
        }

        return redirect('/guru/kuis/pertanyaan/' . $pertanyaan->kuis_id)->with('success', 'Pertanyaan berhasil diperbarui');
    }

    public function getDeletePertanyaan($pertanyaanId)
    {
        // Cek apakah pertanyaan milik kuis yang dibuat oleh guru yang sedang login
        $pertanyaan = PertanyaanKuis::join('kuis', 'pertanyaan_kuis.kuis_id', '=', 'kuis.id')
            ->where('pertanyaan_kuis.id', $pertanyaanId)
            ->where('kuis.created_by', Auth::id())
            ->select('pertanyaan_kuis.*')
            ->first();
            
        if (!$pertanyaan) {
            return redirect('/guru/kuis')->with('error', 'Pertanyaan tidak ditemukan atau bukan milik Anda');
        }

        $kuisId = $pertanyaan->kuis_id;

        // Hapus jawaban terkait
        JawabanKuis::where('pertanyaan_id', $pertanyaanId)->delete();

        // Hapus jawaban siswa terkait
        JawabanSiswaKuis::where('pertanyaan_id', $pertanyaanId)->delete();

        // Hapus pertanyaan
        $pertanyaan->delete();

        // Reorder urutan pertanyaan
        $pertanyaanLain = PertanyaanKuis::where('kuis_id', $kuisId)
            ->orderBy('urutan', 'asc')
            ->get();

        $urutan = 1;
        foreach ($pertanyaanLain as $p) {
            $p->urutan = $urutan++;
            $p->save();
        }

        return redirect('/guru/kuis/pertanyaan/' . $kuisId)->with('success', 'Pertanyaan berhasil dihapus');
    }

    public function getJawaban($pertanyaanId)
    {
        // Cek apakah pertanyaan milik kuis yang dibuat oleh guru yang sedang login
        $pertanyaan = PertanyaanKuis::join('kuis', 'pertanyaan_kuis.kuis_id', '=', 'kuis.id')
            ->where('pertanyaan_kuis.id', $pertanyaanId)
            ->where('kuis.created_by', Auth::id())
            ->with(['kuis', 'jawaban' => function($query) {
                $query->orderBy('urutan', 'asc');
            }])
            ->select('pertanyaan_kuis.*')
            ->first();
            
        if (!$pertanyaan) {
            return redirect('/guru/kuis')->with('error', 'Pertanyaan tidak ditemukan atau bukan milik Anda');
        }

        return view('guru.kuis.jawaban', compact('pertanyaan'));
    }

    public function postTambahJawaban(Request $request, $pertanyaanId)
    {
        // Cek apakah pertanyaan milik kuis yang dibuat oleh guru yang sedang login
        $pertanyaan = PertanyaanKuis::join('kuis', 'pertanyaan_kuis.kuis_id', '=', 'kuis.id')
            ->where('pertanyaan_kuis.id', $pertanyaanId)
            ->where('kuis.created_by', Auth::id())
            ->select('pertanyaan_kuis.*')
            ->first();
            
        if (!$pertanyaan) {
            return redirect('/guru/kuis')->with('error', 'Pertanyaan tidak ditemukan atau bukan milik Anda');
        }

        // Validasi input
        $request->validate([
            'jawaban' => 'required|string',
            'is_benar' => 'nullable|boolean',
        ]);

        // Jika tipe pertanyaan adalah pilihan ganda atau benar/salah, validasi jawaban benar
        if (in_array($pertanyaan->tipe, ['pilihan_ganda', 'benar_salah'])) {
            // Jika jawaban ini ditandai sebagai benar, set semua jawaban lain menjadi salah
            if ($request->has('is_benar') && $request->is_benar) {
                JawabanKuis::where('pertanyaan_id', $pertanyaanId)
                    ->update(['is_benar' => false]);
            }
        }

        // Hitung urutan terakhir
        $lastUrutan = JawabanKuis::where('pertanyaan_id', $pertanyaanId)->max('urutan') ?? 0;

        // Simpan jawaban baru
        $jawaban = new JawabanKuis();
        $jawaban->pertanyaan_id = $pertanyaanId;
        $jawaban->jawaban = $request->jawaban;
        $jawaban->is_benar = $request->has('is_benar') ? $request->is_benar : false;
        $jawaban->urutan = $lastUrutan + 1;
        $jawaban->save();

        return redirect('/guru/kuis/jawaban/' . $pertanyaanId)->with('success', 'Jawaban berhasil ditambahkan');
    }

    public function getEditJawaban($jawabanId)
    {
        // Cek apakah jawaban milik pertanyaan dari kuis yang dibuat oleh guru yang sedang login
        $jawaban = JawabanKuis::join('pertanyaan_kuis', 'jawaban_kuis.pertanyaan_id', '=', 'pertanyaan_kuis.id')
            ->join('kuis', 'pertanyaan_kuis.kuis_id', '=', 'kuis.id')
            ->where('jawaban_kuis.id', $jawabanId)
            ->where('kuis.created_by', Auth::id())
            ->select('jawaban_kuis.*')
            ->first();
            
        if (!$jawaban) {
            return redirect('/guru/kuis')->with('error', 'Jawaban tidak ditemukan atau bukan milik Anda');
        }

        // Ambil data pertanyaan
        $pertanyaan = PertanyaanKuis::with('kuis')->findOrFail($jawaban->pertanyaan_id);

        return view('guru.kuis.edit_jawaban', compact('jawaban', 'pertanyaan'));
    }

    public function postUpdateJawaban(Request $request, $jawabanId)
    {
        // Cek apakah jawaban milik pertanyaan dari kuis yang dibuat oleh guru yang sedang login
        $jawaban = JawabanKuis::join('pertanyaan_kuis', 'jawaban_kuis.pertanyaan_id', '=', 'pertanyaan_kuis.id')
            ->join('kuis', 'pertanyaan_kuis.kuis_id', '=', 'kuis.id')
            ->where('jawaban_kuis.id', $jawabanId)
            ->where('kuis.created_by', Auth::id())
            ->select('jawaban_kuis.*')
            ->first();
            
        if (!$jawaban) {
            return redirect('/guru/kuis')->with('error', 'Jawaban tidak ditemukan atau bukan milik Anda');
        }

        // Validasi input
        $request->validate([
            'jawaban' => 'required|string',
            'is_benar' => 'nullable|boolean',
        ]);

        // Ambil data pertanyaan
        $pertanyaan = PertanyaanKuis::findOrFail($jawaban->pertanyaan_id);
        $pertanyaanId = $pertanyaan->id;

        // Jika tipe pertanyaan adalah pilihan ganda atau benar/salah, validasi jawaban benar
        if (in_array($pertanyaan->tipe, ['pilihan_ganda', 'benar_salah'])) {
            // Jika jawaban ini ditandai sebagai benar, set semua jawaban lain menjadi salah
            if ($request->has('is_benar') && $request->is_benar) {
                JawabanKuis::where('pertanyaan_id', $pertanyaanId)
                    ->where('id', '!=', $jawabanId)
                    ->update(['is_benar' => false]);
            }
        }

        // Update jawaban
        $jawaban->jawaban = $request->jawaban;
        $jawaban->is_benar = $request->has('is_benar') ? $request->is_benar : false;
        $jawaban->save();

        return redirect('/guru/kuis/jawaban/' . $pertanyaanId)->with('success', 'Jawaban berhasil diperbarui');
    }

    public function getDeleteJawaban($jawabanId)
    {
        // Cek apakah jawaban milik pertanyaan dari kuis yang dibuat oleh guru yang sedang login
        $jawaban = JawabanKuis::join('pertanyaan_kuis', 'jawaban_kuis.pertanyaan_id', '=', 'pertanyaan_kuis.id')
            ->join('kuis', 'pertanyaan_kuis.kuis_id', '=', 'kuis.id')
            ->where('jawaban_kuis.id', $jawabanId)
            ->where('kuis.created_by', Auth::id())
            ->select('jawaban_kuis.*')
            ->first();
            
        if (!$jawaban) {
            return redirect('/guru/kuis')->with('error', 'Jawaban tidak ditemukan atau bukan milik Anda');
        }

        $pertanyaanId = $jawaban->pertanyaan_id;

        // Hapus jawaban siswa terkait
        JawabanSiswaKuis::where('jawaban_id', $jawabanId)->delete();

        // Hapus jawaban
        $jawaban->delete();

        // Reorder urutan jawaban
        $jawabanLain = JawabanKuis::where('pertanyaan_id', $pertanyaanId)
            ->orderBy('urutan', 'asc')
            ->get();

        $urutan = 1;
        foreach ($jawabanLain as $j) {
            $j->urutan = $urutan++;
            $j->save();
        }

        return redirect('/guru/kuis/jawaban/' . $pertanyaanId)->with('success', 'Jawaban berhasil dihapus');
    }

    public function getNilaiEsai($tugasId)
    {
        // Cek apakah tugas milik guru yang sedang login
        $tugas = Tugas::join('kelas', 'tugas.kelas_id', '=', 'kelas.id')
            ->join('pengajar', function($join) {
                $join->on('kelas.id', '=', 'pengajar.kelas_id')
                    ->where('pengajar.guru_id', '=', Auth::id());
            })
            ->where('tugas.id', $tugasId)
            ->where('tugas.is_kuis', true)
            ->select('tugas.*')
            ->first();
            
        if (!$tugas || !$tugas->kuis_id) {
            return redirect('/guru/tugas')->with('error', 'Tugas tidak ditemukan, bukan milik Anda, atau bukan kuis');
        }

        // Ambil data kuis
        $kuis = Kuis::findOrFail($tugas->kuis_id);

        // Ambil pertanyaan esai
        $pertanyaanEsai = PertanyaanKuis::where('kuis_id', $kuis->id)
            ->where('tipe', 'esai')
            ->orderBy('urutan', 'asc')
            ->get();

        // Jika tidak ada pertanyaan esai
        if ($pertanyaanEsai->isEmpty()) {
            return redirect('/guru/tugas/show/' . $tugasId)->with('error', 'Tidak ada pertanyaan esai pada kuis ini');
        }

        // Ambil jawaban siswa untuk pertanyaan esai
        $jawabanSiswa = JawabanSiswaKuis::join('users', 'jawaban_siswa_kuis.siswa_id', '=', 'users.id')
            ->whereIn('jawaban_siswa_kuis.pertanyaan_id', $pertanyaanEsai->pluck('id'))
            ->where('jawaban_siswa_kuis.tugas_id', $tugasId)
            ->select(
                'jawaban_siswa_kuis.*',
                'users.nama as siswa_nama'
            )
            ->orderBy('users.nama')
            ->get();

        // Kelompokkan jawaban berdasarkan siswa
        $jawabanPerSiswa = [];
        foreach ($jawabanSiswa as $jawaban) {
            if (!isset($jawabanPerSiswa[$jawaban->siswa_id])) {
                $jawabanPerSiswa[$jawaban->siswa_id] = [
                    'siswa_id' => $jawaban->siswa_id,
                    'siswa_nama' => $jawaban->siswa_nama,
                    'jawaban' => []
                ];
            }

            $jawabanPerSiswa[$jawaban->siswa_id]['jawaban'][$jawaban->pertanyaan_id] = $jawaban;
        }

        return view('guru.kuis.nilai_esai', compact('tugas', 'kuis', 'pertanyaanEsai', 'jawabanPerSiswa'));
    }

    public function postNilaiEsai(Request $request, $tugasId)
    {
        // Cek apakah tugas milik guru yang sedang login
        $tugas = Tugas::join('kelas', 'tugas.kelas_id', '=', 'kelas.id')
            ->join('pengajar', function($join) {
                $join->on('kelas.id', '=', 'pengajar.kelas_id')
                    ->where('pengajar.guru_id', '=', Auth::id());
            })
            ->where('tugas.id', $tugasId)
            ->where('tugas.is_kuis', true)
            ->select('tugas.*')
            ->first();
            
        if (!$tugas || !$tugas->kuis_id) {
            return redirect('/guru/tugas')->with('error', 'Tugas tidak ditemukan, bukan milik Anda, atau bukan kuis');
        }

        // Validasi input
        $request->validate([
            'nilai' => 'required|array',
            'nilai.*.*' => 'required|numeric|min:0',
        ]);

        // Update nilai jawaban siswa
        foreach ($request->nilai as $siswaId => $nilaiPertanyaan) {
            foreach ($nilaiPertanyaan as $pertanyaanId => $nilai) {
                // Ambil data pertanyaan untuk mendapatkan bobot nilai
                $pertanyaan = PertanyaanKuis::findOrFail($pertanyaanId);
                
                // Cek apakah nilai melebihi bobot
                $nilaiAkhir = min($nilai, $pertanyaan->bobot_nilai);
                
                // Update jawaban siswa
                $jawabanSiswa = JawabanSiswaKuis::where('tugas_id', $tugasId)
                    ->where('siswa_id', $siswaId)
                    ->where('pertanyaan_id', $pertanyaanId)
                    ->first();
                    
                if ($jawabanSiswa) {
                    $jawabanSiswa->nilai = $nilaiAkhir;
                    $jawabanSiswa->is_benar = $nilaiAkhir > 0;
                    $jawabanSiswa->save();
                }
            }
        }

        return redirect('/guru/tugas/show/' . $tugasId)->with('success', 'Nilai esai berhasil disimpan');
    }

    public function getHasilKuis($tugasId)
    {
        // Cek apakah tugas milik guru yang sedang login
        $tugas = Tugas::join('kelas', 'tugas.kelas_id', '=', 'kelas.id')
            ->join('pengajar', function($join) {
                $join->on('kelas.id', '=', 'pengajar.kelas_id')
                    ->where('pengajar.guru_id', '=', Auth::id());
            })
            ->where('tugas.id', $tugasId)
            ->where('tugas.is_kuis', true)
            ->select('tugas.*')
            ->first();
            
        if (!$tugas || !$tugas->kuis_id) {
            return redirect('/guru/tugas')->with('error', 'Tugas tidak ditemukan, bukan milik Anda, atau bukan kuis');
        }

        // Ambil data kuis
        $kuis = Kuis::with(['pertanyaan' => function($query) {
            $query->orderBy('urutan', 'asc');
        }, 'pertanyaan.jawaban' => function($query) {
            $query->orderBy('urutan', 'asc');
        }])->findOrFail($tugas->kuis_id);

        // Ambil data jawaban siswa
        $jawabanSiswa = DB::table('jawaban_siswa_kuis')
            ->join('users', 'jawaban_siswa_kuis.siswa_id', '=', 'users.id')
            ->join('pertanyaan_kuis', 'jawaban_siswa_kuis.pertanyaan_id', '=', 'pertanyaan_kuis.id')
            ->leftJoin('jawaban_kuis', 'jawaban_siswa_kuis.jawaban_id', '=', 'jawaban_kuis.id')
            ->select(
                'jawaban_siswa_kuis.*',
                'users.nama as siswa_nama',
                'pertanyaan_kuis.pertanyaan',
                'pertanyaan_kuis.tipe',
                'pertanyaan_kuis.bobot_nilai',
                'jawaban_kuis.jawaban as jawaban_teks_pilihan'
            )
            ->where('jawaban_siswa_kuis.tugas_id', $tugasId)
            ->orderBy('users.nama')
            ->orderBy('pertanyaan_kuis.urutan')
            ->get();

        // Kelompokkan jawaban berdasarkan siswa
        $hasilPerSiswa = [];
        foreach ($jawabanSiswa as $jawaban) {
            if (!isset($hasilPerSiswa[$jawaban->siswa_id])) {
                $hasilPerSiswa[$jawaban->siswa_id] = [
                    'siswa_id' => $jawaban->siswa_id,
                    'siswa_nama' => $jawaban->siswa_nama,
                    'total_nilai' => 0,
                    'total_benar' => 0,
                    'total_salah' => 0,
                    'total_pertanyaan' => 0,
                    'jawaban' => []
                ];
            }

            $hasilPerSiswa[$jawaban->siswa_id]['jawaban'][] = $jawaban;
            $hasilPerSiswa[$jawaban->siswa_id]['total_nilai'] += $jawaban->nilai;
            $hasilPerSiswa[$jawaban->siswa_id]['total_pertanyaan']++;

            if ($jawaban->is_benar) {
                $hasilPerSiswa[$jawaban->siswa_id]['total_benar']++;
            } else {
                $hasilPerSiswa[$jawaban->siswa_id]['total_salah']++;
            }
        }

        return view('guru.kuis.hasil', compact('tugas', 'kuis', 'hasilPerSiswa'));
    }
}