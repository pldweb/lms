<?php

namespace App\Models;

// Impor class yang dibutuhkan
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    // Gunakan trait untuk Factory, Notifikasi, dan Spatie Roles
    use HasFactory, Notifiable, HasRoles;
    
     /**
     * * @mixin \Spatie\Permission\Traits\HasRoles
     */

    protected $fillable = [
        'nama',
        'email',
        'password',
        'nama_lengkap',
        'foto_profile',
        'no_hp',
        'alamat',
        'provinsi', // Menyimpan kode provinsi
        'kota',     // Menyimpan kode kabupaten/kota
        'kecamatan',// Menyimpan kode kecamatan
        'kelurahan',// Menyimpan kode kelurahan
        'kodepos',
    ];

    /**
     * Atribut yang harus disembunyikan saat diubah menjadi array atau JSON.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atribut yang tipe datanya harus diubah secara otomatis.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    //================================================
    // RELASI UNTUK FITUR LMS
    //================================================

    public function kelasDiajar(): HasMany
    {
        return $this->hasMany(Kelas::class, 'guru_id');
    }

    public function kelasDiikuti(): BelongsToMany
    {
        return $this->belongsToMany(Kelas::class, 'keanggotaan_kelas', 'siswa_id', 'kelas_id');
    }
    
    public function wali(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'wali_siswa', 'siswa_id', 'wali_id');
    }

    public function anakWali(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'wali_siswa', 'wali_id', 'siswa_id');
    }

    public function pengumpulanTugas(): HasMany
    {
        return $this->hasMany(PengumpulanTugas::class, 'siswa_id');
    }

    //================================================
    // RELASI UNTUK DATA LOKASI
    //================================================

    /**
     * Relasi ke model Provinsi.
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Provinsi::class, 'provinsi', 'kode');
    }

    /**
     * Relasi ke model Kabupaten.
     */
    public function regency(): BelongsTo
    {
        return $this->belongsTo(Kabupaten::class, 'kota', 'kode');
    }

    /**
     * Relasi ke model Kecamatan.
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan', 'kode');
    }

    /**
     * Relasi ke model Kelurahan.
     */
    public function village(): BelongsTo
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan', 'kode');
    }

    //================================================
    // HELPER UNTUK MENAMPILKAN NAMA LOKASI
    //================================================

    public function getProvinsiNama()
    {
        return $this->province?->nama;
    }

    public function getKotaNama()
    {
        return $this->regency?->nama;
    }

    public function getKecamatanNama()
    {
        return $this->district?->nama;
    }

    public function getKelurahanNama()
    {
        return $this->village?->nama;
    }
}