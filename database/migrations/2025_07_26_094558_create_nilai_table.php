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
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengumpulan_id')->constrained('pengumpulan_tugas')->cascadeOnDelete();
            $table->foreignId('penilai_id')->nullable()->constrained('users')->onDelete('set null');
            $table->decimal('skor', 5, 2);
            $table->text('umpan_balik')->nullable();
            $table->timestamp('dinilai_pada')->useCurrent();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai');
    }
};
