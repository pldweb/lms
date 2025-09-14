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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('nama_kelas');
            $table->string('kode_kelas', 50)->unique()->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('jenjang', 10)->nullable();
            $table->string('tahun_ajaran')->nullable();
            $table->tinyInteger('semester')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
