<?php

namespace Database\Factories;

use App\Models\Vote;
use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Losowo przypisany użytkownik
            'post_id' => Post::factory(), // Losowo przypisany post
            'vote' => $this->faker->randomElement([1, -1]), // Losowy głos (1 = upvote, -1 = downvote)
        ];
    }
}
