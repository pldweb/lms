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
        'youtube_url',
        'youtube_thumbnail',
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

    public function scopeVideo($query)
    {
        return $query->where('tipe', 'video');
    }

    // Get YouTube video ID from URL
    public function getYoutubeIdAttribute()
    {
        if (!$this->youtube_url) {
            return null;
        }

        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $this->youtube_url, $match);
        return isset($match[1]) ? $match[1] : null;
    }

    // Get YouTube thumbnail URL
    public function getYoutubeThumbnailUrlAttribute()
    {
        if ($this->youtube_id) {
            return "https://img.youtube.com/vi/{$this->youtube_id}/maxresdefault.jpg";
        }
        return $this->youtube_thumbnail;
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
