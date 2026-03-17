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

    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn',
            'published_year' => 'required|integer|min:0|max:2030',
            'category_id' => 'required|exists:categories,id',
            'copies_available' => 'required|integer|min:1',
            'edition' => 'nullable|string|max:255', // Ajout du champ édition
        ]);

        Book::create($validatedData);

        return redirect()->route('books.index')->with('success', 'Livre ajouté avec succès.');
    }


    public function show(Book $book)
    {
        return redirect()->route('books.index');
    }



        public function edit(Book $book)
    {
        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn,' . $book->id,
            'published_year' => 'required|integer|min:0|max:2030',
            'category_id' => 'required|exists:categories,id',
            'copies_available' => 'required|integer|min:1',
            'edition' => 'nullable|string|max:255',
        ]);

        $book->update($validatedData);

        return redirect()->route('books.index')->with('success', 'Livre mis à jour avec succès.');
    }


    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Livre supprimé avec succès.');
    }

    public function exportPDF()
    {
        $books = Book::with('category')->get();
    
        $pdf = Pdf::loadView('exports.books', compact('books'));
    
        return $pdf->download('livres_bibliothèque.pdf'); // ✅ Force le téléchargement du PDF
    }

    //         public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware('can:manage-adherents')->except(['index', 'show']);
    // }


    
}
