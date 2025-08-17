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
        Schema::table('mata_pelajaran', function (Blueprint $table) {
            // Drop old columns if they exist
            if (Schema::hasColumn('mata_pelajaran', 'kategori')) {
                $table->dropColumn('kategori');
            }
            if (Schema::hasColumn('mata_pelajaran', 'tingkat')) {
                $table->dropColumn('tingkat');
            }
            if (Schema::hasColumn('mata_pelajaran', 'bobot_sks')) {
                $table->dropColumn('bobot_sks');
            }
            if (Schema::hasColumn('mata_pelajaran', 'is_active')) {
                $table->dropColumn('is_active');
            }
            
            // Add new columns
            if (!Schema::hasColumn('mata_pelajaran', 'semester')) {
                $table->integer('semester')->nullable()->after('jenjang');
            }
            if (!Schema::hasColumn('mata_pelajaran', 'sks')) {
                $table->integer('sks')->default(1)->after('semester');
            }
            if (!Schema::hasColumn('mata_pelajaran', 'urutan')) {
                $table->integer('urutan')->default(0)->after('sks');
            }
            if (!Schema::hasColumn('mata_pelajaran', 'aktif')) {
                $table->boolean('aktif')->default(true)->after('urutan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mata_pelajaran', function (Blueprint $table) {
            // Drop new columns
            if (Schema::hasColumn('mata_pelajaran', 'semester')) {
                $table->dropColumn('semester');
            }
            if (Schema::hasColumn('mata_pelajaran', 'sks')) {
                $table->dropColumn('sks');
            }
            if (Schema::hasColumn('mata_pelajaran', 'urutan')) {
                $table->dropColumn('urutan');
            }
            if (Schema::hasColumn('mata_pelajaran', 'aktif')) {
                $table->dropColumn('aktif');
            }
            
            // Add back old columns
            $table->string('kategori')->nullable()->after('jenjang');
            $table->string('tingkat')->nullable()->after('kategori');
            $table->integer('bobot_sks')->default(1)->after('tingkat');
            $table->boolean('is_active')->default(true)->after('bobot_sks');
        });
    }
};
