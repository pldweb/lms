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
        Schema::create('peserta_percakapan', function (Blueprint $table) {
            // $table->id();
            $table->foreignId('percakapan_id')->constrained('percakapan')->cascadeOnDelete();
            $table->foreignId('pengguna_id')->constrained('users')->cascadeOnDelete();

            $table->primary(['percakapan_id', 'pengguna_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peserta_percakapan');
    }
};
