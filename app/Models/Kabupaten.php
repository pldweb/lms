<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kabupaten extends Model
{
    use HasFactory;

    protected $table = 'kabupatens';

    protected $fillable = [
        'kode',
        'nama',
        'kode_provinsi',
        'lat',
        'lng',
    ];

   
    public function provinsi(): BelongsTo
    {
        return $this->belongsTo(Provinsi::class, 'kode_provinsi', 'kode');
    }

    public function kecamatans(): HasMany
    {
        return $this->hasMany(Kecamatan::class, 'kode_kabupaten', 'kode');
    }
}