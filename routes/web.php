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
use App\Http\Controllers\AdminDashboardController;

Route::redirect('/', '/login');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/admin-dashboard', [KategoriController::class, 'index'])
        ->name('admin.dashboard.index');
    Route::get('/admin-dashboard/kategori/{id}', [KategoriController::class, 'show'])->name('admin.dashboard.kategori.show');
    Route::get('/admin-dashboard/dataset/{dataset}', [DatasetController::class, 'show'])->name('admin.dashboard.dataset.show');
    Route::get('/admin-dashboard/dataset/{dataset}/export/pdf', [DatasetController::class, 'exportPdf'])->name('admin.dataset.export.pdf');
    Route::get('/admin-dashboard/dataset/{dataset}/export/excel', [DatasetController::class, 'exportExcel'])->name('admin.dataset.export.excel');

    Route::middleware(['role:superadmin,admin_umum,admin_seksi'])
        ->prefix('admin-dataset')
        ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DATASET
        |--------------------------------------------------------------------------
        */

        Route::get('/', [AdminDatasetController::class, 'index'])
            ->name('dataset.index');

        Route::get('/create', [AdminDatasetController::class, 'create'])
            ->name('dataset.create');

        Route::post('/', [AdminDatasetController::class, 'store'])
            ->name('dataset.store');

        Route::get('/import', [AdminDatasetController::class, 'import'])
            ->name('dataset.import');

        Route::post('/import-preview', [AdminDatasetController::class, 'importPreview'])
            ->name('dataset.import.preview');

        Route::post('/import-store', [AdminDatasetController::class, 'importStore'])
            ->name('dataset.importStore');

        Route::get('/import-files', [AdminDatasetController::class, 'importFiles'])
            ->name('dataset.importFiles');

        Route::post('/import-files-preview', [AdminDatasetController::class, 'importFilesPreview'])
            ->name('dataset.importFiles.preview');

        Route::post('/import-files-store', [AdminDatasetController::class, 'importFilesStore'])
            ->name('dataset.importFilesStore');

        Route::get('/{dataset}', [AdminDatasetController::class, 'show'])
            ->name('admin-dataset.show');

        Route::get('/{dataset}/edit', [AdminDatasetController::class, 'edit'])
            ->name('dataset.edit');

        Route::put('/{dataset}', [AdminDatasetController::class, 'update'])
            ->name('dataset.update');

        Route::delete('/{dataset}', [AdminDatasetController::class, 'destroy'])
            ->name('dataset.destroy');

        /*
        |--------------------------------------------------------------------------
        | SUBMIT DATASET BARU
        |--------------------------------------------------------------------------
        */

        Route::post('/{dataset}/submit', [AdminDatasetController::class, 'submit'])
            ->name('dataset.submit');

        /*
        |--------------------------------------------------------------------------
        | SUBMIT REVISION
        |--------------------------------------------------------------------------
        */

        Route::post('/{dataset}/submit-revision', [AdminDatasetController::class, 'submitRevision'])
            ->name('dataset.submitRevision');

        /*
        |--------------------------------------------------------------------------
        | DATASET DATA
        |--------------------------------------------------------------------------
        */

        Route::post('/{dataset}/data', [AdminDatasetController::class, 'storeRow'])
            ->name('dataset.data.store');

        Route::put('/data/{data}', [AdminDatasetController::class, 'updateData'])
            ->name('dataset.data.update');

        Route::delete('/data/{data}', [AdminDatasetController::class, 'destroyData'])
            ->name('dataset.data.delete');

        /*
        |--------------------------------------------------------------------------
        | ROWS
        |--------------------------------------------------------------------------
        */

        Route::post('{dataset}/rows', [AdminDatasetController::class, 'storeRow'])
            ->name('rows.store');

        Route::put('{dataset}/rows/{row}', [AdminDatasetController::class, 'updateRow'])
            ->name('rows.update');

        Route::delete('{dataset}/rows/{row}', [AdminDatasetController::class, 'destroyRow'])
            ->name('rows.destroy');

        /*
        |--------------------------------------------------------------------------
        | COLUMNS
        |--------------------------------------------------------------------------
        */

        Route::post('{dataset}/columns', [AdminDatasetController::class, 'storeColumn'])
            ->name('columns.store');

        Route::put('{dataset}/columns/{index}', [AdminDatasetController::class, 'updateColumn'])
            ->name('columns.update');

        Route::delete('{dataset}/columns/{index}', [AdminDatasetController::class, 'destroyColumn'])
            ->name('columns.destroy');

        /*
        |--------------------------------------------------------------------------
        | FILTERS
        |--------------------------------------------------------------------------
        */

        Route::post('{dataset}/filters', [AdminDatasetController::class, 'storeFilter'])
            ->name('filters.store');

        Route::put('{dataset}/filters/{filter}', [AdminDatasetController::class, 'updateFilter'])
            ->name('filters.update');

        Route::delete('{dataset}/filters/{filter}', [AdminDatasetController::class, 'destroyFilter'])
            ->name('filters.destroy');
    });

    Route::middleware(['role:superadmin,kepala_seksi'])
        ->prefix('admin-approval')
        ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | APPROVAL PAGE
        |--------------------------------------------------------------------------
        */

        Route::get('/', [AdminApprovalController::class, 'index'])
            ->name('admin.approval.index');

        Route::get('/{dataset}', [AdminApprovalController::class, 'show'])
            ->name('admin.approval.show');

        /*
        |--------------------------------------------------------------------------
        | APPROVE / REJECT DATASET BARU
        |--------------------------------------------------------------------------
        */

        Route::post('/{dataset}/approve', [AdminApprovalController::class, 'approve'])
            ->name('admin.approval.approve');

        Route::post('/{dataset}/reject', [AdminApprovalController::class, 'reject'])
            ->name('admin.approval.reject');

        /*
        |--------------------------------------------------------------------------
        | APPROVE / REJECT REVISION
        |--------------------------------------------------------------------------
        */

        Route::post('/{dataset}/approve-update', [AdminApprovalController::class, 'approveUpdate'])
            ->name('admin.approval.approveUpdate');

        Route::post('/{dataset}/reject-update', [AdminApprovalController::class, 'rejectUpdate'])
            ->name('admin.approval.rejectUpdate');

        /*
        |--------------------------------------------------------------------------
        | CANCEL TO DRAFT
        |--------------------------------------------------------------------------
        */

        Route::post('/{dataset}/cancel', [AdminApprovalController::class, 'cancel'])
            ->name('admin.approval.cancel');
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