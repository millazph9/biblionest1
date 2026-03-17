<?php

use Livewire\Livewire;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PenaltyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdherentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\DashboardController;

// ✅ Route principale de l'accueil
Route::get('/', function () {
    return redirect()->route('login');
});

// ✅ Route principale du tableau de bord (SUPPRESSION DU MIDDLEWARE auth)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

// ✅ Routes sans restriction (auth retiré)
Route::resource('books', BookController::class);
Route::resource('borrowings', BorrowingController::class);
Route::resource('penalties', PenaltyController::class);
Route::get('/mes-penalites', [PenaltyController::class, 'mesPenalites'])->middleware('auth')->name('penalties.mine');

Route::resource('categories', CategoryController::class);

// ✅ Routes pour Livewire Test
Route::get('/test-livewire', function () {
    return class_exists(Livewire::class) ? 'Livewire fonctionne !' : 'Livewire ne fonctionne pas.';
});

// ✅ Routes spécifiques aux adhérents
Route::resource('adherents', AdherentController::class);
// Route::get('/adherents/{adherent}/borrowings', [AdherentController::class, 'borrowings'])
//     ->name('adherents.borrowings');
Route::get('/adherents/{adherent}/export-borrowings', [AdherentController::class, 'exportBorrowingsPDF'])
    ->name('adherents.export.borrowings');


// ✅ Exportation PDF des livres
Route::get('/books/export-pdf', [BookController::class, 'exportPDF'])
    ->name('books.export.pdf');

    Route::post('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook'])
    ->name('borrowings.return');

// edition
Route::resource('editions', EditionController::class);


// 🔹 Authentification (gérée par Laravel Breeze/Fortify) -> Toujours chargé mais non obligatoire
require __DIR__.'/auth.php';
