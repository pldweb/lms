<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'description'];

    // Relasi One-to-Many dengan Users
    public function users()
    {
        return $this->hasMany(User::class);
    }
}