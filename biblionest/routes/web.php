<?php

use Livewire\Livewire;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PenaltyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\DashboardController;





Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::resource('categories', CategoryController::class)->middleware('auth');
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
Route::get('/books/export/pdf', [BookController::class, 'exportPDF'])->name('books.export.pdf');

Route::get('/test-livewire', function () {
    return class_exists(Livewire::class) ? 'Livewire fonctionne !' : 'Livewire ne fonctionne pas.';});

require __DIR__.'/auth.php';
