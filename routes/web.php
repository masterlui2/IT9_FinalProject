<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard routes
Route::middleware(['web'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Full page routes (optional fallback)
    Route::get('/dashboard/residents', [DashboardController::class, 'residents'])->name('resident.info');
    Route::get('/dashboard/households', [DashboardController::class, 'households'])->name('household.data');
    Route::get('/dashboard/documents', [DashboardController::class, 'documents'])->name('barangay.docs');
    Route::get('/dashboard/permits', [DashboardController::class, 'permits'])->name('business.permits');
    Route::get('/dashboard/incidents', [DashboardController::class, 'incidents'])->name('incident.logs');
    Route::get('/dashboard/view/{section}', [DashboardController::class, 'view']);
    Route::get('/dashboard/view/{section}', [DashboardController::class, 'loadSection']);

    // AJAX-loaded dashboard sections
    Route::get('/dashboard/view/{section}', [DashboardController::class, 'loadSection']);
}); 
