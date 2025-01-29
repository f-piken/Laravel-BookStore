<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth','role:admin'])->group(function () {
    Route::resource('admin-dashboard', AdminController::class);

    Route::resource('products', ProductController::class);

    Route::get('/orders', [OrderController::class,'index'])->name('orders.index');
    Route::delete('/orders/{id}', [OrderController::class,'destroy'])->name('orders.destroy');
    Route::get('/orders/report', [OrderController::class, 'report'])->name('orders.report');
    Route::get('/orders/report/pdf', [OrderController::class, 'generatePDF'])->name('orders.generate-pdf');
    
    Route::resource('categories', CategoryController::class);
    
    Route::get('/sellers/table', [SellerController::class,'data'])->name('sellers.data');
    Route::delete('/sellers/{id}', [SellerController::class,'delete'])->name('sellers.delete');

    Route::get('/customers/table', [CustomerController::class,'data'])->name('customers.data');
    Route::delete('/customers/{id}', [CustomerController::class,'destroy'])->name('customers.delete');
});