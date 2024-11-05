<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            IdentitasSeeder::class,
            TupoksiSeeder::class,
            ProdiSeeder::class,
            UnitSeeder::class,
            BagianSeeder::class,
            KaryawanSeeder::class,
            SpesifikasiSeeder::class,
        ]);
    }
}
