<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sparepart extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'kategori',
        'tipe',
        'kapasitas',
        'merek',
        'model',
        'jumlah',
        'is_baru',
        'tanggal',
        'garansi',
        'keterangan',
        'bukti',
        'foto'
    ];
}
