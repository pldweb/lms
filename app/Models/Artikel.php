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
        'ringkasan',
        'isi',
        'gambar',
        'status',
        'tanggal_publish',
        'views'
    ];

    protected $casts = [
        'tanggal_publish' => 'datetime',
        'views' => 'integer'
    ];

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
        return $query->where('status', 'publish');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }
}
