<?php

declare(strict_types=1);

use App\Http\Controllers\Api\EmailVerificationController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['throttle:limit'])->group(static function (): void {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::group(['prefix' => 'users'], static function (): void {
        Route::get('/roles', [UserController::class, 'roles'])->name('roles');
    });

    Route::middleware(['auth:sanctum'])->group(static function (): void {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/ws/auth', [AuthController::class, 'WSAuth'])->name('ws-auth');

        Route::group(['prefix' => 'emails'], static function (): void {
            Route::get('/send-verify-code', [EmailVerificationController::class, 'send'])
                ->name('emails.send-code');
            Route::post('/verify-code', [EmailVerificationController::class, 'verify'])
                ->middleware('throttle:verify-code')
                ->name('emails.verify-code');
        });

        Route::middleware('verifyEmail')->group(static function (): void {
            Route::group(['prefix' => 'users'], static function (): void {
                Route::get('/{userId}', [UserController::class, 'show'])
                    ->name('users.show');
                Route::post('/{userId}', [UserController::class, 'update'])
                    ->name('users.update')
                    ->middleware('checkUserOwnership');
            });
        });
    });
});
