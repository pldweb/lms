<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class KehadiranPegawai extends Model
{
    use HasFactory;

    protected $table = 'kehadiran_pegawai';

    protected $fillable = [
        'pegawai_id',
        'tanggal',
        'status',
        'jam_masuk',
        'jam_keluar',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime',
        'jam_keluar' => 'datetime',
    ];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pegawai_id');
    }

    public function scopeRentangTanggal($query, $mulai, $selesai)
    {
        return $query->whereBetween('tanggal', [$mulai, $selesai]);
    }

    public function scopeHariIni($query)
    {
        return $query->where('tanggal', Carbon::today());
    }

    public function scopeMingguIni($query)
    {
        return $query->whereBetween('tanggal', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ]);
    }

    public function scopeBulanIni($query)
    {
        return $query->whereBetween('tanggal', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth()
        ]);
    }

    public static function getStatistikKehadiran($mulai = null, $selesai = null)
    {
        $mulai = $mulai ?: Carbon::now()->subDays(6);
        $selesai = $selesai ?: Carbon::now();

        $rentang = Carbon::parse($mulai)->daysUntil($selesai);
        $tanggal = [];
        $hadir = [];
        $izin = [];
        $sakit = [];
        $tanpa_keterangan = [];

        foreach ($rentang as $hari) {
            $tanggal[] = $hari->format('D');
            
            // Hitung total pegawai (guru)
            $totalPegawai = User::whereHas('roles', function($query) {
                $query->where('name', 'Guru');
            })->count();
            
            // Hitung kehadiran per status
            $kehadiran = self::where('tanggal', $hari->format('Y-m-d'))
                ->selectRaw('status, count(*) as jumlah')
                ->groupBy('status')
                ->pluck('jumlah', 'status')
                ->toArray();
            
            $hadir[] = isset($kehadiran['hadir']) ? ($kehadiran['hadir'] / $totalPegawai) * 100 : 0;
            $izin[] = isset($kehadiran['izin']) ? ($kehadiran['izin'] / $totalPegawai) * 100 : 0;
            $sakit[] = isset($kehadiran['sakit']) ? ($kehadiran['sakit'] / $totalPegawai) * 100 : 0;
            $tanpa_keterangan[] = isset($kehadiran['tanpa_keterangan']) ? 
                ($kehadiran['tanpa_keterangan'] / $totalPegawai) * 100 : 
                ($totalPegawai - 
                    (($kehadiran['hadir'] ?? 0) + ($kehadiran['izin'] ?? 0) + ($kehadiran['sakit'] ?? 0))
                ) / $totalPegawai * 100;
        }

        return [
            'tanggal' => $tanggal,
            'hadir' => $hadir,
            'izin' => $izin,
            'sakit' => $sakit,
            'tanpa_keterangan' => $tanpa_keterangan
        ];
    }
}