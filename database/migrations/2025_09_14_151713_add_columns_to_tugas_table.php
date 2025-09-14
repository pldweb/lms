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
        Schema::table('tugas', function (Blueprint $table) {
            $table->enum('tipe_tugas', ['biasa', 'soal_online', 'ujian'])->default('biasa')->after('tenggat_waktu');
            $table->string('media_type')->nullable()->after('tipe_tugas');
            $table->string('media_url')->nullable()->after('media_type');
            $table->text('media_deskripsi')->nullable()->after('media_url');
            $table->boolean('is_kuis')->default(false)->after('media_deskripsi');
            $table->boolean('tampilkan_nilai')->default(true)->after('is_kuis');
            $table->timestamp('waktu_mulai')->nullable()->after('tampilkan_nilai');
            $table->timestamp('waktu_selesai')->nullable()->after('waktu_mulai');
            $table->integer('durasi_menit')->nullable()->after('waktu_selesai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tugas', function (Blueprint $table) {
            $table->dropColumn([
                'tipe_tugas',
                'media_type',
                'media_url',
                'media_deskripsi',
                'is_kuis',
                'tampilkan_nilai',
                'waktu_mulai',
                'waktu_selesai',
                'durasi_menit'
            ]);
        });
    }
};
