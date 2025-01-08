<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = ['General', 'Programming', 'Web Development', 'Database', 'Frameworks'];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
