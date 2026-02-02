<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\Comment;
use Livewire\Component;

class CommentSection extends Component
{
    public $postId;
    public $body = '';
    public $comments;

    protected $rules = [
        'body' => 'required|min:3|max:500',
    ];

    public function mount($postId)
    {
        $this->postId = $postId;
        $this->loadComments();
    }

    public function addComment()
    {
        $this->validate();

        Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $this->postId,
            'body' => $this->body,
        ]);

        $this->body = '';
        $this->loadComments();
    }

    public function loadComments()
    {
        $this->comments = Comment::where('post_id', $this->postId)
            ->with('user')
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.comment-section');
    }
}