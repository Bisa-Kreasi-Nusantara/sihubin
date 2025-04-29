<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                "roles_id"  => 1,
                "fullname"  => "administrator",
                "email"     => "administrator@sihubin.com",
                "password"     => Hash::make('1234567890'),
            ],
            [
                "roles_id"  => 2,
                "fullname"  => "teacher",
                "email"     => "teacher@sihubin.com",
                "password"     => Hash::make('1234567890'),
            ],
            [
                "roles_id"  => 3,
                "fullname"  => "student",
                "email"     => "student@sihubin.com",
                "password"     => Hash::make('1234567890'),
            ],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}
