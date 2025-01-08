<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagsTableSeeder extends Seeder
{
    public function run()
    {
        $tags = ['Laravel', 'PHP', 'JavaScript', 'HTML', 'CSS', 'Vue.js', 'React', 'Programming'];
        
        foreach ($tags as $tag) {
            Tag::create(['name' => $tag]);
        }
    }
}
