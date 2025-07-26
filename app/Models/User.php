<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal.
     * Sesuaikan dengan kolom di tabel 'users' Anda.
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'nama_lengkap',
        'role_id',
        'foto_profile',
        'alamat',
    ];

    /**
     * Atribut yang harus disembunyikan.
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Mendapatkan peran dari pengguna.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Mendapatkan kelas yang diajar oleh pengguna (jika dia seorang guru).
     */
    public function kelasDiajar(): HasMany
    {
        return $this->hasMany(Kelas::class, 'guru_id');
    }

    /**
     * Mendapatkan kelas yang diikuti oleh pengguna (jika dia seorang siswa).
     */
    public function kelasDiikuti(): BelongsToMany
    {
        return $this->belongsToMany(Kelas::class, 'keanggotaan_kelas', 'siswa_id', 'kelas_id');
    }
    
    /**
     * Mendapatkan wali dari pengguna (jika dia seorang siswa).
     */
    public function wali(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'wali_siswa', 'siswa_id', 'wali_id');
    }

    /**
     * Mendapatkan anak dari pengguna (jika dia seorang wali).
     */
    public function anakWali(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'wali_siswa', 'wali_id', 'siswa_id');
    }
    
    /**
     * Mendapatkan semua tugas yang dikumpulkan oleh siswa ini.
     */
    public function pengumpulanTugas(): HasMany
    {
        return $this->hasMany(PengumpulanTugas::class, 'siswa_id');
    }
}