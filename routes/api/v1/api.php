<?php

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