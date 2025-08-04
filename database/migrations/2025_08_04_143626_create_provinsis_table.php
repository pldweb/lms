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
        Schema::create('provinsis', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique(); // ex: 11
            $table->string('nama');
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->timestamps();
        });

        Schema::create('kabupatens', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique(); // ex: 11.01
            $table->string('nama');
            $table->string('kode_provinsi'); // foreign from provinsis.kode
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->timestamps();

            // === TAMBAHAN FOREIGN KEY ===
            $table->foreign('kode_provinsi')
                  ->references('kode')
                  ->on('provinsis')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });

        Schema::create('kecamatans', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->string('kode_kabupaten'); 
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->timestamps();

            $table->foreign('kode_kabupaten')
                  ->references('kode')
                  ->on('kabupatens')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });

        Schema::create('kelurahans', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->string('kode_kecamatan'); 
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->timestamps();

            $table->foreign('kode_kecamatan')
                  ->references('kode')
                  ->on('kecamatans')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelurahans');
        Schema::dropIfExists('kecamatans');
        Schema::dropIfExists('kabupatens');
        Schema::dropIfExists('provinsis');
    }
};