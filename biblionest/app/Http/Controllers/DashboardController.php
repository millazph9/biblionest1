<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Book;
use App\Models\User;
use App\Models\Penalty;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // ✅ Appliquer un middleware d'authentification à toutes les méthodes
    }

    public function index()
    {
        // Statistiques principales
        $totalBooks = Book::count();
        $totalUsers = User::count();
        $totalBorrowings = Borrowing::whereNull('returned_at')->count();
        $totalLateBorrowings = Borrowing::whereNull('returned_at')
                                        ->where('due_date', '<', Carbon::now())
                                        ->count();
        $totalUnpaidPenalties = Penalty::where('paid', false)->sum('amount');

        // 📊 Récupération des emprunts par mois pour le graphique
        $monthlyBorrowings = Borrowing::whereYear('borrowed_at', Carbon::now()->year)
            ->selectRaw('MONTH(borrowed_at) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        // Convertir les numéros de mois en noms de mois
        $months = [
            1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril', 5 => 'Mai', 6 => 'Juin',
            7 => 'Juillet', 8 => 'Août', 9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
        ];

        $formattedMonths = [];
        $formattedData = [];

        foreach ($months as $num => $name) {
            $formattedMonths[] = $name;
            $formattedData[] = $monthlyBorrowings[$num] ?? 0; // 0 si aucun emprunt pour ce mois
        }

        return view('dashboard.index', compact(
            'totalBooks',
            'totalUsers',
            'totalBorrowings',
            'totalLateBorrowings',
            'totalUnpaidPenalties',
            'formattedMonths',
            'formattedData'
        ));
    }
}
