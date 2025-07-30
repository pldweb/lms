<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * Atribut yang dapat diisi secara massal.
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'nama_lengkap',
        'foto_profile',
        'alamat',
    ];

    /**
     * Atribut yang harus disembunyikan.
     */
    protected $hidden = [
        'password',
    ];

  
    public function kelasDiajar()
    {
        return $this->hasMany(Kelas::class, 'guru_id');
    }

    public function kelasDiikuti()
    {
        return $this->belongsToMany(Kelas::class, 'keanggotaan_kelas', 'siswa_id', 'kelas_id');
    }
    
    public function wali()
    {
        return $this->belongsToMany(User::class, 'wali_siswa', 'siswa_id', 'wali_id');
    }

    public function anakWali()
    {
        return $this->belongsToMany(User::class, 'wali_siswa', 'wali_id', 'siswa_id');
    }

    public function pengumpulanTugas()
    {
        return $this->hasMany(PengumpulanTugas::class, 'siswa_id');
    }
}