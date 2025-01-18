<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        $query = Borrowing::with(['user', 'book']);
    
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
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
        $users = User::all();
    
        return view('borrowings.index', compact('borrowings', 'users'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->copies_available <= 0) {
            return redirect()->back()->with('error', 'Ce livre n\'est plus disponible.');
        }

        Borrowing::create([
            'user_id' => $request->user_id,
            'book_id' => $book->id,
            'borrowed_at' => now(),
            'due_date' => now()->addDays(14),
        ]);

        $book->decrement('copies_available');

        return redirect()->route('borrowings.index')->with('success', 'Emprunt enregistré avec succès.');
    }

    public function edit(Borrowing $borrowing)
    {
        $users = User::all();
        $books = Book::where('copies_available', '>', 0)->get();
        return view('borrowings.edit', compact('borrowing', 'users', 'books'));
    }

    public function update(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
        ]);

        $borrowing->update([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
        ]);

        return redirect()->route('borrowings.index')->with('success', 'Emprunt mis à jour.');
    }

    public function destroy($id)
    {
        $borrowing = Borrowing::find($id);
    
        if (!$borrowing) {
            return redirect()->route('borrowings.index')->with('error', 'Emprunt introuvable.');
        }
    
        // Vérifier si le livre existe avant d'incrémenter les exemplaires disponibles
        $book = Book::find($borrowing->book_id);
    
        if ($book) {
            $book->increment('copies_available'); // Augmente les exemplaires disponibles si le livre existe
        }
    
        // Supprimer l'emprunt
        $borrowing->delete();
    
        return redirect()->route('borrowings.index')->with('success', 'Emprunt supprimé avec succès.');
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

    public function create()
{
    $books = Book::where('copies_available', '>', 0)->get(); // Récupère les livres disponibles
    $users = User::all(); // Récupère tous les utilisateurs

    return view('borrowings.create', compact('books', 'users'));
}

}
