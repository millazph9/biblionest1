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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Routes protégées avec 'auth'
Route::middleware(['auth'])->group(function () {
    
    // Gestion des Adhérents (seuls les employés peuvent gérer)
    Route::resource('adherents', AdherentController::class)->middleware('can:manage-adherents');

    // Gestion des Livres
    Route::resource('books', BookController::class)->middleware('can:manage-books');

    // Gestion des Emprunts
    Route::resource('borrowings', BorrowingController::class)->middleware('can:manage-borrowings');

    // Gestion des Pénalités
    Route::resource('penalties', PenaltyController::class)->middleware('can:manage-penalties');
});


Route::resource('categories', CategoryController::class)->middleware('auth');
Route::resource('categories', CategoryController::class);
Route::resource('books', BookController::class)->middleware('auth');


Route::resource('borrowings', BorrowingController::class)->middleware('auth');
Route::post('borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook'])
    ->name('borrowings.return')
    ->middleware('auth');

// Route::get('penalties', [PenaltiesController::class]);


// Route::get('penalties', function () {
//     return view('penalties.index'); // resources/views/maPage.blade.php
// })->name('penalties');


Route::resource('penalties', PenaltyController::class)->middleware('auth');
Route::post('penalties/{penalty}/pay', [PenaltyController::class, 'pay'])->name('penalties.pay')->middleware('auth');


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
Route::post('/books', [BookController::class, 'store'])->name('books.store');
Route::get('/books/{book}/edit', [BookController::class, 'edit'])->name('books.edit');
Route::put('/books/{book}', [BookController::class, 'update'])->name('books.update');
Route::get('/books/export/pdf', [BookController::class, 'exportPDF'])->name('books.export.pdf');
Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
// Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');


Route::get('/test-livewire', function () {
    return class_exists(Livewire::class) ? 'Livewire fonctionne !' : 'Livewire ne fonctionne pas.';});

// Route principale pour les adhérents (CRUD)
Route::resource('adherents', AdherentController::class);

// Route pour afficher les emprunts d'un adhérent spécifique
Route::get('/adherents/{adherent}/borrowings', [AdherentController::class, 'borrowings'])
    ->name('adherents.borrowings');

// Route pour exporter en PDF la liste des emprunts d'un adhérent
Route::get('/adherents/{adherent}/export-borrowings', [AdherentController::class, 'exportBorrowingsPDF'])
    ->name('adherents.export.borrowings');

require __DIR__.'/auth.php';
