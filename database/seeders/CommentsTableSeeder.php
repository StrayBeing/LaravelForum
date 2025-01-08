<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentsTableSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Post::all()->each(function ($post) {
            \App\Models\Comment::factory()->count(rand(1, 10))->create([
                'post_id' => $post->id,
            ]);
        });
    }
}