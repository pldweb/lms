<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformasiSekolah extends Model
{
    protected $table = 'informasi_sekolah';
    
    protected $fillable = [
        'nama_sekolah',
        'alamat',
        'nomor_telepon',
        'email',
        'nomor_handphone',
        'latitude',
        'longitude',
        'tagline',
        'logo',
        'favicon',
        'logo_invert',
    ];
}
