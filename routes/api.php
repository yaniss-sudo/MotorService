<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DaftarServiceController;
use App\Http\Controllers\Api\DataServiceController;
use App\Http\Controllers\Api\KendaraanController;
use App\Http\Controllers\Api\PelangganController;
use App\Http\Controllers\Api\PembayaranController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Semua user yang login boleh melihat data
    Route::get('pelanggan', [PelangganController::class, 'index']);
    Route::get('pelanggan/{id}', [PelangganController::class, 'show']);
    Route::get('kendaraan', [KendaraanController::class, 'index']);
    Route::get('kendaraan/{id}', [KendaraanController::class, 'show']);
    Route::get('daftar-service', [DaftarServiceController::class, 'index']);
    Route::get('daftar-service/{id}', [DaftarServiceController::class, 'show']);
    Route::get('data-service', [DataServiceController::class, 'index']);
    Route::get('data-service/{id}', [DataServiceController::class, 'show']);
    Route::get('pembayaran', [PembayaranController::class, 'index']);
    Route::get('pembayaran/{id}', [PembayaranController::class, 'show']);
});

// Tambah, ubah, hapus: hanya admin
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiResource('pelanggan', PelangganController::class)
        ->except(['index', 'show'])
        ->names('api.pelanggan');
    Route::apiResource('kendaraan', KendaraanController::class)
        ->except(['index', 'show'])
        ->names('api.kendaraan');
    Route::apiResource('daftar-service', DaftarServiceController::class)
        ->except(['index', 'show'])
        ->names('api.daftar-service');
    Route::apiResource('data-service', DataServiceController::class)
        ->except(['index', 'show'])
        ->names('api.data-service');
    Route::apiResource('pembayaran', PembayaranController::class)
        ->except(['index', 'show'])
        ->names('api.pembayaran');
});
