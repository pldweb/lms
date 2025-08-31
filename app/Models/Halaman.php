<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Halaman extends Model
{
    use HasFactory;

    protected $table = 'halaman';

    protected $fillable = [
        'penulis_id',
        'judul',
        'slug',
        'isi',
        'gambar',
        'status',
        'tanggal_publish',
        'views'
    ];

    protected $casts = [
        'tanggal_publish' => 'datetime',
        'views' => 'integer'
    ];

    public function penulis(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penulis_id');
    }

    public function scopePublish($query)
    {
        return $query->where('status', 'publish')
                    ->where(function($q) {
                        $q->whereNull('tanggal_publish')
                          ->orWhere('tanggal_publish', '<=', now());
                    });
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopePublished($query)
    {
        return $query->where(function($q) {
            $q->where('status', 'publish')
              ->where(function($subQ) {
                  $subQ->whereNull('tanggal_publish')
                       ->orWhere('tanggal_publish', '<=', now());
              });
        });
    }
}
