<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name'              => 'User Satu',
                'email'             => 'user1@example.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('password123'),
                'phone'             => '081234567890',
                'address'           => 'Jl. Mawar No. 1',
                'role'              => 'user',
                'avatar'            => 'users/default-avatar.png',
                'provider'          => 'local',
                'provider_id'       => '',
            ],
            [
                'name'              => 'User Dua',
                'email'             => 'user2@example.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('password123'),
                'phone'             => '081234567891',
                'address'           => 'Jl. Melati No. 2',
                'role'              => 'user',
                'avatar'            => 'users/default-avatar.png',
                'provider'          => 'local',
                'provider_id'       => '',
            ],
            [
                'name'              => 'User Tiga',
                'email'             => 'user3@example.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('password123'),
                'phone'             => '081234567892',
                'address'           => 'Jl. Anggrek No. 3',
                'role'              => 'user',
                'avatar'            => 'users/default-avatar.png',
                'provider'          => 'local',
                'provider_id'       => '',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
