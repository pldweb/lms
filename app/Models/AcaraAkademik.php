<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcaraAkademik extends Model
{
    use HasFactory;

    protected $table = 'acara_akademik';
    
    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'sepanjang_hari',
        'warna_latar',
        'warna_teks',
        'tahun_ajaran_id',
        'tipe',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'sepanjang_hari' => 'boolean',
    ];

    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }

    public function scopeTahunAjaranAktif($query)
    {
        return $query->whereHas('tahunAjaran', function($q) {
            $q->where('status', 'aktif');
        })->orWhereNull('tahun_ajaran_id');
    }

    public function getFormatForCalendar()
    {
        return [
            'title' => $this->judul,
            'start' => $this->tanggal_mulai->format('Y-m-d'),
            'end' => $this->tanggal_selesai ? $this->tanggal_selesai->format('Y-m-d') : null,
            'allDay' => $this->sepanjang_hari,
            'backgroundColor' => $this->warna_latar,
            'borderColor' => $this->warna_latar,
            'textColor' => $this->warna_teks,
            'description' => $this->deskripsi,
        ];
    }
}