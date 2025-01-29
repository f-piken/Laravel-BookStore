<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishListController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth','role:customer'])->group(function () {
    Route::get('/order/rating/{id}', [ProductController::class, 'rating'])->name('customers.rate');

    Route::put('/customers/order/confirm/{order}', [CustomerController::class, 'confirmPayment'])->name('customers.confirm');
    Route::get('/customers/pesanan', [CustomerController::class, 'listPesanan'])->name('customers.pesanan');
    Route::put('/customers/rating/{id}', [ProductController::class, 'rateMultipleProducts'])->name('rate.multiple');
    Route::resource('customers', CustomerController::class);

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    
    Route::resource('wishlist', WishListController::class);
    Route::post('/wishlist/{productId}', [WishListController::class, 'toggleWishlist'])->name('wishlist.add');
});