<?php

use App\Http\Controllers\AiRecommendationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route(auth()->check() ? 'dashboard' : 'login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resources([
        'categories'   => CategoryController::class,
        'suppliers'    => SupplierController::class,
        'locations'    => LocationController::class,
        'products'     => ProductController::class,
        'stock-ins'    => StockInController::class,
        'stock-outs'   => StockOutController::class,
        'maintenances' => MaintenanceController::class,
    ], ['except' => ['show']]);

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/ai-recommendation', [AiRecommendationController::class, 'index'])->name('ai.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
