<?php

namespace Database\Seeders;

use App\Models\Identitas;
use Illuminate\Database\Seeder;

class IdentitasSeeder extends Seeder
{
    public function run()
    {
        $identitas = [
            'nama' => 'Unit Sistem Informasi dan Teknologi',
            'deskripsi' => 'Unit Sistem Informasi dan Teknologi (SIT) merupakan unit pelaksanaan teknis universitas yang peran penting dalam menyediakan dan mengelola infrastruktur teknologi yang mendukung seluruh kegiatan akademik dan administratif.',
            'sistem' => '30',
            'website' => '20',
            'ap' => '70',
            'email' => 'it@bhamada.com',
            'telp' => '+62 877-3879-3425',
            'visi' => 'Menjadi penyedia layanan teknologi informasi dan komunikasi yang handal dan inovatif, mendukung kemajuan akademik, penelitian, dan administrasi di universitas.',
            'misi' => [
                'Mengelola jaringan dan sistem IT yang handal dan terlindungi untuk mendukung kegiatan kampus.',
                'Menyediakan alat dan platform teknologi untuk memfasilitasi pembelajaran dan penelitian yang efektif.',
                'Menyediakan bantuan teknis cepat dan efisien bagi seluruh sivitas akademika.',
                'Mengadopsi teknologi terbaru untuk meningkatkan efisiensi dan kualitas layanan di universitas.'
            ]
        ];

        Identitas::create($identitas);
    }
}
