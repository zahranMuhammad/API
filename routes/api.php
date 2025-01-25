<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('api')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/login_dulu', [AuthController::class, 'login_dulu'])->name('login');

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/produk', [ProdukController::class, 'store']);
        Route::get('/produk', [ProdukController::class, 'index']);
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::post('/transaksi', [PenjualanController::class, 'store']);
        Route::get('/logout', [AuthController::class, 'logout']);
    });
});

