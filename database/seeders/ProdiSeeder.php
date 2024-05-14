<?php

namespace Database\Seeders;

use App\Models\Prodi;
use Illuminate\Database\Seeder;

class ProdiSeeder extends Seeder
{
    public function run()
    {
        $prodis = [
            [
                'nama' => 'Profesi Ners'
            ],
            [
                'nama' => 'S1 Ilmu Keperawatan'
            ],
            [
                'nama' => 'S1 Farmasi'
            ],
            [
                'nama' => 'D4 K3'
            ],
            [
                'nama' => 'D3 Keperawatan'
            ],
            [
                'nama' => 'D3 Kebidanan'
            ],
            [
                'nama' => 'S1 Kewirausahaan'
            ],
            [
                'nama' => 'S1 Bisnis Digital'
            ],
            [
                'nama' => 'S1 Informatika'
            ],
        ];

        Prodi::insert($prodis);
    }
}
