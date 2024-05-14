<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanCbt extends Model
{
    use HasFactory;

    protected $fillable = [
        'keperluan',
        'nama',
        'prodi_id',
        'tanggal_awal',
        'tanggal_akhir',
        'jam_awal',
        'jam_akhir',
        'items',
        'jumlahs',
        'keterangan',
        'pj',
        'telp',
        'status'
    ];

    protected $casts = [
        'items' => 'array',
        'jumlahs' => 'array',
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }
}
