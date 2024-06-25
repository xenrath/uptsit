<?php

namespace Database\Seeders;

use App\Models\SpekRam;
use Illuminate\Database\Seeder;

class SpekRamSeeder extends Seeder
{
    public function run()
    {
        $spek_rams = [
            [
                'nama' => 'DDR2',
                'kategori' => 'tipe',
            ],
            [
                'nama' => 'DDR3',
                'kategori' => 'tipe',
            ],
            [
                'nama' => 'Kingston',
                'kategori' => 'merek',
            ],
            [
                'nama' => 'Sandisk',
                'kategori' => 'merek',
            ],
        ];

        SpekRam::insert($spek_rams);
    }
}
