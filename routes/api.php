<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


Route::middleware('auth:sanctum')->group(function () {
    // Public Course Routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [UserController::class, 'profile']);
    // Route::put('/profile', [UserController::class, 'updateProfile']);
    Route::post('/profile/update', [UserController::class, 'updateProfile']);
    Route::delete('/profile', [UserController::class, 'destroy']);


    // Admin and Teacher Routes
    Route::middleware(['role:owner|manager_cabang'])->group(function () {});
});
