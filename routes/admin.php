<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ViewerController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\EditorController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth','role:admin'])->group(function () {
    Route::prefix('admin')->name('admin-')->group(function () {
        Route::resources([
            'dashboard' => AdminController::class,
            'users' => UserController::class,
            'books' => BookController::class,
            'categories' => CategoryController::class,
        ]);

        // Editor management
        Route::prefix('editors')->name('editors.')->group(function () {
            Route::get('table', [EditorController::class, 'data'])->name('data');
            Route::get('edit/{id}', [UserController::class, 'editEditor'])->name('edit');
            Route::put('update/{id}', [UserController::class, 'updateEditor'])->name('update');
            Route::delete('{id}', [EditorController::class, 'delete'])->name('delete');
        });

        // Viewer management
        Route::prefix('viewers')->name('viewers.')->group(function () {
            Route::get('table', [ViewerController::class, 'data'])->name('data');
            Route::get('edit/{id}', [UserController::class, 'editViewer'])->name('edit');
            Route::put('update/{id}', [UserController::class, 'updateViewer'])->name('update');
            Route::delete('{id}', [ViewerController::class, 'destroy'])->name('delete');
        });
    });
});