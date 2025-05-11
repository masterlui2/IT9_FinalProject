<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// routes/api.php
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\PermitController;

Route::post('/permits/residency', [PermitController::class, 'storeResidency']);
Route::get('/residents/{id}', [ResidentController::class, 'show']);
Route::middleware('api')->group(function () {
    // Your API routes will go here
});