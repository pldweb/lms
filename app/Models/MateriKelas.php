<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MateriKelas extends Model
{
    use HasFactory;

    protected $table = 'materi_kelas';

    // Kolom `diunggah_pada` akan diisi otomatis oleh DB
    // Laravel tidak perlu mengelolanya
    const CREATED_AT = null;
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'kelas_id',
        'judul',
        'deskripsi',
        'tipe_materi',
        'path_file', // Sesuai SQL dump Anda
    ];

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}