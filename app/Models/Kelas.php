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
        'tahun_ajaran_id',
        'mata_pelajaran_id',
        'nama_kelas',
        'kode_kelas',
        'deskripsi',
        'jenjang',
        'tingkat',
        'tahun_ajaran',
        'semester',
        'kapasitas_siswa',
        'status',
    ];

    protected $casts = [
        'kapasitas_siswa' => 'integer',
        'tingkat' => 'integer',
        'semester' => 'integer',
    ];

    /**
     * Relasi ke User (Guru)
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
    
    /**
     * Relasi many-to-many ke User (Guru) melalui tabel pengajar
     */
    public function pengajar(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'pengajar', 'kelas_id', 'guru_id');
    }

    /**
     * Relasi ke TahunAjaran
     */
    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }

    /**
     * Relasi ke MataPelajaran
     */
    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }

    /**
     * Relasi many-to-many ke User (Siswa)
     */
    public function siswa(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'keanggotaan_kelas', 'kelas_id', 'siswa_id');
    }
    
    /**
     * Relasi ke MateriKelas
     */
    public function materi(): HasMany
    {
        return $this->hasMany(MateriKelas::class, 'kelas_id');
    }
    
    /**
     * Relasi ke Tugas
     */
    public function tugas(): HasMany
    {
        return $this->hasMany(Tugas::class, 'kelas_id');
    }

    /**
     * Relasi ke Kehadiran
     */
    public function kehadiran(): HasMany
    {
        return $this->hasMany(Kehadiran::class, 'kelas_id');
    }

    /**
     * Scope untuk kelas aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope berdasarkan tahun ajaran
     */
    public function scopeByTahunAjaran($query, $tahunAjaranId)
    {
        return $query->where('tahun_ajaran_id', $tahunAjaranId);
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
     * Get jumlah siswa terdaftar
     */
    public function getJumlahSiswaAttribute()
    {
        return $this->siswa()->count();
    }

    /**
     * Get sisa kapasitas
     */
    public function getSisaKapasitasAttribute()
    {
        return $this->kapasitas_siswa - $this->jumlah_siswa;
    }

    /**
     * Check apakah kelas penuh
     */
    public function isPenuh()
    {
        return $this->jumlah_siswa >= $this->kapasitas_siswa;
    }

    /**
     * Generate kode kelas otomatis
     */
    public static function generateKodeKelas($mataPelajaranKode, $tingkat, $urutan = 1)
    {
        return $mataPelajaranKode . '-' . $tingkat . '-' . str_pad($urutan, 2, '0', STR_PAD_LEFT);
    }
}