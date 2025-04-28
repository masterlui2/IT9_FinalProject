<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// routes/api.php
use App\Http\Controllers\ResidentController;

Route::get('/residents/{id}', [ResidentController::class, 'show']);
Route::middleware('api')->group(function () {
    // Your API routes will go here
});