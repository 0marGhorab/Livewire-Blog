<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\Like;
use Livewire\Component;

class LikeButton extends Component
{
    public $postId;
    public $likesCount;
    public $isLiked;

    public function mount($postId)
    {
        $this->postId = $postId;
        $this->updateLikeStatus();
    }

    public function toggleLike()
    {
        $userId = auth()->id();

        $existingLike = Like::where('user_id', $userId)
            ->where('post_id', $this->postId)
            ->first();

        if ($existingLike) {
            // Unlike
            $existingLike->delete();
        } else {
            // Like
            Like::create([
                'user_id' => $userId,
                'post_id' => $this->postId,
            ]);
        }

        $this->updateLikeStatus();
    }

    private function updateLikeStatus()
    {
        $post = Post::find($this->postId);
        $this->likesCount = $post->likesCount();
        $this->isLiked = $post->isLikedByUser(auth()->id());
    }

    public function render()
    {
        return view('livewire.like-button');
    }
}