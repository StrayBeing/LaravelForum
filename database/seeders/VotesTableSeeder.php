<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vote;
use App\Models\Post;
use App\Models\User;
use Faker\Factory as Faker;

class VotesTableSeeder extends Seeder
{
    public function run()
    {
        // Instantiate Faker
        $faker = Faker::create();

        // Loop through each post and assign a unique vote for each user
        $posts = Post::all();
        $users = User::all();

        // For each post, create a unique vote for each user
        foreach ($posts as $post) {
            foreach ($users as $user) {
                // Ensure each user only votes once on a post
                Vote::create([
                    'post_id' => $post->id,
                    'user_id' => $user->id,
                    'vote' => $faker->randomElement([1, -1]),
                ]);
            }
        }
    }
}

