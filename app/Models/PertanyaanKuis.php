<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PertanyaanKuis extends Model
{
    protected $table = 'pertanyaan_kuis';
    
    protected $fillable = [
        'kuis_id',
        'pertanyaan',
        'tipe',
        'bobot_nilai',
        'urutan',
        'gambar'
    ];
    
    protected $casts = [
        'bobot_nilai' => 'integer',
        'urutan' => 'integer',
    ];
    
    public function kuis()
    {
        return $this->belongsTo(Kuis::class, 'kuis_id');
    }
    
    public function jawaban()
    {
        return $this->hasMany(JawabanKuis::class, 'pertanyaan_id');
    }
    
    public function jawabanSiswa()
    {
        return $this->hasMany(JawabanSiswaKuis::class, 'pertanyaan_id');
    }
}
