<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPerbaikan extends Model
{
    use HasFactory;

    protected $fillable = [
        'perbaikan_id',
        'sparepart_id',
    ];

    public function perbaikan()
    {
        return $this->belongsTo(Perbaikan::class);
    }

    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class);
    }
}
