<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'telp' => '087738793425',
                'password' => bcrypt('bhamada'),
                'nama' => 'Admin IT',
                'foto' => null,
                'bagian' => 'admin',
                'is_cbt' => false,
                'role' => 'admin',
            ],
            [
                'telp' => '085642970075',
                'password' => bcrypt('bhamada'),
                'nama' => 'M. Qowam Assidiqy',
                'foto' => 'user/qowam.jpg',
                'bagian' => 'programmer',
                'is_cbt' => false,
                'role' => 'user',
            ],
            [
                'telp' => '08562651518',
                'password' => bcrypt('bhamada'),
                'nama' => 'Abdul Mutholib',
                'foto' => 'user/tholib.jpg',
                'bagian' => 'jaringan',
                'is_cbt' => false,
                'role' => 'user',
            ],
            [
                'telp' => '082323679226',
                'password' => bcrypt('bhamada'),
                'nama' => 'Masruhin',
                'foto' => 'user/masruhin.jpg',
                'bagian' => 'support',
                'is_cbt' => true,
                'role' => 'user',
            ],
            [
                'telp' => '085328481969',
                'password' => bcrypt('bhamada'),
                'nama' => 'Saiful Labib Marzuqi',
                'foto' => 'user/labib.jpg',
                'bagian' => 'programmer',
                'is_cbt' => false,
                'role' => 'user',
            ],
        ];

        User::insert($users);
    }
}
