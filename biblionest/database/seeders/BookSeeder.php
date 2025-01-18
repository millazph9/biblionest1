<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Roman', 'Science', 'Histoire', 'Informatique'
        ];

        foreach ($categories as $categoryName) {
            // catégorie est bien créée
            $category = Category::firstOrCreate(['name' => $categoryName]);

            Book::create([
                'title' => 'Exemple de Livre ' . $categoryName,
                'author' => 'Auteur Exemple',
                'category_id' => $category->id,
                'published_year' => rand(1990, 2023),
                'isbn' => Str::random(10),
                'copies_available' => rand(1, 10),
            ]);
        }
    }
}
