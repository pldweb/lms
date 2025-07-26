<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'guru_id',
        'nama_kelas',
        'kode_kelas',
        'deskripsi',
        'jenjang',
        'tahun_ajaran',
        'semester',
    ];

    /**
     * Mendapatkan guru yang mengajar kelas ini.
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    /**
     * Mendapatkan semua siswa di kelas ini.
     */
    public function siswa(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'keanggotaan_kelas', 'kelas_id', 'siswa_id');
    }
    
    /**
     * Mendapatkan semua materi di kelas ini.
     */
    public function materi(): HasMany
    {
        return $this->hasMany(MateriKelas::class, 'kelas_id');
    }
    
    /**
     * Mendapatkan semua tugas di kelas ini.
     */
    public function tugas(): HasMany
    {
        return $this->hasMany(Tugas::class, 'kelas_id');
    }

    /**
     * Mendapatkan semua data kehadiran di kelas ini.
     */
    public function kehadiran(): HasMany
    {
        return $this->hasMany(Kehadiran::class, 'kelas_id');
    }
}