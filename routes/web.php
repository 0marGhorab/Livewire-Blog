<?php

use App\Livewire\PostForm;
use App\Livewire\AdminPosts;
use App\Livewire\UserPosts;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard - shows different view based on user role
    Route::get('/dashboard', function () {
        if (auth()->user()->is_admin) {
            return view('admin.dashboard');
        }
        return view('user.dashboard');
    })->name('dashboard');
    
    // Create new post
    Route::get('/posts/create', PostForm::class)->name('posts.create');
    
    // Edit post
    Route::get('/posts/{postId}/edit', PostForm::class)->name('posts.edit');
    
    // Profile routes (from Breeze)
    Route::view('profile', 'profile')->name('profile');
});

require __DIR__.'/auth.php';