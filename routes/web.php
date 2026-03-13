<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;  
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PublicController;

Route::get('/', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/laporan-publik', [DashboardController::class, 'public'])
    ->name('dashboard.public');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/transactions/create', [TransactionController::class, 'create'])
        ->name('transactions.create');
    Route::post('/transactions', [TransactionController::class, 'store'])
        ->name('transactions.store');
    Route::get('/transactions.edit/{transaction}', [TransactionController::class, 'edit'])
        ->name('transactions.edit');
    Route::put('/transactions.update/{transaction}', [TransactionController::class, 'update'])
        ->name('transactions.update');
    Route::delete('/transactions.destroy/{transaction}', [TransactionController::class, 'destroy'])
        ->name('transactions.destroy');
    Route::get('/transactions/report/export', [ReportController::class, 'export'])
        ->name('transactions.export.pdf');
});

Route::get('/transactions/report/export', [ReportController::class, 'exportPdf'])
    ->middleware('auth')
    ->name('transactions.export.pdf');



// Admin: Pending Bendahara Management
// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/admin/bendahara/pending', [AdminController::class, 'index'])
//         ->name('admin.bendahara.pending');
//     Route::patch('/admin/bendahara/{id}/approve', [AdminController::class, 'approveBendahara'])
//         ->name('admin.bendahara.approve');
// });

// Admin users management
// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
//     Route::post('/admin/users/{id}/approve', [AdminController::class, 'approve'])->name('admin.users.approve');
// });

require __DIR__.'/auth.php';
