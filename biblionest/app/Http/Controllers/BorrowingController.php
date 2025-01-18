<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'book'])->get();
        return view('borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        $users = User::all();
        $books = Book::where('copies_available', '>', 0)->get();
        return view('borrowings.create', compact('users', 'books'));
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

    public function destroy(Borrowing $borrowing)
    {
        // Réajouter la copie si l'emprunt est supprimé avant retour
        if (!$borrowing->returned_at) {
            $borrowing->book->increment('copies_available');
        }

        $borrowing->delete();
        return redirect()->route('borrowings.index')->with('success', 'Emprunt supprimé.');
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
}
