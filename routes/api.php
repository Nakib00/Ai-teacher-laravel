<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\SchoolClassController;
use App\Models\SchoolClass;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/token', [AuthController::class, 'getLiveKitToken']);
    Route::post('/addClass', [SchoolClassController::class, 'addClass']);
    Route::get('/getAllClass', [SchoolClassController::class, 'getClass']);
});
