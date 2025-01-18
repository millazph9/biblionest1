<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BorrowingController;




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

// Route::get('borrowings/create', [BorrowingController::class, 'create'])->name('borrowings.create')->middleware('auth');
// Route::post('borrowings/store', [BorrowingController::class, 'store'])->name('borrowings.store')->middleware('auth');
// Route::get('borrowings', [BorrowingController::class, 'show'])->name('borrowings.show')->middleware('auth');
Route::resource('borrowings', BorrowingController::class)->middleware('auth');
Route::post('borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook'])
    ->name('borrowings.return')
    ->middleware('auth');


require __DIR__.'/auth.php';
