<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Galeri extends Model
{
    use HasFactory;

    protected $table = 'galeri';

    protected $fillable = [
        'kategori_galeri_id',
        'judul',
        'deskripsi',
        'tipe',
        'file_path',
        'tanggal_foto',
        'fotografer',
        'urutan',
        'status'
    ];

    protected $casts = [
        'tanggal_foto' => 'date',
        'urutan' => 'integer'
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriGaleri::class, 'kategori_galeri_id');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeFoto($query)
    {
        return $query->where('tipe', 'foto');
    }

    // Get file URL for photos
    public function getFileUrlAttribute()
    {
        if ($this->file_path) {
            return asset('img/galeri/' . $this->file_path);
        }
        return null;
    }
}
