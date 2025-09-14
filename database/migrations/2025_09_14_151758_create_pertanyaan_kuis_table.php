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
        Schema::create('pertanyaan_kuis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kuis_id');
            $table->text('pertanyaan');
            $table->enum('tipe', ['pilihan_ganda', 'essay'])->default('pilihan_ganda');
            $table->integer('bobot_nilai')->default(1);
            $table->integer('urutan')->default(0);
            $table->string('gambar')->nullable();
            $table->timestamps();
            
            $table->foreign('kuis_id')->references('id')->on('kuis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan_kuis');
    }
};
