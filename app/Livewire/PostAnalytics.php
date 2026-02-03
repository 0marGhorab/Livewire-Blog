<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class PostAnalytics extends Component
{
    public $postId;
    public $postData;

    public function mount(Post $post)
    {
        // Only owner can access
        if (auth()->id() !== $post->user_id && !auth()->user()->is_admin) {
            abort(403, 'Unauthorized access to post analytics.');
        }

        $this->postId = $post->id;
        $this->postData = $post->load(['likes', 'comments.user', 'views'])->toArray();
    }

    public function render()
    {
        // Fetch the post fresh on each render
        $post = Post::with(['likes', 'comments.user', 'views'])
            ->findOrFail($this->postId);

        return view('livewire.post-analytics', compact('post'))
            ->layout('layouts.app');
    }
}