<?php

use App\Http\Controllers\V1\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\User\NajmController;
use App\Http\Controllers\V1\User\YakeenController;

Route::get('/bing', fn () => 'bong');


Route::prefix('najm')->group(function () {
    Route::post('/policy/status', [NajmController::class, 'checkPolicyStatus']);
    Route::post('/claims', [NajmController::class, 'submitClaim']);
    Route::get('/vehicle/info', [NajmController::class, 'getVehicleInfo']); // Route جديد
    Route::get('/insurance/offers', [NajmController::class, 'getInsuranceOffers']);
});

Route::prefix('yakeen')->group(function () {
    Route::post('/verify-identity', [YakeenController::class, 'verifyIdentity']);
});



// Public routes
// Route::post('/register', [AuthController::class, 'register']);
// Route::post('/login', [AuthController::class, 'login']);

// // Protected routes
// Route::middleware('auth:sanctum', 'admin')->group(function () {
//     Route::get('/user', [AuthController::class, 'user']);
//     Route::put('/user', [AuthController::class, 'update']);
//     Route::put('/user/password', [AuthController::class, 'updatePassword']);
//     Route::post('/logout', [AuthController::class, 'logout']);
//     Route::delete('/user', [AuthController::class, 'destroy']);
// });
