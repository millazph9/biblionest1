<?php 

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all(); // Récupérer toutes les catégories

        // Filtrer les livres selon la catégorie sélectionnée
        $books = Book::with('category')
            ->when($request->category_id, function ($query, $category_id) {
                return $query->where('category_id', $category_id);
            })
            ->get();

        return view('books.index', compact('books', 'categories'));
    }
}
