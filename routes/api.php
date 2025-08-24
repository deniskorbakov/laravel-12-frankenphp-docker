<?php

declare(strict_types=1);

use App\Http\Controllers\Api\EmailVerificationController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:limit'])->group(static function (): void {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::group(['prefix' => 'users'], static function (): void {
        Route::get('/roles', [UserController::class, 'roles']);
    });

    Route::middleware(['auth:sanctum'])->group(static function (): void {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/ws/auth', [AuthController::class, 'WSAuth']);

        Route::group(['prefix' => 'emails'], static function (): void {
            Route::get('/send-verify-code', [EmailVerificationController::class, 'send']);
            Route::post('/verify-code', [EmailVerificationController::class, 'verify'])->middleware('throttle:verify-code');
        });

        Route::group(['prefix' => 'users'], static function (): void {
            Route::get('/{userId}', [UserController::class, 'show']);
            Route::post('/{userId}', [UserController::class, 'update'])->middleware('checkUserOwnership');
        });
    });
});
