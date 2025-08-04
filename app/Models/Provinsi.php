<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provinsi extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     *
     * @var string
     */
    protected $table = 'provinsis';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode',
        'nama',
        'lat',
        'lng',
    ];

    /**
     * Relasi one-to-many ke model Kabupaten.
     * Satu provinsi memiliki banyak kabupaten.
     */
    public function kabupatens(): HasMany
    {
        return $this->hasMany(Kabupaten::class, 'kode_provinsi', 'kode');
    }
}