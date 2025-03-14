<?php
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::prefix('account')->group(function () {
    Route::post('/register', [AccountController::class, 'register']);
    Route::post('/update', [AccountController::class, 'updateAccount']);
    Route::post('/delete', [AccountController::class, 'deleteAccount']);
});

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
