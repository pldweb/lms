<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'phone_number',
        'address',
        'profile_picture',
        'google_id',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi One-to-Many (Inverse) dengan Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Helper method to check user's role
    public function hasRole($roleName)
    {
        return $this->role && $this->role->name === $roleName;
    }
}