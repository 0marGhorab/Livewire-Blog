<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class AdminPosts extends Component
{
    use WithPagination;

    public function deletePost($postId)
    {
        $post = Post::findOrFail($postId);
        $post->delete();
        
        session()->flash('message', 'Post deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin-posts', [
            'posts' => Post::with('user')->latest()->paginate(10)
        ]);
    }
}