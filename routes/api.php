<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChargesController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\SaccosController;
use App\Http\Controllers\StationsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VehiclesController;
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

Route::middleware('auth:sanctum')->group(function () {
    // Users
    Route::resource('users', UsersController::class);
    Route::prefix('users')->name('users.')->group(function () {
        Route::post('{user}/deactivate', [UsersController::class, 'deactivate'])->name('deactivate');
        Route::get('{user}/saccos', [UsersController::class, 'getSaccos'])->name('saccos');
        Route::get('{user}/vehicles', [UsersController::class, 'getVehicles'])->name('vehicles');
    });

    // Sacco
    Route::resource('saccos', SaccosController::class);
    Route::prefix('saccos')->name('saccos.')->group(function () {
        Route::post('{sacco}/deactivate', [SaccosController::class, 'deactivate'])->name('deactivate');
        Route::get('{sacco}/users', [SaccosController::class, 'getUsers'])->name('users');
        Route::get('{sacco}/stations', [SaccosController::class, 'getStations'])->name('stations');
        Route::get('{sacco}/vehicles', [SaccosController::class, 'getVehicles'])->name('vehicles');
        Route::get('{sacco}/charges', [SaccosController::class, 'getCharges'])->name('charges');
    });

    // Stations
    Route::resource('stations', StationsController::class);
    Route::prefix('stations')->name('stations.')->group(function () {
        Route::post('{station}/deactivate', [StationsController::class, 'deactivate'])->name('deactivate');
        Route::get('{station}/vehicles', [StationsController::class, 'getVehicles'])->name('vehicles');
    });

    // Vehicles
    Route::resource('vehicles', VehiclesController::class);
    Route::prefix('vehicles')->name('vehicles.')->group(function () {
        Route::get('{vehicle}/operators', [VehiclesController::class, 'getOperators'])->name('operators');
    });

    // Charges
    Route::resource('charges', ChargesController::class);
});
