<?php

namespace Database\Seeders;

use App\Models\SpekBarang;
use Illuminate\Database\Seeder;

class SpekBarangSeeder extends Seeder
{
    public function run()
    {
        $spek_barangs = [
            [
                'nama' => 'PC',
                'kategori' => 'jenis',
            ],
            [
                'nama' => 'Laptop',
                'kategori' => 'jenis',
            ],
            [
                'nama' => 'Asus',
                'kategori' => 'merek',
            ],
            [
                'nama' => 'Lenovo',
                'kategori' => 'merek',
            ],
            [
                'nama' => 'Intel Core i3',
                'kategori' => 'model',
            ],
            [
                'nama' => 'Intel Core i5',
                'kategori' => 'model',
            ],
            [
                'nama' => 'Intel Core i7',
                'kategori' => 'model',
            ],
        ];

        SpekBarang::insert($spek_barangs);
    }
}
