<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hosting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kategori',
        'nama_instansi',
        'nama_kepala',
        'nipy_kepala',
        'jabatan_kepala',
        'nama_admin_1',
        'nipy_admin_1',
        'jabatan_admin_1',
        'email_admin_1',
        'telp_admin_1',
        'nama_admin_2',
        'nipy_admin_2',
        'jabatan_admin_2',
        'email_admin_2',
        'telp_admin_2',
        'deskripsi',
        'sub_domain',
        'ip_address',
        'ftp',
        'tanggal_awal',
        'tanggal_pengerjaan',
        'tanggal_akhir',
        'status'
    ];

    public function detail_hostings()
    {
        return $this->hasMany(DetailHosting::class);
    }
}
