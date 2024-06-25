<?php

namespace Database\Seeders;

use App\Models\Visimisi;
use Illuminate\Database\Seeder;

class VisiMisiSeeder extends Seeder
{
    public function run()
    {
        $visimisi = [
            'visi' => 'Menjadi penyedia layanan teknologi informasi dan komunikasi yang handal dan inovatif, mendukung kemajuan akademik, penelitian, dan administrasi di universitas.',
            'misi' => [
                'Mengelola jaringan dan sistem IT yang handal dan terlindungi untuk mendukung kegiatan kampus.',
                'Menyediakan alat dan platform teknologi untuk memfasilitasi pembelajaran dan penelitian yang efektif.',
                'Menyediakan bantuan teknis cepat dan efisien bagi seluruh sivitas akademika.',
                'Mengadopsi teknologi terbaru untuk meningkatkan efisiensi dan kualitas layanan di universitas.'
            ]
        ];

        Visimisi::create($visimisi);
    }
}
