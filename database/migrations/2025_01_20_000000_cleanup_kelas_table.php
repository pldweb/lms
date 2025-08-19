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
            // Hapus field tahun_ajaran yang sudah tidak digunakan
            // karena sudah diganti dengan tahun_ajaran_id (foreign key)
            if (Schema::hasColumn('kelas', 'tahun_ajaran')) {
                $table->dropColumn('tahun_ajaran');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            // Kembalikan field tahun_ajaran jika rollback
            $table->string('tahun_ajaran')->nullable()->after('tingkat');
        });
    }
};