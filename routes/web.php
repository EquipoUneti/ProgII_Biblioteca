<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MovementController;

Route::redirect('/', '/books');

// Books CRUD Routes
Route::resource('books', BookController::class);

// Inventory Movements Routes
Route::get('movements', [MovementController::class, 'index'])->name('movements.index');
Route::post('movements', [MovementController::class, 'store'])->name('movements.store');
