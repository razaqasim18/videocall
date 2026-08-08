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
        User::updateOrCreate(
            ['email' => 'user@user.com'],
            [
                'name'              => 'user',
                'password'          => Hash::make('user'),
                'email_verified_at' => now(),
                'profile_image'     => null,
                'fcm_token'         => null,
                'coins'             => 0,
                'is_online'         => false,
                'is_blocked'        => false,
                'is_verified'       => true,
            ]
        );
    }
}
