<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/books');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('books.index');
    })->name('dashboard');

    // Books CRUD Routes
    Route::resource('books', BookController::class);

    // Inventory Movements Routes
    Route::get('movements', [MovementController::class, 'index'])->name('movements.index');
    Route::post('movements', [MovementController::class, 'store'])->name('movements.store');

    // Profile Routes (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
