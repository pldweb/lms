<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanKuis extends Model
{
    protected $table = 'jawaban_kuis';
    
    protected $fillable = [
        'pertanyaan_id',
        'jawaban',
        'is_benar',
        'urutan'
    ];
    
    protected $casts = [
        'is_benar' => 'boolean',
        'urutan' => 'integer',
    ];
    
    public function pertanyaan()
    {
        return $this->belongsTo(PertanyaanKuis::class, 'pertanyaan_id');
    }
    
    public function jawabanSiswa()
    {
        return $this->hasMany(JawabanSiswaKuis::class, 'jawaban_id');
    }
}
