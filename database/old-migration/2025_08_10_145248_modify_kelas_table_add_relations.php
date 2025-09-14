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
        Schema::table('kelas', function (Blueprint $table) {
            // Tambah foreign key untuk tahun ajaran
            $table->foreignId('tahun_ajaran_id')->nullable()->after('guru_id')->constrained('tahun_ajaran')->onDelete('cascade');
            
            // Tambah foreign key untuk mata pelajaran
            $table->foreignId('mata_pelajaran_id')->nullable()->after('tahun_ajaran_id')->constrained('mata_pelajaran')->onDelete('cascade');
            
            // Tambah field tingkat untuk class level (1-12)
            $table->tinyInteger('tingkat')->nullable()->after('jenjang');
            
            // Tambah kapasitas siswa
            $table->integer('kapasitas_siswa')->default(30)->after('semester');
            
            // Tambah status kelas
            $table->enum('status', ['aktif', 'non-aktif', 'selesai'])->default('aktif')->after('kapasitas_siswa');
            
            // Index untuk performa
            $table->index(['tahun_ajaran_id', 'mata_pelajaran_id', 'status']);
            $table->index(['jenjang', 'tingkat', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropForeign(['tahun_ajaran_id']);
            $table->dropForeign(['mata_pelajaran_id']);
            $table->dropColumn([
                'tahun_ajaran_id',
                'mata_pelajaran_id', 
                'tingkat',
                'kapasitas_siswa',
                'status'
            ]);
        });
    }
};
