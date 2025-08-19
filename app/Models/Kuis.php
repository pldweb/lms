<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kuis extends Model
{
    protected $table = 'kuis';
    
    protected $fillable = [
        'judul',
        'deskripsi',
        'waktu_pengerjaan_menit',
        'acak_pertanyaan',
        'tampilkan_hasil_langsung',
        'tampilkan_jawaban_benar',
        'jumlah_percobaan',
        'created_by'
    ];
    
    public function pertanyaan()
    {
        return $this->hasMany(PertanyaanKuis::class, 'kuis_id');
    }
    
    public function tugas()
    {
        return $this->hasOne(Tugas::class, 'kuis_id');
    }
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function jawabanSiswa()
    {
        return $this->hasMany(JawabanSiswaKuis::class, 'kuis_id');
    }
}
