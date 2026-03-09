<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DatasetController;

// Route::get('/', function () {
//     return 'Dashboard Prototype';
// });

Route::get('/', [KategoriController::class, 'index'])->name('kategori.index');
Route::get('/kategori/{id}', [KategoriController::class, 'show'])->name('kategori.show');
Route::get('/dataset/{dataset}', [DatasetController::class, 'show'])->name('dataset.show');

Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/dashboard/data', [DashboardController::class, 'data']);