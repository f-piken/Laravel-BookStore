<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

require base_path('routes/admin.php');
require base_path('routes/seller.php');
require base_path('routes/customer.php');
require base_path('routes/auth.php');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/best-seller', [HomeController::class, 'bestSeller'])->name('best.seller');
Route::get('/top-rate', [HomeController::class, 'rating'])->name('top.rate');
Route::get('/category', [HomeController::class, 'category'])->name('home.categories');

Route::get('/api/products/category/{categoryId}', [HomeController::class, 'getProductsByCategory']);
Route::get('/api/products/all', [HomeController::class, 'getAllCategory']);
Route::get('/product/cari', [ProductController::class, 'cari'])->name('product.cari');
Route::resource('product', ProductController::class);
