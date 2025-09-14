<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kuis extends Model
{
    protected $table = 'kuis';
    
    protected $fillable = [
        'pembuat_id',
        'judul',
        'deskripsi',
        'tipe',
        'jumlah_soal',
        'nilai_maksimum',
        'acak_soal',
        'tampilkan_hasil'
    ];
    
    protected $casts = [
        'acak_soal' => 'boolean',
        'tampilkan_hasil' => 'boolean',
    ];
    
    public function pertanyaan()
    {
        return $this->hasMany(PertanyaanKuis::class, 'kuis_id');
    }
    
    public function tugas()
    {
        return $this->hasOne(Tugas::class, 'kuis_id');
    }
    
    public function pembuat()
    {
        return $this->belongsTo(User::class, 'pembuat_id');
    }
    
    public function jawabanSiswa()
    {
        return $this->hasMany(JawabanSiswaKuis::class, 'kuis_id');
    }
    
    public function hasilKuis()
    {
        return $this->hasMany(HasilKuis::class, 'kuis_id');
    }
}
