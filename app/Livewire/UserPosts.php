<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class UserPosts extends Component
{
    use WithPagination;

    public function deletePost($postId)
    {
        $post = Post::findOrFail($postId);
        
        // Only allow deleting own posts
        if ($post->user_id !== auth()->id()) {
            session()->flash('error', 'Unauthorized action.');
            return;
        }
        
        $post->delete();
        session()->flash('message', 'Post deleted successfully.');
    }

    public function render()
    {
        return view('livewire.user-posts', [
            'posts' => Post::with('user')->latest()->paginate(10)
        ]);
    }
}