<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Khoirul Anam',
            'username' => 'superadmin',
            'email' => 'khoirulanam4580@gmail.com',
            'password' => bcrypt("superadmin")
        ]);
    }
}