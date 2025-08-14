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
        'kode',
        'nama',
        'deskripsi',
        'kategori',
        'jenjang',
        'tingkat',
        'bobot_sks',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'bobot_sks' => 'integer',
        'tingkat' => 'integer',
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
        return $query->where('is_active', true);
    }

    /**
     * Scope berdasarkan jenjang
     */
    public function scopeByJenjang($query, $jenjang)
    {
        return $query->where('jenjang', $jenjang);
    }

    /**
     * Scope berdasarkan tingkat
     */
    public function scopeByTingkat($query, $tingkat)
    {
        return $query->where('tingkat', $tingkat);
    }

    /**
     * Scope berdasarkan kategori
     */
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
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
     * Get label jenjang dan tingkat
     */
    public function getJenjangTingkatAttribute()
    {
        if ($this->jenjang && $this->tingkat) {
            return $this->jenjang . ' Kelas ' . $this->tingkat;
        }
        return $this->jenjang ?: 'Semua Jenjang';
    }
}
