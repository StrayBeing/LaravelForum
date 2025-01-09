<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vote;
use App\Models\Post;
use App\Models\User;

class VotesTableSeeder extends Seeder
{
    public function run()
    {
        // Tworzenie 200 głosów
        Vote::factory()->count(200)->create([
            'post_id' => Post::all()->random()->id, // Przypisujemy istniejący post
            'user_id' => User::all()->random()->id, // Przypisujemy istniejącego użytkownika
        ]);
    }
}
