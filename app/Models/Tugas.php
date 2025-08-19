<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tugas';

    protected $fillable = [
        'kelas_id',
        'judul',
        'instruksi',
        'tenggat_waktu',
        'tipe_tugas',
        'media_type',
        'media_url',
        'media_deskripsi',
        'is_kuis',
        'kuis_id',
        'tampilkan_nilai',
        'waktu_mulai',
        'waktu_selesai',
        'durasi_menit',
    ];

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function pengumpulan(): HasMany
    {
        return $this->hasMany(PengumpulanTugas::class, 'tugas_id');
    }
    
    public function kuis(): BelongsTo
    {
        return $this->belongsTo(Kuis::class, 'kuis_id');
    }
    
    public function jawabanSiswaKuis(): HasMany
    {
        return $this->hasMany(JawabanSiswaKuis::class, 'tugas_id');
    }
}