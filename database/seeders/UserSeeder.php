<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'josh.alecyan@gmail.com',
        ], [
            'password' => Hash::make('qwerty12'),
            'role' => User::ROLE_ADMIN,
            'email_verified_at' => now(),
            'name' => 'Josh Alekyan',
        ]);
    }
}
