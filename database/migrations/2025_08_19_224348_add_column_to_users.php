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
        Schema::table('users', function (Blueprint $table) {
            $table->date('tanggal_lahir')->after('email')->nullable();
            $table->string('tempat')->after('tanggal_lahir')->nullable();
            $table->string('nisn')->after('tempat')->nullable();
            $table->string('asal_sekolah')->after('nisn')->nullable();
            $table->string('nama_orang_tua')->after('asal_sekolah')->nullable();
            $table->string('no_hp_orang_tua')->after('nama_orang_tua')->nullable();
            $table->string('pekerjaan_orang_tua')->after('no_hp_orang_tua')->nullable();
            $table->string('alamat_orang_tua')->after('pekerjaan_orang_tua')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
