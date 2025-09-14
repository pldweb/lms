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
        Schema::create('jawaban_siswa_kuis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tugas_id');
            $table->unsignedBigInteger('kuis_id');
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('pertanyaan_id');
            $table->text('jawaban_teks')->nullable();
            $table->unsignedBigInteger('jawaban_id')->nullable();
            $table->boolean('is_benar')->nullable();
            $table->float('nilai')->nullable();
            $table->timestamp('waktu_mulai')->nullable();
            $table->timestamp('waktu_selesai')->nullable();
            $table->timestamps();
            
            $table->foreign('tugas_id')->references('id')->on('tugas')->onDelete('cascade');
            $table->foreign('kuis_id')->references('id')->on('kuis')->onDelete('cascade');
            $table->foreign('siswa_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pertanyaan_id')->references('id')->on('pertanyaan_kuis')->onDelete('cascade');
            $table->foreign('jawaban_id')->references('id')->on('jawaban_kuis')->onDelete('set null');
            
            $table->unique(['siswa_id', 'pertanyaan_id', 'tugas_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_siswa_kuis');
    }
};
