<?php

use App\Http\Controllers\SellerController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth','role:seller'])->group(function () {
    Route::get('/seller-dashboard', function () {
        return view('dashboard.seller');
    })->name('dashboard.seller');

    Route::put('/sellers/order/confirm/{order}', [SellerController::class, 'confirmOrder'])->name('sellers.confirm');
    Route::get('/sellers/pesanan', [SellerController::class, 'listPesanan'])->name('sellers.pesanan');

    Route::resource('sellers', SellerController::class);
    Route::delete('/toko/delete/{id}', [SellerController::class, 'destroy'])->name('sellers.toko.destroy');
    Route::put('/toko/{id}', [SellerController::class, 'updateToko'])->name('sellers.toko.update');
    Route::get('/toko', [SellerController::class, 'toko'])->name('sellers.toko');
});