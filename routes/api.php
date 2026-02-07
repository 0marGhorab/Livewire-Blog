<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\PostApiController;

Route::middleware('guest')->group(function () {
    Route::post('/register', [AuthApiController::class, 'register']);
    Route::post('/login', [AuthApiController::class, 'login']);
});

Route::middleware('auth:web')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::put('/user', [AuthApiController::class, 'updateProfile']);

    // Posts CRUD
    Route::get('/posts', [PostApiController::class, 'index']);
    Route::get('/posts/{post}', [PostApiController::class, 'show']);
    Route::post('/posts', [PostApiController::class, 'store']);
    Route::put('/posts/{post}', [PostApiController::class, 'update']);
    Route::delete('/posts/{post}', [PostApiController::class, 'destroy']);

    // Post images
    Route::get('/posts/{post}/images', [PostApiController::class, 'images']);
    Route::post('/posts/{post}/images', [PostApiController::class, 'storeImages']);
    Route::delete('/posts/{post}/images/{image}', [PostApiController::class, 'destroyImage']);

    // Likes
    Route::post('/posts/{post}/like', [PostApiController::class, 'like']);
    Route::delete('/posts/{post}/like', [PostApiController::class, 'unlike']);

    // Comments
    Route::get('/posts/{post}/comments', [PostApiController::class, 'comments']);
    Route::post('/posts/{post}/comments', [PostApiController::class, 'storeComment']);

    // Analytics
    Route::get('/posts/{post}/analytics', [PostApiController::class, 'analytics']);
});