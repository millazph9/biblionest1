<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;

class BookSeeder extends Seeder
{
    public function run()
    {
        // Liste des catégories
        $categories = [
            'Roman' => Category::firstOrCreate(['name' => 'Roman']),
            'Science' => Category::firstOrCreate(['name' => 'Science']),
            'Histoire' => Category::firstOrCreate(['name' => 'Histoire']),
            'Fantasy' => Category::firstOrCreate(['name' => 'Fantasy']),
        ];

        // Liste des livres avec leurs catégories
        $books = [
            ['title' => "L'Alchimiste", 'author' => 'Paulo Coelho', 'category' => 'Roman', 'published_year' => 1988, 'isbn' => '9780062315007'],
            ['title' => "Le Petit Prince", 'author' => 'Antoine de Saint-Exupéry', 'category' => 'Roman', 'published_year' => 1943, 'isbn' => '9782070612758'],
            ['title' => "Une Brève Histoire du Temps", 'author' => 'Stephen Hawking', 'category' => 'Science', 'published_year' => 1988, 'isbn' => '9780553380163'],
            ['title' => "Sapiens", 'author' => 'Yuval Noah Harari', 'category' => 'Histoire', 'published_year' => 2011, 'isbn' => '9780062316097'],
            ['title' => "Le Seigneur des Anneaux", 'author' => 'J.R.R. Tolkien', 'category' => 'Fantasy', 'published_year' => 1954, 'isbn' => '9780544003415'],
            ['title' => "Harry Potter", 'author' => 'Mcdowell', 'category' => 'Fantasy', 'published_year' => 1944, 'isbn' => '8730748012411'],

        ];

        // Insérer les livres en leur attribuant la bonne catégorie
        foreach ($books as $bookData) {
            Book::create([
                'title' => $bookData['title'],
                'author' => $bookData['author'],
                'category_id' => $categories[$bookData['category']]->id,
                'published_year' => $bookData['published_year'],
                'isbn' => $bookData['isbn'],
                'copies_available' => rand(1, 10),
            ]);
        }
    }
}
