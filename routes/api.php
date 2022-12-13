<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Authentication routes
Route::middleware(['auth:sanctum', 'throttle:6,1'])->prefix('auth')->group(function () {
    Route::get('user', [AuthController::class, 'index'])->name('user');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('change-password', [AuthController::class, 'changePassword'])->name('password.change');
});

Route::middleware(['guest', 'throttle:6,1'])->prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
    Route::get('reset-password/{token}', [AuthController::class, 'resetPasswordView'])->name('password.reset');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Email verification routes
Route::middleware(['auth:sanctum', 'throttle:6,1'])->prefix('email')->group(function () {
    Route::get('verify', [EmailVerificationController::class, 'index'])->name('verification.notice');
    Route::post('verify/{id}', [EmailVerificationController::class, 'verify'])
        ->middleware('signed')->name('verification.verify');
    Route::post('resend-verification-notification', [EmailVerificationController::class, 'resend'])
        ->name('verification.resend');
});
