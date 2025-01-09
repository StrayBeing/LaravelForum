<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoteFactory extends Factory
{
    protected $model = \App\Models\Vote::class;

    public function definition(): array
    {
        return [
            // Use an existing post from the database
            'post_id' => Post::all()->random()->id,
            // Use an existing user from the database
            'user_id' => User::all()->random()->id,
            // Randomly assign upvote or downvote
            'vote' => $this->faker->randomElement([1, -1]),
        ];
    }
}
