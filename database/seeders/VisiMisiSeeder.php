<?php

namespace Database\Seeders;

use App\Models\Visimisi;
use Illuminate\Database\Seeder;

class VisiMisiSeeder extends Seeder
{
    public function run()
    {
        $visimisi = [
            'visi' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores deleniti quo error tempore iure. Non iure deserunt excepturi vitae odio magnam dolore ipsum asperiores, rerum impedit neque architecto sint voluptates!',
            'misi' => 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsa doloribus porro exercitationem suscipit delectus aperiam sequi, minima ipsam asperiores voluptas eveniet soluta odit! In quo molestiae natus a error quas quisquam explicabo incidunt nisi ea est itaque adipisci tempore voluptatum ratione consectetur nam, dignissimos dolorem, provident autem! Reprehenderit, blanditiis provident.'
        ];

        Visimisi::create($visimisi);
    }
}
