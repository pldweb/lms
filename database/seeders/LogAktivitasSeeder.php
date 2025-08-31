<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LogAktivitas;
use App\Models\User;
use Carbon\Carbon;

class LogAktivitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil beberapa user untuk dijadikan contoh
        $users = User::take(10)->get();
        
        if ($users->isEmpty()) {
            $this->command->info('Tidak ada user yang ditemukan. Silakan jalankan UserSeeder terlebih dahulu.');
            return;
        }
        
        $tipeAktivitas = ['login', 'logout', 'upload', 'download', 'create', 'update', 'delete'];
        $aktivitasDetail = [
            'login' => ['Login ke sistem', 'Masuk ke dashboard'],
            'logout' => ['Logout dari sistem', 'Keluar dari aplikasi'],
            'upload' => ['Upload materi pembelajaran', 'Upload tugas siswa', 'Upload dokumen penting'],
            'download' => ['Download materi', 'Download nilai siswa', 'Download laporan'],
            'create' => ['Membuat tugas baru', 'Membuat pengumuman', 'Membuat jadwal ujian', 'Membuat kelas baru'],
            'update' => ['Memperbarui profil', 'Memperbarui nilai siswa', 'Memperbarui jadwal pelajaran', 'Memperbarui materi'],
            'delete' => ['Menghapus tugas', 'Menghapus pengumuman lama', 'Menghapus file tidak terpakai']
        ];
        
        // Buat 50 log aktivitas acak dalam 30 hari terakhir
        for ($i = 0; $i < 50; $i++) {
            $user = $users->random();
            $tipe = $tipeAktivitas[array_rand($tipeAktivitas)];
            $aktivitas = $aktivitasDetail[$tipe][array_rand($aktivitasDetail[$tipe])];
            
            // Tanggal acak dalam 30 hari terakhir
            $tanggal = Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
            
            LogAktivitas::create([
                'user_id' => $user->id,
                'aktivitas' => $aktivitas,
                'waktu' => $tanggal,
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                'ip_address' => '192.168.1.' . rand(1, 255),
                'tipe' => $tipe,
            ]);
        }
        
        $this->command->info('Data log aktivitas berhasil dibuat!');
    }
}