<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perangkat extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',
        'lokasi',
        'unit',
        'karyawan_id',
        'spek_barang_jenis_id',
        'spek_barang_merek_id',
        'no_seri',
        'spek_barang_model_id',
        'spek_storage_tipe_id',
        'storage_kapasitas',
        'spek_storage_merek_id',
        'spek_ram_tipe_id',
        'spek_ram_merek_id',
        'ram_kapasitas',
        'psu_merek',
        'psu_kapasitas',
        'heatsink_merek',
        'heatsink_model',
    ];
}
