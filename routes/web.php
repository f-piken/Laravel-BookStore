<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

require base_path('routes/admin.php');
require base_path('routes/editor.php');
require base_path('routes/viewer.php');
require base_path('routes/auth.php');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/category', [HomeController::class, 'category'])->name('home.categories');
Route::prefix('api/books')->group(function () {
    Route::get('category/{categoryId}', [HomeController::class, 'getbooksByCategory']);
    Route::get('all', [HomeController::class, 'getAllCategory']);
});
Route::prefix('book')->name('book.')->group(function () {
    Route::get('cari', [BookController::class, 'cari'])->name('cari');
    Route::get('show/{id}', [BookController::class, 'show'])->name('show');
});