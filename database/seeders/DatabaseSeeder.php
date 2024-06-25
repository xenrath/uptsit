<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            UnitSeeder::class,
            VisiMisiSeeder::class,
            TupoksiSeeder::class,
            ProdiSeeder::class,
            SpekBarangSeeder::class,
            SpekStorageSeeder::class,
            SpekRamSeeder::class,
        ]);
    }
}
