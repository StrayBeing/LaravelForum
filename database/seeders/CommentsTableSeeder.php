<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class CommentsTableSeeder extends Seeder
{
    public function run()
    {
        // Tworzenie 100 komentarzy
        Comment::factory()->count(100)->create([
            'post_id' => Post::all()->random()->id, // Przypisujemy istniejący post
            'user_id' => User::all()->random()->id, // Przypisujemy istniejącego użytkownika
        ]);
    }
}
