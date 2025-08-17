<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'mata_pelajaran';

    protected $fillable = [
        'nama',
        'kode',
        'deskripsi',
        'jenjang',
        'semester',
        'sks',
        'urutan',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'sks' => 'integer',
        'semester' => 'integer',
        'urutan' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke tabel kelas
     */
    public function kelas(): HasMany
    {
        return $this->hasMany(Kelas::class, 'mata_pelajaran_id');
    }

    /**
     * Scope untuk mata pelajaran aktif
     */
    public function scopeActive($query)
    {
        return $query->where('aktif', true);
    }

    /**
     * Scope berdasarkan jenjang
     */
    public function scopeByJenjang($query, $jenjang)
    {
        return $query->where('jenjang', $jenjang);
    }

    /**
     * Scope berdasarkan semester
     */
    public function scopeBySemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }

    /**
     * Generate kode mata pelajaran otomatis
     */
    public static function generateKode($prefix = null)
    {
        $prefix = $prefix ?: 'MP';
        $lastRecord = self::where('kode', 'LIKE', $prefix . '%')
                          ->orderBy('kode', 'desc')
                          ->first();
        
        if ($lastRecord) {
            $lastNumber = (int) substr($lastRecord->kode, strlen($prefix));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Get label jenjang dan semester
     */
    public function getJenjangSemesterAttribute()
    {
        if ($this->jenjang && $this->semester) {
            return $this->jenjang . ' Semester ' . $this->semester;
        }
        return $this->jenjang ?: 'Semua Jenjang';
    }
}
