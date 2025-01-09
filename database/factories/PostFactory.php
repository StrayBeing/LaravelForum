<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory; // Importuj klasę Factory

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'user_id' => User::factory(), // Losowy użytkownik
            'category_id' => Category::factory(), // Losowa kategoria
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
