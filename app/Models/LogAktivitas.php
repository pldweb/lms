<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    protected $table = 'log_aktivitas';
    
    protected $fillable = [
        'aktivitas',
        'waktu',
        'user_agent',
        'ip_address',
        'tipe',
        'created_at',
        'updated_at',
    ];
}
