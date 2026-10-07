<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Ali Khan',
            'Ahmed Raza',
            'Usman Tariq',
            'Bilal Ahmad',
            'Hamza Malik',
            'Sara Ali',
            'Ayesha Noor',
            'Fatima Zahra',
            'Hina Shah',
            'Zainab Iqbal',
            'Hassan Butt',
            'Imran Sheikh',
            'Kamran Akram',
            'Daniyal Chaudhry',
            'Faisal Mehmood',
            'Maryam Aslam',
            'Noor Fatima',
            'Sana Javed',
            'Areeba Khalid',
            'Laiba Rehman',
            'Abdullah Khan',
            'Talha Ahmed',
            'Saad Malik',
            'Muneeb Raza',
            'Huzaifa Tariq',
            'Arham Shah',
            'Rayyan Ali',
            'Maham Noor',
            'Anaya Fatima',
            'Iqra Aslam',
            'Saim Sheikh',
            'Waleed Ahmad',
            'Owais Butt',
            'Shahzaib Khan',
            'Taha Javed',
            'Yasir Mehmood',
            'Mariam Khan',
            'Alina Raza',
            'Eman Zahra',
            'Khadija Noor',
            'Ayan Malik',
            'Adeel Tariq',
            'Sameer Ahmed',
            'Zubair Hassan',
            'Noman Akram',
            'Rohan Shah',
            'Mehwish Ali',
            'Anum Fatima',
            'Kainat Javed',
            'Mahnoor Aslam',
        ];

        foreach ($names as $index => $name) {
            $number = $index + 1;

            User::updateOrCreate(
                ['email' => "user{$number}@user.com"],
                [
                    'name' => $name,
                    'password' => Hash::make('user'),
                    'email_verified_at' => now(),
                    'profile_image' => null,
                    'fcm_token' => null,
                    'coins' => $number * 50,
                    'is_online' => $number % 3 === 0,
                    'is_blocked' => $number === 19,
                    'is_verified' => $number !== 20,
                ]
            );
        }
    }
}
