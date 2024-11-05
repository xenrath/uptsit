<?php

namespace Database\Seeders;

use App\Models\Spesifikasi;
use Illuminate\Database\Seeder;

class SpesifikasiSeeder extends Seeder
{
    public function run()
    {
        $spesifikasis = [
            [
                'kategori' => 'motherboard',
                'grup' => 'merek',
                'keterangan' => 'Asus',
            ],
            [
                'kategori' => 'motherboard',
                'grup' => 'merek',
                'keterangan' => 'MSI',
            ],
            [
                'kategori' => 'prosesor',
                'grup' => 'model',
                'keterangan' => 'Intel Core i3',
            ],
            [
                'kategori' => 'prosesor',
                'grup' => 'model',
                'keterangan' => 'Intel Core i5',
            ],
            [
                'kategori' => 'prosesor',
                'grup' => 'model',
                'keterangan' => 'Intel Core i7',
            ],
            [
                'kategori' => 'ram',
                'grup' => 'tipe',
                'keterangan' => 'DDR1',
            ],
            [
                'kategori' => 'ram',
                'grup' => 'tipe',
                'keterangan' => 'DDR2',
            ],
            [
                'kategori' => 'ram',
                'grup' => 'tipe',
                'keterangan' => 'DDR3',
            ],
            [
                'kategori' => 'ram',
                'grup' => 'tipe',
                'keterangan' => 'DDR4',
            ],
            [
                'kategori' => 'ram',
                'grup' => 'merek',
                'keterangan' => 'Kingstone',
            ],
            [
                'kategori' => 'ram',
                'grup' => 'merek',
                'keterangan' => 'Sandisk',
            ],
            [
                'kategori' => 'ram',
                'grup' => 'kapasitas',
                'keterangan' => '1',
            ],
            [
                'kategori' => 'ram',
                'grup' => 'kapasitas',
                'keterangan' => '2',
            ],
            [
                'kategori' => 'ram',
                'grup' => 'kapasitas',
                'keterangan' => '4',
            ],
            [
                'kategori' => 'storage',
                'grup' => 'merek',
                'keterangan' => 'Kingstone',
            ],
            [
                'kategori' => 'storage',
                'grup' => 'merek',
                'keterangan' => 'Sandisk',
            ],
            [
                'kategori' => 'storage',
                'grup' => 'kapasitas',
                'keterangan' => '128',
            ],
            [
                'kategori' => 'storage',
                'grup' => 'kapasitas',
                'keterangan' => '256',
            ],
            [
                'kategori' => 'storage',
                'grup' => 'kapasitas',
                'keterangan' => '512',
            ],
            [
                'kategori' => 'storage',
                'grup' => 'kapasitas',
                'keterangan' => '1024',
            ],
        ];

        Spesifikasi::insert($spesifikasis);
    }
}
