<?php

use App\Http\Controllers\ViewerController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth','role:viewer'])->group(function () {
    Route::prefix('viewer')->name('viewers.')->group(function () {
        Route::get('/', [ViewerController::class, 'index'])->name('index');
        Route::put('{id}', [ViewerController::class, 'update'])->name('update');
    });
});