<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class LogAktivitas extends Model
{
    use HasFactory;
    
    protected $table = 'log_aktivitas';
    
    protected $fillable = [
        'id',
        'user_id',
        'aktivitas',
        'waktu',
        'user_agent',
        'ip_address',
        'tipe',
        'created_at',
        'updated_at',
    ];
    
    protected $casts = [
        'waktu' => 'datetime',
    ];

    public function __get($key)
    {
        switch ($key) {
            case 'waktu_aktivitas':
                Carbon::setLocale('id');
                $waktu = Carbon::parse($this->waktu)->translatedFormat('l, d F Y H:i:s');
                return $waktu;

            default:
                return parent::__get($key);
        }
    }

    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
