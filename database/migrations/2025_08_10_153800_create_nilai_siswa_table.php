<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nilai_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajaran')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->foreignId('tahun_ajaran_id')->constrained('tahun_ajaran')->onDelete('cascade');
            $table->enum('semester', ['ganjil', 'genap']);
            $table->enum('jenis_nilai', ['tugas', 'uts', 'uas', 'praktik', 'harian']);
            $table->decimal('nilai', 5, 2);
            $table->decimal('bobot', 3, 2)->default(1.00); // Bobot penilaian
            $table->text('keterangan')->nullable();
            $table->date('tanggal_penilaian');
            $table->foreignId('guru_id')->constrained('users')->onDelete('cascade'); // Guru yang menilai
            $table->timestamps();

            // Index untuk optimasi query
            $table->index(['siswa_id', 'tahun_ajaran_id', 'semester']);
            $table->index(['mata_pelajaran_id', 'kelas_id']);
            $table->unique(['siswa_id', 'mata_pelajaran_id', 'kelas_id', 'tahun_ajaran_id', 'semester', 'jenis_nilai'], 'nilai_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_siswa');
    }
};
