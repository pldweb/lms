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
        Schema::create('galeri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_galeri_id')->constrained('kategori_galeri')->onDelete('cascade');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->enum('tipe', ['foto', 'video']); // foto atau video
            $table->string('file_path')->nullable(); // untuk foto
            $table->string('youtube_url')->nullable(); // untuk video YouTube
            $table->string('youtube_thumbnail')->nullable(); // thumbnail dari YouTube
            $table->date('tanggal_foto')->nullable();
            $table->string('fotografer')->nullable();
            $table->integer('urutan')->default(0);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galeri');
    }
};
