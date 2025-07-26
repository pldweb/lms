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
        Schema::create('wali_siswa', function (Blueprint $table) {
            // $table->id();
            $table->foreignId('wali_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('siswa_id')->nullable()->constrained('users')->cascadeOnDelete();

            $table->primary(['wali_id', 'siswa_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wali_siswa');
    }
};
