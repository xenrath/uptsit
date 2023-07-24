<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengaduan_id',
        'update',
        'isi',
        'gambar'
    ];

    protected $casts = [
        'gambar' => 'array'
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }
}
