<?php

namespace App\Http\Controllers\admin;

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
        $query = Kuis::with('creator')
            ->select('kuis.*');

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'LIKE', "%{$search}%")
                  ->orWhere('deskripsi', 'LIKE', "%{$search}%");
            });
        }

        // Filter berdasarkan pembuat
        if ($request->filled('created_by')) {
            $query->where('created_by', $request->created_by);
        }

        $kuis = $query->orderBy('created_at', 'desc')
                      ->paginate(20);

        // Data untuk filter
        $guru = User::where('role', 'guru')
            ->orWhere('role', 'admin')
            ->select('id', 'nama')
            ->orderBy('nama')
            ->get();

        return view('admin.kuis.index', compact('kuis', 'guru'));
    }

    public function getCreate($tugasId = null)
    {
        $tugas = null;
        if ($tugasId) {
            $tugas = Tugas::findOrFail($tugasId);
        }

        return view('admin.kuis.create', compact('tugas'));
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

            return redirect('/admin/kuis/pertanyaan/' . $kuis->id)->with('success', 'Kuis berhasil dibuat. Silakan tambahkan pertanyaan.');
        }

        return redirect('/admin/kuis/pertanyaan/' . $kuis->id)->with('success', 'Kuis berhasil dibuat. Silakan tambahkan pertanyaan.');
    }

    public function getShow($id)
    {
        $kuis = Kuis::with(['pertanyaan' => function($query) {
            $query->orderBy('urutan', 'asc');
        }, 'pertanyaan.jawaban' => function($query) {
            $query->orderBy('urutan', 'asc');
        }, 'creator'])->findOrFail($id);

        // Cek apakah kuis ini terhubung dengan tugas
        $tugas = Tugas::where('kuis_id', $id)->first();

        return view('admin.kuis.show', compact('kuis', 'tugas'));
    }

    public function getEdit($id)
    {
        $kuis = Kuis::findOrFail($id);

        // Cek apakah kuis ini terhubung dengan tugas
        $tugas = Tugas::where('kuis_id', $id)->first();

        return view('admin.kuis.edit', compact('kuis', 'tugas'));
    }

    public function postUpdate(Request $request, $id)
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
        ]);

        // Update kuis
        $kuis = Kuis::findOrFail($id);
        $kuis->judul = $request->judul;
        $kuis->deskripsi = $request->deskripsi;
        $kuis->waktu_pengerjaan_menit = $request->waktu_pengerjaan_menit;
        $kuis->acak_pertanyaan = $request->has('acak_pertanyaan') ? $request->acak_pertanyaan : false;
        $kuis->tampilkan_hasil_langsung = $request->has('tampilkan_hasil_langsung') ? $request->tampilkan_hasil_langsung : false;
        $kuis->tampilkan_jawaban_benar = $request->has('tampilkan_jawaban_benar') ? $request->tampilkan_jawaban_benar : false;
        $kuis->jumlah_percobaan = $request->jumlah_percobaan ?? 1;
        $kuis->save();

        return redirect('/admin/kuis')->with('success', 'Kuis berhasil diperbarui');
    }

    public function getDelete($id)
    {
        // Cek apakah kuis ini terhubung dengan tugas
        $tugas = Tugas::where('kuis_id', $id)->first();
        if ($tugas) {
            return redirect('/admin/kuis')->with('error', 'Kuis tidak dapat dihapus karena masih terhubung dengan tugas');
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
        $kuis = Kuis::findOrFail($id);
        $kuis->delete();

        return redirect('/admin/kuis')->with('success', 'Kuis berhasil dihapus');
    }

    public function getPertanyaan($kuisId)
    {
        $kuis = Kuis::with(['pertanyaan' => function($query) {
            $query->orderBy('urutan', 'asc');
        }, 'pertanyaan.jawaban' => function($query) {
            $query->orderBy('urutan', 'asc');
        }])->findOrFail($kuisId);

        return view('admin.kuis.pertanyaan', compact('kuis'));
    }

    public function postTambahPertanyaan(Request $request, $kuisId)
    {
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

        return redirect('/admin/kuis/jawaban/' . $pertanyaan->id)->with('success', 'Pertanyaan berhasil ditambahkan. Silakan tambahkan jawaban.');
    }

    public function getEditPertanyaan($pertanyaanId)
    {
        $pertanyaan = PertanyaanKuis::with('kuis')->findOrFail($pertanyaanId);

        return view('admin.kuis.edit_pertanyaan', compact('pertanyaan'));
    }

    public function postUpdatePertanyaan(Request $request, $pertanyaanId)
    {
        // Validasi input
        $request->validate([
            'pertanyaan' => 'required|string',
            'tipe' => 'required|in:pilihan_ganda,benar_salah,isian,esai',
            'bobot_nilai' => 'required|numeric|min:0',
        ]);

        // Update pertanyaan
        $pertanyaan = PertanyaanKuis::findOrFail($pertanyaanId);
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

        return redirect('/admin/kuis/pertanyaan/' . $pertanyaan->kuis_id)->with('success', 'Pertanyaan berhasil diperbarui');
    }

    public function getDeletePertanyaan($pertanyaanId)
    {
        $pertanyaan = PertanyaanKuis::findOrFail($pertanyaanId);
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

        return redirect('/admin/kuis/pertanyaan/' . $kuisId)->with('success', 'Pertanyaan berhasil dihapus');
    }

    public function getJawaban($pertanyaanId)
    {
        $pertanyaan = PertanyaanKuis::with(['kuis', 'jawaban' => function($query) {
            $query->orderBy('urutan', 'asc');
        }])->findOrFail($pertanyaanId);

        return view('admin.kuis.jawaban', compact('pertanyaan'));
    }

    public function postTambahJawaban(Request $request, $pertanyaanId)
    {
        // Validasi input
        $request->validate([
            'jawaban' => 'required|string',
            'is_benar' => 'nullable|boolean',
        ]);

        $pertanyaan = PertanyaanKuis::findOrFail($pertanyaanId);

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

        return redirect('/admin/kuis/jawaban/' . $pertanyaanId)->with('success', 'Jawaban berhasil ditambahkan');
    }

    public function getEditJawaban($jawabanId)
    {
        $jawaban = JawabanKuis::with(['pertanyaan', 'pertanyaan.kuis'])->findOrFail($jawabanId);

        return view('admin.kuis.edit_jawaban', compact('jawaban'));
    }

    public function postUpdateJawaban(Request $request, $jawabanId)
    {
        // Validasi input
        $request->validate([
            'jawaban' => 'required|string',
            'is_benar' => 'nullable|boolean',
        ]);

        $jawaban = JawabanKuis::with('pertanyaan')->findOrFail($jawabanId);
        $pertanyaanId = $jawaban->pertanyaan_id;
        $pertanyaan = $jawaban->pertanyaan;

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

        return redirect('/admin/kuis/jawaban/' . $pertanyaanId)->with('success', 'Jawaban berhasil diperbarui');
    }

    public function getDeleteJawaban($jawabanId)
    {
        $jawaban = JawabanKuis::findOrFail($jawabanId);
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

        return redirect('/admin/kuis/jawaban/' . $pertanyaanId)->with('success', 'Jawaban berhasil dihapus');
    }

    public function getHasilKuis($kuisId)
    {
        $kuis = Kuis::with(['pertanyaan' => function($query) {
            $query->orderBy('urutan', 'asc');
        }, 'pertanyaan.jawaban' => function($query) {
            $query->orderBy('urutan', 'asc');
        }])->findOrFail($kuisId);

        // Ambil tugas yang terhubung dengan kuis ini
        $tugas = Tugas::where('kuis_id', $kuisId)->first();

        // Jika tidak ada tugas, redirect ke halaman kuis
        if (!$tugas) {
            return redirect('/admin/kuis/show/' . $kuisId)->with('error', 'Kuis ini tidak terhubung dengan tugas');
        }

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
            ->where('jawaban_siswa_kuis.kuis_id', $kuisId)
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

        return view('admin.kuis.hasil', compact('kuis', 'tugas', 'hasilPerSiswa'));
    }
}