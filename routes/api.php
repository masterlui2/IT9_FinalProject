<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermitController;
use App\Http\Controllers\ResidentController;

// API Routes (return JSON)
Route::prefix('api')->middleware(['auth:sanctum'])->group(function() {
        Route::prefix('permits')->group(function() {
        Route::get('/', [PermitController::class, 'getMyRequests'])->name('api.permits.index');
        Route::get('/{id}', [PermitController::class, 'show'])->name('api.permits.show');
        Route::put('/{id}/approve', [PermitController::class, 'approve'])->name('api.permits.approve');
        Route::delete('/{id}', [PermitController::class, 'destroy'])->name('api.permits.destroy');
    });
    
    // Resident routes
    Route::get('/residents/{id}', [ResidentController::class, 'show'])->name('api.residents.show');
});