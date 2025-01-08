<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->paragraph,
            'post_id' => Post::factory(), // Losowo przypisany post
            'user_id' => User::factory(), // Losowo przypisany użytkownik
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
