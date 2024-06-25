<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unit = [
            'nama' => 'Unit Sistem Informasi dan Teknologi',
            'deskripsi' => 'Unit Sistem Informasi dan Teknologi (SIT) merupakan unit pelaksanaan teknis universitas yang peran penting dalam menyediakan dan mengelola infrastruktur teknologi yang mendukung seluruh kegiatan akademik dan administratif.',
            'sistem' => '30',
            'website' => '20',
            'ap' => '70',
            'email' => 'it@bhamada.com',
            'telp' => '+62 877-3879-3425',
        ];

        Unit::create($unit);
    }
}
