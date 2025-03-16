<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AccountController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// 需要帶Token才能使用
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::post('/acctUpdate', [AccountController::class, 'updateAccount']);
    Route::post('/acctDelete', [AccountController::class, 'deleteAccount']);
    Route::post('/getProjectData', [ProjectController::class, 'getProjectData']);
});
