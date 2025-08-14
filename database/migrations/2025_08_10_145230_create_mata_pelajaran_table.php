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
        Schema::create('mata_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique(); // MTK001, IPA002, etc.
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->enum('kategori', ['wajib', 'pilihan', 'muatan_lokal'])->default('wajib');
            $table->enum('jenjang', ['SD', 'SMP', 'SMA', 'SMK'])->nullable();
            $table->tinyInteger('tingkat')->nullable(); // 1-6 untuk SD, 7-9 untuk SMP, dst
            $table->integer('bobot_sks')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Index untuk performa
            $table->index(['jenjang', 'tingkat', 'is_active']);
            $table->index(['kategori', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mata_pelajaran');
    }
};
