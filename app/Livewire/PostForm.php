<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class PostForm extends Component
{
    public $postId = null;
    public $title = '';
    public $body = '';
    public $isEditing = false;

    protected $rules = [
        'title' => 'required|min:3|max:255',
        'body' => 'required|min:10',
    ];

    public function mount($postId = null)
    {
        if ($postId) {
            $post = Post::findOrFail($postId);
            
            // Check if user owns the post (unless admin)
            if ($post->user_id !== auth()->id() && !auth()->user()->is_admin) {
                abort(403, 'Unauthorized action.');
            }
            
            $this->postId = $post->id;
            $this->title = $post->title;
            $this->body = $post->body;
            $this->isEditing = true;
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditing) {
            $post = Post::findOrFail($this->postId);
            
            // Check ownership again
            if ($post->user_id !== auth()->id() && !auth()->user()->is_admin) {
                session()->flash('error', 'Unauthorized action.');
                return;
            }
            
            $post->update([
                'title' => $this->title,
                'body' => $this->body,
            ]);
            
            session()->flash('message', 'Post updated successfully.');
        } else {
            Post::create([
                'title' => $this->title,
                'body' => $this->body,
                'user_id' => auth()->id(),
            ]);
            
            session()->flash('message', 'Post created successfully.');
        }

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.post-form')
            ->layout('layouts.app');
    }
}