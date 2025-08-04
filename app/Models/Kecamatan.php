<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = 'kecamatans';

    protected $fillable = [
        'kode',
        'nama',
        'kode_kabupaten',
        'lat',
        'lng',
    ];

 
    public function kabupaten(): BelongsTo
    {
        return $this->belongsTo(Kabupaten::class, 'kode_kabupaten', 'kode');
    }

    public function kelurahans(): HasMany
    {
        return $this->hasMany(Kelurahan::class, 'kode_kecamatan', 'kode');
    }
}