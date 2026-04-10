<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DatasetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminDatasetController;
use App\Http\Controllers\AdminApprovalController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminSeksiController;
use App\Http\Controllers\AdminKategoriController;

Route::get('/', [KategoriController::class, 'index'])->name('kategori.index');
Route::get('/kategori/{id}', [KategoriController::class, 'show'])->name('kategori.show');
Route::get('/dataset/{dataset}', [DatasetController::class, 'show'])->name('dataset.show');
Route::get('/dataset/{dataset}/export/csv', [DatasetController::class, 'exportCsv'])->name('dataset.export.csv');
Route::get('/dataset/{dataset}/export/excel', [DatasetController::class, 'exportExcel'])->name('dataset.export.excel');
Route::get('/dataset/{dataset}/export/pdf', [DatasetController::class, 'exportPdf'])->name('dataset.export.pdf');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/admin-dashboard', [DashboardController::class, 'admin'])
        ->name('admin.dashboard');

    Route::middleware(['role:superadmin,admin_umum,admin_seksi'])
        ->prefix('admin-dataset')
        ->group(function () {

        Route::get('/', [AdminDatasetController::class, 'index'])->name('dataset.index');
        Route::get('/create', [AdminDatasetController::class, 'create'])->name('dataset.create');
        Route::post('/', [AdminDatasetController::class, 'store'])->name('dataset.store');
        Route::get('/import', [AdminDatasetController::class, 'import'])->name('dataset.import');
        Route::post('/import-preview', [AdminDatasetController::class, 'importPreview'])->name('dataset.import.preview');

        Route::get('/{dataset}', [AdminDatasetController::class, 'show'])->name('admin-dataset.show');
        Route::get('/{dataset}/edit', [AdminDatasetController::class, 'edit'])->name('dataset.edit');
        Route::put('/{dataset}', [AdminDatasetController::class, 'update'])->name('dataset.update');
        Route::delete('/{dataset}', [AdminDatasetController::class, 'destroy'])->name('dataset.destroy');

        Route::post('/{dataset}/submit', [AdminDatasetController::class, 'submit'])->name('dataset.submit');
        
        Route::post('/{dataset}/data', [AdminDatasetController::class, 'storeData'])->name('dataset.data.store');
        Route::put('/data/{data}', [AdminDatasetController::class, 'updateData'])->name('dataset.data.update');
        Route::delete('/data/{data}', [AdminDatasetController::class, 'destroyData'])->name('dataset.data.delete');

        Route::post('{dataset}/columns', [AdminDatasetController::class, 'storeColumn'])->name('columns.store');
        Route::put('{dataset}/columns/{index}', [AdminDatasetController::class, 'updateColumn'])->name('columns.update');
        Route::delete('{dataset}/columns/{index}', [AdminDatasetController::class, 'destroyColumn'])->name('columns.destroy');

        Route::post('{dataset}/rows', [AdminDatasetController::class, 'storeRow'])->name('rows.store');
        Route::put('{dataset}/rows/{row}', [AdminDatasetController::class, 'updateRow'])->name('rows.update');
        Route::delete('{dataset}/rows/{row}', [AdminDatasetController::class, 'destroyRow'])->name('rows.destroy');

        Route::post('{dataset}/filters', [AdminDatasetController::class, 'storeFilter'])->name('filters.store');
        Route::put('{dataset}/filters/{filter}', [AdminDatasetController::class, 'updateFilter'])->name('filters.update');
        Route::delete('{dataset}/filters/{filter}', [AdminDatasetController::class, 'destroyFilter'])->name('filters.destroy');
    });

    Route::middleware(['role:superadmin,kepala_seksi'])
        ->prefix('admin-approval')
        ->group(function () {
        Route::get('/', [AdminApprovalController::class, 'index'])->name('admin.approval.index');
        Route::post('/{dataset}/approve', [AdminApprovalController::class, 'approve'])->name('admin.approval.approve');
        Route::post('/{dataset}/reject', [AdminApprovalController::class, 'reject'])->name('admin.approval.reject');
        Route::post('/{dataset}/cancel', [AdminApprovalController::class, 'cancel'])->name('admin.approval.cancel');
        Route::get('/{dataset}', [AdminApprovalController::class, 'show'])->name('admin.approval.show');
    });

    Route::middleware(['role:superadmin'])->group(function () {

        Route::resource('admin/user', AdminUserController::class)
            ->names('admin.user');

        Route::resource('admin/seksi', AdminSeksiController::class)
            ->names('admin.seksi');

        Route::resource('admin/kategori', AdminKategoriController::class)
            ->names('admin.kategori');
    });
});