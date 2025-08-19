<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tugas;
use App\Models\Kelas;
use App\Models\PengumpulanTugas;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TugasController extends Controller
{
    public function getIndex(Request $request)
    {
        $query = DB::table('tugas')
            ->join('kelas', 'tugas.kelas_id', '=', 'kelas.id')
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->select(
                'tugas.*',
                'kelas.nama as kelas_nama',
                'kelas.jenjang',
                'kelas.tingkat',
                'tahun_ajaran.nama as tahun_ajaran_nama'
            );

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('tugas.judul', 'LIKE', "%{$search}%")
                  ->orWhere('kelas.nama', 'LIKE', "%{$search}%");
            });
        }

        // Filter berdasarkan kelas
        if ($request->filled('kelas_id')) {
            $query->where('tugas.kelas_id', $request->kelas_id);
        }

        // Filter berdasarkan tahun ajaran
        if ($request->filled('tahun_ajaran_id')) {
            $query->where('kelas.tahun_ajaran_id', $request->tahun_ajaran_id);
        }

        $tugas = $query->orderBy('tugas.tenggat_waktu', 'desc')
                       ->paginate(20);

        // Data untuk filter
        $kelas = DB::table('kelas')
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->select('kelas.id', 'kelas.nama', 'kelas.jenjang', 'kelas.tingkat', 'tahun_ajaran.nama as tahun_ajaran')
            ->orderBy('kelas.jenjang')
            ->orderBy('kelas.tingkat')
            ->get();

        $tahunAjaran = DB::table('tahun_ajaran')
            ->select('id', 'nama')
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        return view('admin.tugas.index', compact('tugas', 'kelas', 'tahunAjaran'));
    }

    public function getCreate()
    {
        // Data untuk dropdown
        $kelas = DB::table('kelas')
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->select('kelas.id', 'kelas.nama', 'kelas.jenjang', 'kelas.tingkat', 'tahun_ajaran.nama as tahun_ajaran')
            ->orderBy('kelas.jenjang')
            ->orderBy('kelas.tingkat')
            ->get();
            
        // Data untuk dropdown tipe media
        $mediaTypes = [
            'video' => 'Video',
            'slide' => 'Slide/Presentasi',
            'document' => 'Dokumen',
            'image' => 'Gambar',
            'audio' => 'Audio',
            'link' => 'Tautan Eksternal'
        ];

        return view('admin.tugas.create', compact('kelas', 'mediaTypes'));
    }

    public function postStore(Request $request)
    {
        // Validasi input dasar
        $validationRules = [
            'kelas_id' => 'required|exists:kelas,id',
            'judul' => 'required|string|max:255',
            'instruksi' => 'nullable|string',
            'tenggat_waktu' => 'nullable|date',
            'tipe_tugas' => 'required|in:standar,media,kuis',
            'tampilkan_nilai' => 'nullable|boolean',
        ];
        
        // Validasi tambahan berdasarkan tipe tugas
        if ($request->tipe_tugas == 'media') {
            $validationRules['media_type'] = 'required|in:video,slide,document,image,audio,link';
            $validationRules['media_url'] = 'required|string';
            $validationRules['media_deskripsi'] = 'nullable|string';
        }
        
        if ($request->tipe_tugas == 'kuis' || $request->is_kuis) {
            $validationRules['waktu_mulai'] = 'required|date';
            $validationRules['waktu_selesai'] = 'required|date|after:waktu_mulai';
            $validationRules['durasi_menit'] = 'nullable|integer|min:1';
        }
        
        $request->validate($validationRules);

        // Simpan tugas baru
        $tugas = new Tugas();
        $tugas->kelas_id = $request->kelas_id;
        $tugas->judul = $request->judul;
        $tugas->instruksi = $request->instruksi;
        $tugas->tenggat_waktu = $request->tenggat_waktu;
        $tugas->tipe_tugas = $request->tipe_tugas;
        $tugas->tampilkan_nilai = $request->has('tampilkan_nilai') ? $request->tampilkan_nilai : false;
        
        // Jika tipe tugas adalah media
        if ($request->tipe_tugas == 'media') {
            $tugas->media_type = $request->media_type;
            $tugas->media_url = $request->media_url;
            $tugas->media_deskripsi = $request->media_deskripsi;
        }
        
        // Jika tipe tugas adalah kuis atau memiliki kuis
        if ($request->tipe_tugas == 'kuis' || $request->is_kuis) {
            $tugas->is_kuis = true;
            $tugas->waktu_mulai = $request->waktu_mulai;
            $tugas->waktu_selesai = $request->waktu_selesai;
            $tugas->durasi_menit = $request->durasi_menit;
            
            // Jika ada kuis_id, hubungkan dengan kuis yang sudah ada
            if ($request->filled('kuis_id')) {
                $tugas->kuis_id = $request->kuis_id;
            }
        } else {
            $tugas->is_kuis = false;
        }
        
        $tugas->save();

        // Jika tipe tugas adalah kuis dan tidak ada kuis_id, redirect ke halaman pembuatan kuis
        if ($request->tipe_tugas == 'kuis' && !$request->filled('kuis_id')) {
            return redirect('/admin/kuis/create/' . $tugas->id)->with('success', 'Tugas berhasil ditambahkan. Silakan buat kuis untuk tugas ini.');
        }

        return redirect('/admin/tugas')->with('success', 'Tugas berhasil ditambahkan');
    }

    public function getShow($id)
    {
        // Menggunakan Eloquent untuk mendapatkan relasi
        $tugas = Tugas::with(['kuis', 'kuis.pertanyaan', 'kuis.pertanyaan.jawaban'])
            ->findOrFail($id);
            
        // Mendapatkan data kelas dan tahun ajaran
        $kelasData = DB::table('kelas')
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->select(
                'kelas.nama as kelas_nama',
                'kelas.jenjang',
                'kelas.tingkat',
                'tahun_ajaran.nama as tahun_ajaran_nama'
            )
            ->where('kelas.id', $tugas->kelas_id)
            ->first();
            
        // Menggabungkan data tugas dengan data kelas
        $tugasData = (object) array_merge(
            (array) $tugas->toArray(),
            (array) $kelasData
        );

        // Ambil data pengumpulan tugas
        $pengumpulan = DB::table('pengumpulan_tugas')
            ->join('users', 'pengumpulan_tugas.siswa_id', '=', 'users.id')
            ->leftJoin('nilai', 'pengumpulan_tugas.id', '=', 'nilai.pengumpulan_id')
            ->select(
                'pengumpulan_tugas.*',
                'users.nama as siswa_nama',
                'users.email as siswa_email',
                'nilai.skor',
                'nilai.umpan_balik'
            )
            ->where('pengumpulan_tugas.tugas_id', $id)
            ->orderBy('pengumpulan_tugas.waktu_pengumpulan', 'desc')
            ->get();
            
        // Jika tugas adalah kuis, ambil juga data jawaban siswa
        $jawabanSiswa = null;
        if ($tugas->is_kuis && $tugas->kuis_id) {
            $jawabanSiswa = DB::table('jawaban_siswa_kuis')
                ->join('users', 'jawaban_siswa_kuis.siswa_id', '=', 'users.id')
                ->join('pertanyaan_kuis', 'jawaban_siswa_kuis.pertanyaan_id', '=', 'pertanyaan_kuis.id')
                ->leftJoin('jawaban_kuis', 'jawaban_siswa_kuis.jawaban_id', '=', 'jawaban_kuis.id')
                ->select(
                    'jawaban_siswa_kuis.*',
                    'users.nama as siswa_nama',
                    'pertanyaan_kuis.pertanyaan',
                    'pertanyaan_kuis.tipe',
                    'jawaban_kuis.jawaban as jawaban_teks_pilihan'
                )
                ->where('jawaban_siswa_kuis.tugas_id', $id)
                ->orderBy('users.nama')
                ->orderBy('pertanyaan_kuis.urutan')
                ->get();
        }

        return view('admin.tugas.show', compact('tugasData', 'pengumpulan', 'jawabanSiswa'));
    }

    public function getEdit($id)
    {
        $tugas = Tugas::with('kuis')->findOrFail($id);

        // Data untuk dropdown
        $kelas = DB::table('kelas')
            ->leftJoin('tahun_ajaran', 'kelas.tahun_ajaran_id', '=', 'tahun_ajaran.id')
            ->select('kelas.id', 'kelas.nama', 'kelas.jenjang', 'kelas.tingkat', 'tahun_ajaran.nama as tahun_ajaran')
            ->orderBy('kelas.jenjang')
            ->orderBy('kelas.tingkat')
            ->get();
            
        // Data untuk dropdown tipe media
        $mediaTypes = [
            'video' => 'Video',
            'slide' => 'Slide/Presentasi',
            'document' => 'Dokumen',
            'image' => 'Gambar',
            'audio' => 'Audio',
            'link' => 'Tautan Eksternal'
        ];

        return view('admin.tugas.edit', compact('tugas', 'kelas', 'mediaTypes'));
    }

    public function postUpdate(Request $request, $id)
    {
        // Validasi input dasar
        $validationRules = [
            'kelas_id' => 'required|exists:kelas,id',
            'judul' => 'required|string|max:255',
            'instruksi' => 'nullable|string',
            'tenggat_waktu' => 'nullable|date',
            'tipe_tugas' => 'required|in:standar,media,kuis',
            'tampilkan_nilai' => 'nullable|boolean',
        ];
        
        // Validasi tambahan berdasarkan tipe tugas
        if ($request->tipe_tugas == 'media') {
            $validationRules['media_type'] = 'required|in:video,slide,document,image,audio,link';
            $validationRules['media_url'] = 'required|string';
            $validationRules['media_deskripsi'] = 'nullable|string';
        }
        
        if ($request->tipe_tugas == 'kuis' || $request->is_kuis) {
            $validationRules['waktu_mulai'] = 'required|date';
            $validationRules['waktu_selesai'] = 'required|date|after:waktu_mulai';
            $validationRules['durasi_menit'] = 'nullable|integer|min:1';
        }
        
        $request->validate($validationRules);

        // Update tugas
        $tugas = Tugas::findOrFail($id);
        $tugas->kelas_id = $request->kelas_id;
        $tugas->judul = $request->judul;
        $tugas->instruksi = $request->instruksi;
        $tugas->tenggat_waktu = $request->tenggat_waktu;
        $tugas->tipe_tugas = $request->tipe_tugas;
        $tugas->tampilkan_nilai = $request->has('tampilkan_nilai') ? $request->tampilkan_nilai : false;
        
        // Jika tipe tugas adalah media
        if ($request->tipe_tugas == 'media') {
            $tugas->media_type = $request->media_type;
            $tugas->media_url = $request->media_url;
            $tugas->media_deskripsi = $request->media_deskripsi;
            // Reset kuis jika sebelumnya adalah kuis
            $tugas->is_kuis = false;
            $tugas->kuis_id = null;
            $tugas->waktu_mulai = null;
            $tugas->waktu_selesai = null;
            $tugas->durasi_menit = null;
        }
        
        // Jika tipe tugas adalah kuis atau memiliki kuis
        if ($request->tipe_tugas == 'kuis' || $request->is_kuis) {
            $tugas->is_kuis = true;
            $tugas->waktu_mulai = $request->waktu_mulai;
            $tugas->waktu_selesai = $request->waktu_selesai;
            $tugas->durasi_menit = $request->durasi_menit;
            
            // Jika ada kuis_id, hubungkan dengan kuis yang sudah ada
            if ($request->filled('kuis_id')) {
                $tugas->kuis_id = $request->kuis_id;
            }
            
            // Reset media jika sebelumnya adalah media
            if ($request->tipe_tugas != 'media') {
                $tugas->media_type = null;
                $tugas->media_url = null;
                $tugas->media_deskripsi = null;
            }
        } else {
            $tugas->is_kuis = false;
        }
        
        $tugas->save();

        // Jika tipe tugas adalah kuis dan tidak ada kuis_id, redirect ke halaman pembuatan kuis
        if ($request->tipe_tugas == 'kuis' && !$request->filled('kuis_id') && !$tugas->kuis_id) {
            return redirect('/admin/kuis/create/' . $tugas->id)->with('success', 'Tugas berhasil diperbarui. Silakan buat kuis untuk tugas ini.');
        }

        return redirect('/admin/tugas')->with('success', 'Tugas berhasil diperbarui');
    }

    public function getDelete($id)
    {
        $tugas = Tugas::findOrFail($id);
        $tugas->delete();

        return redirect('/admin/tugas')->with('success', 'Tugas berhasil dihapus');
    }

    public function getNilai($pengumpulanId)
    {
        $pengumpulan = DB::table('pengumpulan_tugas')
            ->join('users', 'pengumpulan_tugas.siswa_id', '=', 'users.id')
            ->join('tugas', 'pengumpulan_tugas.tugas_id', '=', 'tugas.id')
            ->leftJoin('nilai', 'pengumpulan_tugas.id', '=', 'nilai.pengumpulan_id')
            ->select(
                'pengumpulan_tugas.*',
                'users.name as siswa_nama',
                'users.email as siswa_email',
                'tugas.judul as tugas_judul',
                'nilai.skor',
                'nilai.umpan_balik'
            )
            ->where('pengumpulan_tugas.id', $pengumpulanId)
            ->first();

        if (!$pengumpulan) {
            return redirect('/admin/tugas')->with('error', 'Pengumpulan tugas tidak ditemukan');
        }

        return view('admin.tugas.nilai', compact('pengumpulan'));
    }

    public function postNilai(Request $request, $pengumpulanId)
    {
        // Validasi input
        $request->validate([
            'skor' => 'required|numeric|min:0|max:100',
            'umpan_balik' => 'nullable|string',
        ]);

        // Cek apakah pengumpulan ada
        $pengumpulan = PengumpulanTugas::findOrFail($pengumpulanId);

        // Cek apakah sudah ada nilai
        $nilai = DB::table('nilai')->where('pengumpulan_id', $pengumpulanId)->first();

        if ($nilai) {
            // Update nilai yang sudah ada
            DB::table('nilai')
                ->where('pengumpulan_id', $pengumpulanId)
                ->update([
                    'skor' => $request->skor,
                    'umpan_balik' => $request->umpan_balik,
                    'penilai_id' => Auth::id(),
                    'dinilai_pada' => now(),
                ]);
        } else {
            // Buat nilai baru
            DB::table('nilai')->insert([
                'pengumpulan_id' => $pengumpulanId,
                'skor' => $request->skor,
                'umpan_balik' => $request->umpan_balik,
                'penilai_id' => Auth::id(),
                'dinilai_pada' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect('/admin/tugas/show/' . $pengumpulan->tugas_id)->with('success', 'Nilai berhasil disimpan');
    }
}