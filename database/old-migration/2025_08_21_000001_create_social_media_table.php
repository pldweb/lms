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
        Schema::create('social_media', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Nama platform (Facebook, Instagram, Twitter, dll)
            $table->string('icon'); // Icon untuk social media
            $table->string('link'); // URL link ke social media
            $table->text('deskripsi')->nullable(); // Deskripsi optional
            $table->integer('urutan')->default(0); // Urutan tampil
            $table->boolean('aktif')->default(true); // Status aktif/nonaktif
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_media');
    }
};