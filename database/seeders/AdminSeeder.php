<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'), 
            'phone' => '085740096548',
            'address' => 'Dodogan, Jatimulyo, Dlingo',
            'role' => 'admin',
            'avatar' => 'images/default-avatar.png',
            'provider' => 'local',
            'provider_id' => '12345',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
