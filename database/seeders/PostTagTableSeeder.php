<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Tag;

class PostTagTableSeeder extends Seeder
{
    public function run()
    {
        $posts = Post::all();
        $tags = Tag::all();

        foreach ($posts as $post) {
            $post->tags()->attach($tags->random(rand(1, 3))->pluck('id')->toArray());
        }
    }
}
