<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;
    
    // Sesuaikan dengan nama tabel dari SQL dump Anda
    protected $table = 'role'; 
    
    public $timestamps = false;

    protected $fillable = [
        'nama_peran',
    ];

    /**
     * Mendapatkan semua pengguna dengan peran ini.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'role_id');
    }
}