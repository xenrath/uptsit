<?php

namespace Database\Seeders;

use App\Models\Tupoksi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TupoksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tupoksis = [
            [
                'nama' => 'Staf Webmaster',
                'deskripsi' => 'Merancang dan pengembang website resmi universitas, layanan kotak pos elektronik (email), layanan subdomain bagi unit di lingkungan universitas, pelayanan dan perawatan server universitas',
                'icon' => 'ti-settings',
                'file' => 'tupoksi/Webmaster.pdf'
            ],
            [
                'nama' => 'Staf Jaringan Komputer dan Umum',
                'deskripsi' => 'Monitoring, pemeliharaan dan pengaplikasian perangkat keras jaringan komputer antar unit kerja di dalam universitas serta melaksanakan administrasi penggunaan jaringan komputer di lingkungan universitas',
                'icon' => 'ti-rss-alt',
                'file' => 'tupoksi/Jarkom.pdf'
            ],
            [
                'nama' => 'Staf Programmer',
                'deskripsi' => 'Monitoring, pemeliharaan dan pengaplikasian perangkat keras jaringan komputer antar unit kerja di dalam universitas serta melaksanakan administrasi penggunaan jaringan komputer di lingkungan universitas',
                'icon' => 'ti-desktop',
                'file' => 'tupoksi/Programmer.pdf'
            ],
            [
                'nama' => 'Staf IT Support',
                'deskripsi' => 'Monitoring, perawatan dan pemeliharaan serta instalasi perangkat komputer di lingkungan universitas',
                'icon' => 'ti-user',
                'file' => 'tupoksi/Support.pdf'
            ],
        ];

        Tupoksi::insert($tupoksis);
    }
}
