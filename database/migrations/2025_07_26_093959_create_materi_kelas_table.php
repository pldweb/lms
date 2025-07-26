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
        Schema::create('materi_kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('kelas')->cascadeOnDelete();
            $table->string('judul')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('tipe_materi')->nullable(); // ('tipe_materi', ['File', 'Tautan', 'Video']);
            $table->string('path_file');
            $table->timestamp('diunggah_pada')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materi_kelas');
    }
};
