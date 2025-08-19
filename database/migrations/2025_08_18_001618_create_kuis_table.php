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
        Schema::create('kuis', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->integer('waktu_pengerjaan_menit')->default(30);
            $table->boolean('acak_pertanyaan')->default(false);
            $table->boolean('tampilkan_hasil_langsung')->default(true);
            $table->boolean('tampilkan_jawaban_benar')->default(false);
            $table->integer('jumlah_percobaan')->default(1);
            $table->unsignedBigInteger('created_by');
            $table->timestamps();
            
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('tugas', function (Blueprint $table) {
            $table->string('tipe_tugas')->default('standar');
            
            // Kolom untuk media (video, slide, file)
            $table->string('media_type')->nullable(); // video, slide, file
            $table->string('media_url')->nullable(); // URL atau path ke media
            $table->text('media_deskripsi')->nullable();
            
            // Kolom untuk kuis
            $table->boolean('is_kuis')->default(false);
            $table->unsignedBigInteger('kuis_id')->nullable();
            
            // Kolom untuk pengaturan visibilitas nilai
            $table->boolean('tampilkan_nilai')->default(true);
            
            // Kolom untuk jadwal kuis
            $table->timestamp('waktu_mulai')->nullable();
            $table->timestamp('waktu_selesai')->nullable();
            $table->integer('durasi_menit')->nullable();
            
            // Foreign key untuk kuis
            $table->foreign('kuis_id')->references('id')->on('kuis')->onDelete('set null');
        });

        Schema::create('pertanyaan_kuis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kuis_id');
            $table->text('pertanyaan');
            $table->string('tipe')->default('pilihan_ganda'); // pilihan_ganda, benar_salah, isian_singkat
            $table->integer('bobot_nilai')->default(1);
            $table->integer('urutan')->default(0);
            $table->timestamps();
            
            $table->foreign('kuis_id')->references('id')->on('kuis')->onDelete('cascade');
        });

        Schema::create('jawaban_kuis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pertanyaan_id');
            $table->text('jawaban');
            $table->boolean('is_benar')->default(false);
            $table->integer('urutan')->default(0);
            $table->timestamps();
            
            $table->foreign('pertanyaan_id')->references('id')->on('pertanyaan_kuis')->onDelete('cascade');
        });

        Schema::create('jawaban_siswa_kuis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tugas_id');
            $table->unsignedBigInteger('kuis_id');
            $table->unsignedBigInteger('pertanyaan_id');
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('jawaban_id')->nullable(); // Untuk pilihan ganda
            $table->text('jawaban_teks')->nullable(); // Untuk isian singkat
            $table->boolean('is_benar')->default(false);
            $table->float('nilai')->default(0);
            $table->timestamp('waktu_menjawab')->nullable();
            $table->timestamps();
            
            $table->foreign('tugas_id')->references('id')->on('tugas')->onDelete('cascade');
            $table->foreign('kuis_id')->references('id')->on('kuis')->onDelete('cascade');
            $table->foreign('pertanyaan_id')->references('id')->on('pertanyaan_kuis')->onDelete('cascade');
            $table->foreign('siswa_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('jawaban_id')->references('id')->on('jawaban_kuis')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuis');
    }
};
