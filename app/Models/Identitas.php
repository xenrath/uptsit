<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Identitas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
        'sistem',
        'website',
        'ap',
        'email',
        'telp',
        'visi',
        'misi',
    ];

    protected $casts = [
        'misi' => 'array',
    ];
}
