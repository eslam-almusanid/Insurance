<?php

use App\Http\Controllers\V1\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:admin')->post('/logout', [AuthController::class, 'logout']);
