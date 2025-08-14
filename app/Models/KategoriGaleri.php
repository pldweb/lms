<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class KategoriGaleri extends Model
{
    use HasFactory;

    protected $table = 'kategori_galeri';

    protected $fillable = [
        'nama_kategori',
        'slug',
        'deskripsi',
        'gambar_cover',
        'status',
        'urutan'
    ];

    protected $casts = [
        'urutan' => 'integer'
    ];

    public function galeri(): HasMany
    {
        return $this->hasMany(Galeri::class, 'kategori_galeri_id');
    }

    public function galeriAktif(): HasMany
    {
        return $this->hasMany(Galeri::class, 'kategori_galeri_id')
                    ->where('status', 'aktif')
                    ->orderBy('urutan');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    // Auto generate slug when creating
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->nama_kategori);
            }
        });
    }
}
