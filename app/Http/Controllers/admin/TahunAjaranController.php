<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TahunAjaranController extends Controller
{
    public function getIndex()
    {
        $tahunAjaran = DB::table('tahun_ajaran')
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

            $params = [
                'tahunAjaran' => $tahunAjaran
            ];
        return view('admin.tahun-ajaran.index', $params);
    }

    public function getCreate()
    {
        return view('admin.tahun-ajaran.create');
    }

    public function postStore(Request $request)
    {
        try {
            DB::beginTransaction();
            DB::table('tahun_ajaran')->insert([
                'nama' => $request->nama,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'status' => 'non-aktif',
                'keterangan' => $request->keterangan,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            DB::commit();
            return successAlert('Tahun ajaran berhasil ditambahkan!', null, '#message-modal', '/admin/tahun-ajaran/');
        } catch (\Exception $e) {
            DB::rollBack();
            return errorAlert('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function getShow(string $id)
    {
        $tahunAjaran = DB::table('tahun_ajaran')->where('id', $id)->first();
        
        if (!$tahunAjaran) {
            return redirect('/admin/tahun-ajaran/')
                ->with('error', 'Data tidak ditemukan!');
        }

        // Statistik kelas per tahun ajaran
        $jumlahKelas = DB::table('kelas')
            ->where('tahun_ajaran_id', $id)
            ->count();

        $jumlahSiswa = DB::table('keanggotaan_kelas')
            ->join('kelas', 'keanggotaan_kelas.kelas_id', '=', 'kelas.id')
            ->where('kelas.tahun_ajaran_id', $id)
            ->count();

            $params = [
                'tahunAjaran' => $tahunAjaran,
                'jumlahKelas' => $jumlahKelas,
                'jumlahSiswa' => $jumlahSiswa
            ];

        return view('admin.tahun-ajaran.show', $params);
    }

    public function getEdit(string $id)
    {
        $tahunAjaran = DB::table('tahun_ajaran')->where('id', $id)->first();
        
        if (!$tahunAjaran) {
            return redirect('/admin/tahun-ajaran/')
                ->with('error', 'Data tidak ditemukan!');
        }

        return view('admin.tahun-ajaran.edit', compact('tahunAjaran'));
    }

    public function postUpdate(Request $request, string $id)
    {
        try {
            DB::table('tahun_ajaran')
                ->where('id', $id)
                ->update([
                    'nama' => $request->nama,
                    'tanggal_mulai' => $request->tanggal_mulai,
                    'tanggal_selesai' => $request->tanggal_selesai,
                    'keterangan' => $request->keterangan,
                    'updated_at' => now()
                ]);

            return redirect('/admin/tahun-ajaran/')
                ->with('success', 'Tahun ajaran berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function postDelete(string $id)
    {
        try {
            // Cek apakah tahun ajaran sedang digunakan
            $kelasCount = DB::table('kelas')->where('tahun_ajaran_id', $id)->count();
            
            if ($kelasCount > 0) {
                return errorAlert('Tahun ajaran tidak dapat dihapus karena masih memiliki ' . $kelasCount . ' kelas aktif!', null, '#message-modal');
            }
            DB::table('tahun_ajaran')->where('id', $id)->delete();
            return successAlert('Tahun ajaran berhasil dihapus!', null, '#message-modal', '/admin/tahun-ajaran/');
            
        } catch (\Exception $e) {
            return errorAlert('Terjadi kesalahan: ' . $e->getMessage(), null, '#message-modal');
        }
    }

    public function postActivate(string $id)
    {
        try {

            if (DB::table('tahun_ajaran')->where('status', 'aktif')->count() > 0) {
                return errorAlert('Tidak dapat mengaktifkan tahun ajaran baru karena ada tahun ajaran yang aktif!', null, '#message-modal');
            }

            // Non-aktifkan semua tahun ajaran
            DB::table('tahun_ajaran')->update(['status' => 'non-aktif']);
            
            // Aktifkan tahun ajaran yang dipilih
            DB::table('tahun_ajaran')
                ->where('id', $id)
                ->update(['status' => 'aktif']);

            return successAlert('Tahun ajaran berhasil diaktifkan!', null, '#message-modal', '/admin/tahun-ajaran/');

        } catch (\Exception $e) {
            return errorAlert('Terjadi kesalahan: ' . $e->getMessage(), null, '#message-modal');
        }
    }
}
