<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kuis;
use App\Models\PertanyaanKuis;
use App\Models\JawabanKuis;
use App\Models\JawabanSiswaKuis;
use App\Models\HasilKuis;
use App\Models\Tugas;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KuisController extends Controller
{
    public $roles = [
        'Admin',
        'Guru',
    ];

    public function getIndex(Request $request)
    {
        $query = Kuis::with('pembuat')
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
        if ($request->filled('pembuat_id')) {
            $query->where('pembuat_id', $request->pembuat_id);
        }

        $kuis = $query->orderBy('created_at', 'desc')
                      ->paginate(20);

        // Data untuk filter
        $pembuat = User::role($this->roles)
            ->select('id', 'nama')
            ->orderBy('nama')
            ->get();

        return view('admin.kuis.index', compact('kuis', 'pembuat'));
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
            'tipe' => 'required|in:latihan,ujian,kuis',
            'jumlah_soal' => 'nullable|integer|min:1',
            'nilai_maksimum' => 'nullable|numeric|min:0',
            'acak_soal' => 'nullable|boolean',
            'tampilkan_hasil' => 'nullable|boolean',
            'tugas_id' => 'nullable|exists:tugas,id',
        ]);

        // Simpan kuis baru
        $kuis = new Kuis();
        $kuis->pembuat_id = Auth::id();
        $kuis->judul = $request->judul;
        $kuis->deskripsi = $request->deskripsi;
        $kuis->tipe = $request->tipe;
        $kuis->jumlah_soal = $request->jumlah_soal;
        $kuis->nilai_maksimum = $request->nilai_maksimum;
        $kuis->acak_soal = $request->has('acak_soal') ? true : false;
        $kuis->tampilkan_hasil = $request->has('tampilkan_hasil') ? true : false;
        $kuis->save();

        // Jika ada tugas_id, update tugas dengan kuis_id
        if ($request->filled('tugas_id')) {
            $tugas = Tugas::findOrFail($request->tugas_id);
            $tugas->kuis_id = $kuis->id;
            $tugas->is_kuis = true;
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
        }, 'pembuat'])->findOrFail($id);

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
            'tipe' => 'required|in:latihan,ujian,kuis',
            'jumlah_soal' => 'nullable|integer|min:1',
            'nilai_maksimum' => 'nullable|numeric|min:0',
            'acak_soal' => 'nullable|boolean',
            'tampilkan_hasil' => 'nullable|boolean',
        ]);

        // Update kuis
        $kuis = Kuis::findOrFail($id);
        $kuis->judul = $request->judul;
        $kuis->deskripsi = $request->deskripsi;
        $kuis->tipe = $request->tipe;
        $kuis->jumlah_soal = $request->jumlah_soal;
        $kuis->nilai_maksimum = $request->nilai_maksimum;
        $kuis->acak_soal = $request->has('acak_soal') ? true : false;
        $kuis->tampilkan_hasil = $request->has('tampilkan_hasil') ? true : false;
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
        
        // Hapus hasil kuis terkait
        HasilKuis::where('kuis_id', $id)->delete();

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
            'gambar' => 'nullable|image|max:2048',
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
        
        // Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $namaGambar = time() . '_' . $gambar->getClientOriginalName();
            $gambar->move(public_path('img/kuis'), $namaGambar);
            $pertanyaan->gambar = 'img/kuis/' . $namaGambar;
        }
        
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
            'gambar' => 'nullable|image|max:2048',
        ]);

        // Update pertanyaan
        $pertanyaan = PertanyaanKuis::findOrFail($pertanyaanId);
        $oldTipe = $pertanyaan->tipe;
        $pertanyaan->pertanyaan = $request->pertanyaan;
        $pertanyaan->tipe = $request->tipe;
        $pertanyaan->bobot_nilai = $request->bobot_nilai;
        
        // Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($pertanyaan->gambar && file_exists(public_path($pertanyaan->gambar))) {
                unlink(public_path($pertanyaan->gambar));
            }
            
            $gambar = $request->file('gambar');
            $namaGambar = time() . '_' . $gambar->getClientOriginalName();
            $gambar->move(public_path('img/kuis'), $namaGambar);
            $pertanyaan->gambar = 'img/kuis/' . $namaGambar;
        }
        
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

        // Hapus gambar jika ada
        if ($pertanyaan->gambar && file_exists(public_path($pertanyaan->gambar))) {
            unlink(public_path($pertanyaan->gambar));
        }

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

        // Hitung urutan terakhir
        $lastUrutan = JawabanKuis::where('pertanyaan_id', $pertanyaanId)->max('urutan') ?? 0;

        // Simpan jawaban baru
        $jawaban = new JawabanKuis();
        $jawaban->pertanyaan_id = $pertanyaanId;
        $jawaban->jawaban = $request->jawaban;
        $jawaban->is_benar = $request->has('is_benar') ? true : false;
        $jawaban->urutan = $lastUrutan + 1;
        $jawaban->save();

        // Jika tipe pertanyaan adalah pilihan ganda dan jawaban ini benar,
        // pastikan hanya ada satu jawaban yang benar
        if ($pertanyaan->tipe == 'pilihan_ganda' && $request->has('is_benar')) {
            JawabanKuis::where('pertanyaan_id', $pertanyaanId)
                ->where('id', '!=', $jawaban->id)
                ->update(['is_benar' => false]);
        }

        return redirect('/admin/kuis/jawaban/' . $pertanyaanId)->with('success', 'Jawaban berhasil ditambahkan');
    }

    public function getEditJawaban($jawabanId)
    {
        $jawaban = JawabanKuis::with('pertanyaan.kuis')->findOrFail($jawabanId);

        return view('admin.kuis.edit_jawaban', compact('jawaban'));
    }

    public function postUpdateJawaban(Request $request, $jawabanId)
    {
        // Validasi input
        $request->validate([
            'jawaban' => 'required|string',
            'is_benar' => 'nullable|boolean',
        ]);

        // Update jawaban
        $jawaban = JawabanKuis::with('pertanyaan')->findOrFail($jawabanId);
        $jawaban->jawaban = $request->jawaban;
        $jawaban->is_benar = $request->has('is_benar') ? true : false;
        $jawaban->save();

        // Jika tipe pertanyaan adalah pilihan ganda dan jawaban ini benar,
        // pastikan hanya ada satu jawaban yang benar
        if ($jawaban->pertanyaan->tipe == 'pilihan_ganda' && $request->has('is_benar')) {
            JawabanKuis::where('pertanyaan_id', $jawaban->pertanyaan_id)
                ->where('id', '!=', $jawabanId)
                ->update(['is_benar' => false]);
        }

        return redirect('/admin/kuis/jawaban/' . $jawaban->pertanyaan_id)->with('success', 'Jawaban berhasil diperbarui');
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
        $kuis = Kuis::with('pembuat')->findOrFail($kuisId);
        $hasilKuis = HasilKuis::with(['siswa', 'tugas'])
            ->where('kuis_id', $kuisId)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.kuis.hasil', compact('kuis', 'hasilKuis'));
    }

    public function getDetailHasilKuis($hasilId)
    {
        $hasil = HasilKuis::with(['siswa', 'kuis', 'tugas'])->findOrFail($hasilId);
        $jawabanSiswa = JawabanSiswaKuis::with(['pertanyaan', 'jawaban'])
            ->where('siswa_id', $hasil->siswa_id)
            ->where('kuis_id', $hasil->kuis_id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.kuis.detail_hasil', compact('hasil', 'jawabanSiswa'));
    }
}