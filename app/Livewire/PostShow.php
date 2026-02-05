<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\PostView;
use Livewire\Component;

class PostShow extends Component
{
    public $postId;

    public function mount(Post $post)
    {
        $this->postId = $post->id;
        $this->recordView();
    }

    private function recordView()
    {
        $userId = auth()->id();
        
        $existingView = PostView::where('user_id', $userId)
            ->where('post_id', $this->postId)
            ->first();

        if (!$existingView) {
            PostView::create([
                'user_id' => $userId,
                'post_id' => $this->postId,
            ]);
        }
    }

    public function render()
    {
        // Fetch the post fresh on each render
        $post = Post::with(['user', 'images'])->findOrFail($this->postId);

        return view('livewire.post-show', compact('post'))
            ->layout('layouts.app');
    }
}