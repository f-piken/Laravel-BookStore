<?php

use App\Http\Controllers\EditorController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth','role:editor'])->group(function () {
    Route::middleware('role:editor')->prefix('editor')->name('editors.')->group(function () {
        Route::resource('/', EditorController::class)->parameters(['' => 'editor']);
        Route::get('books', [EditorController::class, 'book'])->name('books');
        Route::put('book/{id}', [EditorController::class, 'updateBook'])->name('book.update');
        Route::delete('book/{id}', [EditorController::class, 'destroy'])->name('book.destroy');
    });
});