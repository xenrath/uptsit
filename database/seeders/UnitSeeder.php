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
            'deskripsi' => 'Unit Sistem Informasi dan Teknologi merupakan unit pelaksanaan teknis dibidang Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nihil blanditiis dicta fuga laborum aspernatur quo itaque tempore similique rem mollitia beatae inventore fugit aliquid perferendis exercitationem sint, excepturi odio corrupti.',
            'sistem' => '30',
            'website' => '20',
            'ap' => '70',
            'email' => 'it@bhamada@gmail.com',
            'telp' => '(+123)4567',
        ];

        Unit::create($unit);
    }
}
