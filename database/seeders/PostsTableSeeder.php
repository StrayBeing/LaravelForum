<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;

class PostsTableSeeder extends Seeder
{
    public function run()
    {
        // Upewnij się, że masz kategorie w bazie
        $categories = Category::factory()->count(5)->create();

        // Pobierz wszystkich użytkowników
        $users = User::all();

        // Twórz posty i przypisz je do losowych użytkowników oraz kategorii
        Post::factory()->count(50)->create([
            'user_id' => fn() => $users->random()->id, // Losowy użytkownik
            'category_id' => fn() => $categories->random()->id, // Losowa kategoria
        ]);
    }
}
