<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ResidentController;

// Test route
Route::get('/test-resident', function() {
    return response()->json([
        'test' => true,
        'message' => 'API is working'
    ]);
});
Route::get('/households/{household}/heads', function ($householdId) {
    return \App\Models\Resident::where('household_id', $householdId)
        ->where('relationship', 'Head')
        ->get(['id', 'full_name']);
});
// Consolidated Resident Routes
Route::prefix('residents')->group(function () {
    Route::get('/', [ResidentController::class, 'index']);
    Route::get('/{id}', [ResidentController::class, 'show'])->name('residents.show');
    Route::post('/', [ResidentController::class, 'store'])->name('residents.store');
    Route::put('/{id}', [ResidentController::class, 'update'])->name('residents.update');
    Route::delete('/{id}', [ResidentController::class, 'destroy']);
    // In routes/api.php
Route::get('/residents/{resident}', [ResidentController::class, 'show']);
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard routes
Route::middleware(['web'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/residents', [DashboardController::class, 'residents'])->name('resident.info');
    Route::get('/dashboard/documents', [DashboardController::class, 'documents'])->name('barangay.docs');
    Route::get('/dashboard/permits', [DashboardController::class, 'permits'])->name('business.permits');
    Route::get('/dashboard/incidents', [DashboardController::class, 'incidents'])->name('incident.logs');
    Route::get('/dashboard/view/{section}', [DashboardController::class, 'loadSection']);
});