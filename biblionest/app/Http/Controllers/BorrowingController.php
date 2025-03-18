<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Book;
use App\Models\Adherent;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        $query = Borrowing::with(['book', 'adherent']); // Utilise adherent au lieu de user

        if ($request->filled('adherent_id')) {
            $query->where('adherent_id', $request->adherent_id);
        }

        if ($request->filled('status')) {
            if ($request->status == 'active') {
                $query->whereNull('returned_at');
            } elseif ($request->status == 'late') {
                $query->whereNull('returned_at')->where('due_date', '<', now());
            } elseif ($request->status == 'returned') {
                $query->whereNotNull('returned_at');
            }
        }

        $borrowings = $query->paginate(10);
        $adherents = Adherent::all(); // Récupère tous les adhérents pour les filtres

        return view('borrowings.index', compact('borrowings', 'adherents'));
    }

    public function create()
    {
        $books = Book::where('copies_available', '>', 0)->get();
        $adherents = Adherent::all(); // ✅ On remplace 'users' par 'adherents'

        return view('borrowings.create', compact('books', 'adherents')); // ✅ Passe 'adherents' à la vue
    }


    public function store(Request $request)
    {
        $request->validate([
            'adherent_id' => 'required|exists:adherents,id',
            'book_id' => 'required|exists:books,id',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->copies_available <= 0) {
            return redirect()->back()->with('error', 'Ce livre n\'est plus disponible.');
        }

        Borrowing::create([
            'adherent_id' => $request->adherent_id, // Remplacement user_id → adherent_id
            'book_id' => $book->id,
            'borrowed_at' => now(),
            'due_date' => now()->addDays(14),
        ]);

        $book->decrement('copies_available');

        return redirect()->route('borrowings.index')->with('success', 'Emprunt enregistré avec succès.');
    }

    public function edit(Borrowing $borrowing)
    {
        $adherents = Adherent::all(); // Correction ici
        $books = Book::where('copies_available', '>', 0)->get();

        return view('borrowings.edit', compact('borrowing', 'adherents', 'books'));
    }

    public function update(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'adherent_id' => 'required|exists:adherents,id',
            'book_id' => 'required|exists:books,id',
        ]);

        $borrowing->update([
            'adherent_id' => $request->adherent_id,
            'book_id' => $request->book_id,
        ]);

        return redirect()->route('borrowings.index')->with('success', 'Emprunt mis à jour.');
    }

    public function returnBook(Borrowing $borrowing)
    {
        if ($borrowing->returned_at) {
            return redirect()->route('borrowings.index')->with('error', 'Ce livre a déjà été retourné.');
        }

        $borrowing->update(['returned_at' => now()]);
        $borrowing->book->increment('copies_available');

        return redirect()->route('borrowings.index')->with('success', 'Livre retourné avec succès.');
    }

    public function destroy($id)
    {
        $borrowing = Borrowing::find($id);

        if (!$borrowing) {
            return redirect()->route('borrowings.index')->with('error', 'Emprunt introuvable.');
        }

        $book = Book::find($borrowing->book_id);

        if ($book) {
            $book->increment('copies_available');
        }

        $borrowing->delete();

        return redirect()->route('borrowings.index')->with('success', 'Emprunt supprimé avec succès.');
    }

    //         public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware('can:manage-adherents')->except(['index', 'show']);
    // }

}
