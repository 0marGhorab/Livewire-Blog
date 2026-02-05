<?php

use App\Livewire\PostForm;
use App\Livewire\AdminPosts;
use App\Livewire\UserPosts;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/test-images', function() {
//     $posts = \App\Models\Post::with('images')->get();
    
//     foreach($posts as $post) {
//         echo "<h2>Post #{$post->id}: {$post->title}</h2>";
//         echo "<p>Images count: {$post->images->count()}</p>";
        
//         if($post->images->count() > 0) {
//             echo "<div style='display: flex; gap: 10px;'>";
//             foreach($post->images as $image) {
//                 $url = Storage::url($image->path);
//                 echo "<div>";
//                 echo "<img src='{$url}' style='width: 200px; height: 200px; object-fit: cover;'>";
//                 echo "<p>Path: {$image->path}</p>";
//                 echo "</div>";
//             }
//             echo "</div>";
//         }
//         echo "<hr>";
//     }
// })->middleware('auth');

Route::middleware(['auth', 'verified'])->group(function () {
    // Delete post
    Route::delete('/posts/{post}', function (\App\Models\Post $post) {
        // Authorization
        if (auth()->id() !== $post->user_id && !auth()->user()->is_admin) {
            abort(403);
        }
        
        $post->delete();
        return redirect()->route('dashboard')->with('message', 'Post deleted successfully!');
    })->name('posts.destroy');

    Route::get('/dashboard', function () {
        $posts = \App\Models\Post::with(['user', 'images'])
            ->latest()
            ->paginate(15);
        if (auth()->user()->is_admin) {
            return view('admin.dashboard', compact('posts'));
        }
        return view('user.dashboard', compact('posts'));
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