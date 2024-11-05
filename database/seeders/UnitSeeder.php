<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run()
    {
        $units = [
            [
                'nama' => 'Rektorat'
            ],
            [
                'nama' => 'BAUK'
            ],
            [
                'nama' => 'TU'
            ],
            [
                'nama' => 'Personalia'
            ],
            [
                'nama' => 'Keuangan'
            ],
            [
                'nama' => 'Sarpras'
            ],
            [
                'nama' => 'BAAK'
            ],
            [
                'nama' => 'Kemahasiswaan'
            ],
            [
                'nama' => 'Evaluasi'
            ],
            [
                'nama' => 'Perencanaan'
            ],
            [
                'nama' => 'LPM'
            ],
            [
                'nama' => 'LP2M'
            ],
            [
                'nama' => 'IT'
            ],
            [
                'nama' => 'PMB'
            ],
            [
                'nama' => 'Humas'
            ],
            [
                'nama' => 'Perpustakaan'
            ],
            [
                'nama' => 'Laboratorium'
            ],
            [
                'nama' => 'FIKES'
            ],
            [
                'nama' => 'Prodi S1 Kep'
            ],
            [
                'nama' => 'Prodi S1 Far'
            ],
            [
                'nama' => 'Prodi D4 K3'
            ],
            [
                'nama' => 'Prodi D3 Keb'
            ],
            [
                'nama' => 'Prodi D3 Kep'
            ],
            [
                'nama' => 'FEB'
            ],
            [
                'nama' => 'Prodi S1 BD'
            ],
            [
                'nama' => 'Prodi S1 KWU'
            ],
            [
                'nama' => 'FIKOM'
            ],
            [
                'nama' => 'Prodi S1 Info'
            ],
            [
                'nama' => 'Yayasan'
            ],
        ];

        Unit::insert($units);
    }
}
