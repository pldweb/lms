<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Artikel extends Model
{
    use HasFactory;

    protected $table = 'artikel';

    protected $fillable = [
        'penulis_id',
        'jenis',
        'judul',
        'slug',
        'ringkasan',
        'isi',
        'gambar',
        'status',
        'tanggal_publish',
        'views',
        'kategori_id'
    ];

    protected $casts = [
        'tanggal_publish' => 'datetime',
        'views' => 'integer'
    ];

    public function kategori()
    {
        return $this->hasOne(KategoriArtikel::class, 'id', 'kategori_id');
    }

    public function penulis(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penulis_id');
    }

    public function scopeBerita($query)
    {
        return $query->where('jenis', 'berita');
    }

    public function scopePengumuman($query)
    {
        return $query->where('jenis', 'pengumuman');
    }

    public function scopePublish($query)
    {
        return $query->where('status', 'publish')
                    ->where(function($q) {
                        $q->whereNull('tanggal_publish')
                          ->orWhere('tanggal_publish', '<=', now());
                    });
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled')
                    ->where('tanggal_publish', '>', now());
    }

    public function scopePublished($query)
    {
        return $query->where(function($q) {
            $q->where('status', 'publish')
              ->where(function($subQ) {
                  $subQ->whereNull('tanggal_publish')
                       ->orWhere('tanggal_publish', '<=', now());
              });
        })->orWhere(function($q) {
            $q->where('status', 'scheduled')
              ->where('tanggal_publish', '<=', now());
        });
    }
}
