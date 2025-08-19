<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanSiswaKuis extends Model
{
    protected $table = 'jawaban_siswa_kuis';
    
    protected $fillable = [
        'tugas_id',
        'kuis_id',
        'pertanyaan_id',
        'siswa_id',
        'jawaban_id',
        'jawaban_teks',
        'is_benar',
        'nilai',
        'waktu_menjawab'
    ];
    
    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'tugas_id');
    }
    
    public function kuis()
    {
        return $this->belongsTo(Kuis::class, 'kuis_id');
    }
    
    public function pertanyaan()
    {
        return $this->belongsTo(PertanyaanKuis::class, 'pertanyaan_id');
    }
    
    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }
    
    public function jawaban()
    {
        return $this->belongsTo(JawabanKuis::class, 'jawaban_id');
    }
}
