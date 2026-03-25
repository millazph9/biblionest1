<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Book;
use App\Models\User;
use App\Models\Penalty;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 📊 Statistiques globales
        $totalBooks = Book::count();
        $totalUsers = User::count();
        $totalBorrowings = Borrowing::whereNull('returned_at')->count();
        $totalLateBorrowings = Borrowing::whereNull('returned_at')
                                        ->where('due_date', '<', Carbon::now())
                                        ->count();
        $totalUnpaidPenalties = Penalty::where('paid', false)->sum('amount');

        // 📈 Emprunts par mois (pour le graphique)
         $borrowingByMonth = Borrowing::whereNotNull('borrowed_at')->selectRaw('MONTH(borrowed_at) as month, COUNT(*) as total')
        ->groupBy('month')
        ->orderBy('month')
        ->get();
    

        $monthNames = [
    1 => 'Janvier',
    2 => 'Février',
    3 => 'Mars',
    4 => 'Avril',
    5 => 'Mai',
    6 => 'Juin',
    7 => 'Juillet',
    8 => 'Août',
    9 => 'Septembre',
    10 => 'Octobre',
    11 => 'Novembre',
    12 => 'Décembre',
];

$months = $borrowingByMonth->pluck('month')->map(function ($month) use ($monthNames) {
    return $monthNames[(int) $month] ?? 'Erreur';
});
        $counts = $borrowingByMonth->pluck('total');

    

        // 🆕 Derniers adhérents
        $latestUsers = User::latest()->take(5)->get();

        // 🆕 Livres les plus empruntés
        $topBooks = Book::withCount('borrowings')
                        ->orderByDesc('borrowings_count')
                        ->take(5)
                        ->get();

        // 🆕 Emprunts en retard récents
        $recentLateBorrowings = Borrowing::whereNull('returned_at')
            ->where('due_date', '<', now())
            ->with(['book', 'user'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalBooks',
            'totalUsers',
            'totalBorrowings',
            'totalLateBorrowings',
            'totalUnpaidPenalties',
            'latestUsers',
            'topBooks',
            'recentLateBorrowings',
            'months',
            'counts'
        ));
    }
}
