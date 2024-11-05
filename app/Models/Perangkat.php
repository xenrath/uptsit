<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perangkat extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'karyawan_id',
        'unit_id',
        'jenis',
        'merek',
        'model',
        'no_seri',
        'ram_tipe',
        'ram_kapasitas',
        'ram_merek',
        'is_ram_tambahan',
        'ram_tambahan_kapasitas',
        'ram_tambahan_merek',
        'storage_tipe',
        'storage_kapasitas',
        'storage_merek',
        'is_storage_tambahan',
        'storage_tambahan_tipe',
        'storage_tambahan_kapasitas',
        'storage_tambahan_merek',
        'psu_kapasitas',
        'psu_merek',
        'heatsink_model',
        'heatsink_merek',
        'monitor_ukuran',
        'monitor_merek',
        'keyboard_merek',
        'mouse_merek',
        'keterangan',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
