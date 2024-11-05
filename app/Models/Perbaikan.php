<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perbaikan extends Model
{
    use HasFactory;

    protected $fillable = [
        'perangkat_id',
        'tanggal',
        'keterangan',
        'foto_sebelum',
        'foto_sesudah',
        'paraf'
    ];

    public function perangkat()
    {
        return $this->belongsTo(Perangkat::class);
    }

    public function detail_perbaikans()
    {
        return $this->hasMany(DetailPerbaikan::class);
    }
}
