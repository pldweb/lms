<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kelurahan extends Model
{
    use HasFactory;

    protected $table = 'kelurahans';

    protected $fillable = [
        'kode',
        'nama',
        'kode_kecamatan',
        'lat',
        'lng',
    ];

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kode_kecamatan', 'kode');
    }
}