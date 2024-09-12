<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController; 
use App\Http\Controllers\Api\AdminDashboardController; 
use App\Http\Controllers\Api\AuthController; 
use App\Http\Controllers\Api\V1\UserApiController;

// Define your API routes here
Route::middleware('auth:sanctum')->get('/orders', [UserApiController::class, 'filteredOrders']);


// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Protected routes with Sanctum
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
});


// API resource for products
Route::apiResource('products', ProductController::class);

// Get authenticated user info
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

