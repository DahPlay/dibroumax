<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name'      => 'User',
                'email'     => 'user@user.com',
                'login'     => 'user',
                'password'  => Hash::make('user'),
                'access_id' => 1
            ],
            [
                'name'      => 'Admin',
                'email'     => 'alexandre.areds@gmail.com',
                'login'     => 'admin',
                'password'  => Hash::make('admin'),
                'access_id' => 2
            ],
            [
                'name'      => 'Developer',
                'email'     => 'contato@tiagoneitzke.com.br',
                'login'     => 'developer',
                'password'  => Hash::make('developer'),
                'access_id' => 3
            ]
        ]);
    }
}
