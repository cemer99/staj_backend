<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\InstrumentController;
use App\Http\Controllers\Api\UserProfileController;
use App\Http\Controllers\Api\UserInstrumentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Instrument public routes
Route::get('/instruments', [InstrumentController::class, 'index']);
Route::post('/instruments/by-id', [InstrumentController::class, 'show']);
Route::post('/instruments/by-category', [InstrumentController::class, 'getByCategory']);
Route::get('/categories', [InstrumentController::class, 'categories']);

// User profiles public routes
Route::get('/profiles', [UserProfileController::class, 'index']);
Route::post('/profiles/by-id', [UserProfileController::class, 'show']);
Route::get('/cities', [UserProfileController::class, 'cities']);
Route::post('/cities/districts', [UserProfileController::class, 'getDistricts']);

// Test route
Route::get('/test', [App\Http\Controllers\Api\TestController::class, 'index']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    
    // User profile management
    Route::put('/my-profile', [UserProfileController::class, 'update']);
    
    // User instruments management
    Route::get('/my-instruments', [App\Http\Controllers\Api\UserInstrumentControllerNew::class, 'index']);
    Route::post('/my-instruments', [App\Http\Controllers\Api\UserInstrumentControllerNew::class, 'store']);
    Route::put('/my-instruments-update', [App\Http\Controllers\Api\UserInstrumentControllerNew::class, 'update']);
    Route::delete('/my-instruments-delete', [App\Http\Controllers\Api\UserInstrumentControllerNew::class, 'destroy']);
    
    // Admin routes (instrument management)
    Route::middleware('admin')->group(function () {
        Route::post('/instruments', [InstrumentController::class, 'store']);
        Route::put('/instruments-update-admin', [InstrumentController::class, 'update']);
        Route::delete('/instruments-delete-admin', [InstrumentController::class, 'destroy']);
    });
});
