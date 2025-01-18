<?php 

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


class BookController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all(); // Récupérer toutes les catégories

        // Initialiser la requête
        $query = Book::with('category');

        // Filtrer par catégorie
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filtrer par recherche (titre, auteur, ISBN)
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('author', 'like', '%' . $request->search . '%')
                  ->orWhere('isbn', 'like', '%' . $request->search . '%');
            });
        }

        $books = $query->paginate(10);

        return view('books.index', compact('books', 'categories'));

        
    }
    
    public function exportPDF()
    {
        $books = Book::with('category')->get();
    
        $pdf = Pdf::loadView('exports.books', compact('books'));
    
        return $pdf->download('livres_bibliothèque.pdf'); // ✅ Force le téléchargement du PDF
    }
    
}
