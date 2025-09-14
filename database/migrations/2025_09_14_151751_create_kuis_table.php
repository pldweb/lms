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
            $table->unsignedBigInteger('pembuat_id');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->enum('tipe', ['pilihan_ganda', 'essay', 'campuran'])->default('pilihan_ganda');
            $table->integer('jumlah_soal')->default(0);
            $table->integer('nilai_maksimum')->default(100);
            $table->boolean('acak_soal')->default(false);
            $table->boolean('tampilkan_hasil')->default(true);
            $table->timestamps();
            
            $table->foreign('pembuat_id')->references('id')->on('users')->onDelete('cascade');
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
