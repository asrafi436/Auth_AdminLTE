<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;



// Route::group(['prefix' => 'auth'], function ($route) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
// });

Route::middleware('auth:api')->group(function () {
    // Route::get('profile', [AuthController::class, 'profile']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('profile/{id}', [AuthController::class, 'getProfileById']);

    // Product CRUD Routes (for API)
    Route::resource('products', ProductController::class);
});
