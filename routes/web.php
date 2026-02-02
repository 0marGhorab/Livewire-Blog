<?php

use App\Livewire\PostForm;
use App\Livewire\AdminPosts;
use App\Livewire\UserPosts;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->is_admin) {
            return view('admin.dashboard');
        }
        return view('user.dashboard');
    })->name('dashboard');
    
    // Create new post
    Route::get('/posts/create', PostForm::class)->name('posts.create');
    
    // Edit post - FIXED: Changed {postId} to {post}
    Route::get('/posts/{post}/edit', PostForm::class)->name('posts.edit');
    
    // Profile routes (from Breeze)
    Route::view('profile', 'profile')->name('profile');

    // Post Details Page (all authenticated users can view)
    Route::get('/posts/{post}', App\Livewire\PostShow::class)
        ->middleware(['auth'])
        ->name('posts.show');

    // Post Analytics Dashboard (only post owner can access)
    Route::get('/posts/{post}/analytics', App\Livewire\PostAnalytics::class)
        ->middleware(['auth'])
        ->name('posts.analytics');
});

require __DIR__.'/auth.php';