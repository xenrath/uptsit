<?php

namespace Database\Seeders;

use App\Models\Anggota;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $anggotas = [
            [
                'nama' => 'M. Qowam Assidiqy',
                'foto' => null,
                'telp' => '85642970075'
            ],
            [
                'nama' => 'Abdul Mutholib',
                'foto' => null,
                'telp' => '8562651518'
            ],
            [
                'nama' => 'Masruhin',
                'foto' => null,
                'telp' => '82323679226'
            ],
            [
                'nama' => 'Saiful Labib Marzuqi',
                'foto' => null,
                'telp' => '85328481969'
            ],
        ];

        Anggota::insert($anggotas);
    }
}
