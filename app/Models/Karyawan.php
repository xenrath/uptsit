<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'telp',
        'bagian_id'
    ];

    public function bagian()
    {
        return $this->belongsTo(Bagian::class);
    }
}
