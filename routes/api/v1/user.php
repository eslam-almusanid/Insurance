<?php

use App\Http\Controllers\V1\User\RegistrationController;
use Illuminate\Support\Facades\Route;


Route::post('/registration', RegistrationController::class);
