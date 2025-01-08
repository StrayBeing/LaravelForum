<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Administrator
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin_password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Moderator
        User::create([
            'name' => 'Moderator User',
            'email' => 'moderator@example.com',
            'password' => Hash::make('moderator_password'),
            'role' => 'moderator',
            'email_verified_at' => now(),
        ]);

        // Regular users
        User::factory()->count(10)->create();
    }
}

