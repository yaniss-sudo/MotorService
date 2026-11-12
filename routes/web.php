<?php

use App\Http\Controllers\DaftarServiceController;
use App\Http\Controllers\DataServiceController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ProfileController;
use App\Models\DaftarService;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'))->name('welcome');
Route::get('/dashboard', fn () => view('dashboard'))
    ->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Semua user yang login boleh melihat daftar
    Route::get('pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
    Route::get('kendaraan', [KendaraanController::class, 'index'])->name('kendaraan.index');
    Route::get('daftar-service', [DaftarServiceController::class, 'index'])->name('daftar-service.index');
    Route::get('data-service', [DataServiceController::class, 'index'])->name('data-service.index');
    Route::get('pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');

    // Pengisian otomatis (nama pelanggan dan keluhan)
    Route::get('/lookup/pelanggan/{id}', fn ($id) =>
        response()->json(Pelanggan::findOrFail($id)->only('id_pelanggan', 'nama_lengkap')));
    Route::get('/lookup/servis/{id}', fn ($id) =>
        response()->json(DaftarService::findOrFail($id)->only('id_servis', 'keluhan')));
});

// Tambah, ubah, hapus: hanya admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('pelanggan', PelangganController::class)->except(['index', 'show']);
    Route::resource('kendaraan', KendaraanController::class)->except(['index', 'show']);
    Route::resource('daftar-service', DaftarServiceController::class)->except(['index', 'show'])
        ->parameters(['daftar-service' => 'daftarService']);
    Route::resource('data-service', DataServiceController::class)->except(['index', 'show'])
        ->parameters(['data-service' => 'dataService']);
    Route::resource('pembayaran', PembayaranController::class)->except(['index', 'show']);
});

require __DIR__.'/auth.php';
