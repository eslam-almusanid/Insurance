<?php

use App\Http\Controllers\V1\Admin\AdminAuthController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/login', [AdminAuthController::class, 'login']);

// Protected routes
Route::middleware(['auth:sanctum','admin'])->group(function () {
    Route::post('/logout', [AdminAuthController::class, 'logout']);
    Route::post('/change-password', [AdminAuthController::class, 'changePassword']);
});
