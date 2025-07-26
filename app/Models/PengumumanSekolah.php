<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengumumanSekolah extends Model
{
    use HasFactory;

    protected $table = 'pengumuman_sekolah';

    protected $fillable = [
        'pengirim_id',
        'judul',
        'isi',
    ];

    public function pengirim(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengirim_id');
    }
}