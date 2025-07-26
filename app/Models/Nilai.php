<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilai';

    protected $fillable = [
        'pengumpulan_id',
        'penilai_id',
        'skor',
        'umpan_balik',
        'dinilai_pada',
    ];

    public function pengumpulan(): BelongsTo
    {
        return $this->belongsTo(PengumpulanTugas::class, 'pengumpulan_id');
    }

    public function penilai(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penilai_id');
    }
}