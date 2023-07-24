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
                'email' => 'admin',
                'password' => bcrypt('admin'),
                'nama' => 'Admin',
                'jabatan' => null,
                'role' => 'admin'
            ]
        ];

        User::insert($users);
    }
}
