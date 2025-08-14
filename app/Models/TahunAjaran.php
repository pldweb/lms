<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $table = 'tahun_ajaran';
    
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'nama',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function kelas(): HasMany
    {
        return $this->hasMany(Kelas::class, 'tahun_ajaran_id');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public static function getAktif()
    {
        return self::where('status', 'aktif')->first();
    }

    public function setAsAktif()
    {
        // Non-aktifkan semua tahun ajaran
        self::where('status', 'aktif')->update(['status' => 'non-aktif']);
        
        // Aktifkan tahun ajaran ini
        $this->update(['status' => 'aktif']);
    }

    public function isBerlangsung()
    {
        $today = now()->toDateString();
        return $this->tanggal_mulai <= $today && $this->tanggal_selesai >= $today;
    }
}
