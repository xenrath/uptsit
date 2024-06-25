<?php

namespace Database\Seeders;

use App\Models\SpekStorage;
use Illuminate\Database\Seeder;

class SpekStorageSeeder extends Seeder
{
    public function run()
    {
        $spek_storages = [
            [
                'nama' => 'HDD',
                'kategori' => 'tipe',
            ],
            [
                'nama' => 'SSD',
                'kategori' => 'tipe',
            ],
            [
                'nama' => 'Kingston',
                'kategori' => 'merek',
            ],
        ];

        SpekStorage::insert($spek_storages);
    }
}
