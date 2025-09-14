<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilKuis extends Model
{
    protected $table = 'hasil_kuis';
    
    protected $fillable = [
        'tugas_id',
        'kuis_id',
        'siswa_id',
        'nilai_total',
        'jumlah_benar',
        'jumlah_salah',
        'jumlah_tidak_dijawab',
        'waktu_mulai',
        'waktu_selesai',
        'status'
    ];
    
    protected $casts = [
        'nilai_total' => 'float',
        'jumlah_benar' => 'integer',
        'jumlah_salah' => 'integer',
        'jumlah_tidak_dijawab' => 'integer',
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];
    
    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'tugas_id');
    }
    
    public function kuis()
    {
        return $this->belongsTo(Kuis::class, 'kuis_id');
    }
    
    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }
    
    public function jawabanSiswa()
    {
        return $this->hasMany(JawabanSiswaKuis::class, 'siswa_id', 'siswa_id')
                    ->where('kuis_id', $this->kuis_id);
    }
}