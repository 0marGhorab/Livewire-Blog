<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\PostImage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class PostForm extends Component
{
    use WithFileUploads;

    public ?Post $post = null;
    public $title = '';
    public $body = '';
    public $images = []; // Multiple images
    public $isEditing = false;

    protected $rules = [
        'title' => 'required|min:3|max:255',
        'body' => 'required|min:10',
        'images.*' => 'nullable|image|max:2048',
    ];

    public function mount(?Post $post = null)
    {
        if ($post) {
            $this->isEditing = true;
            
            if (auth()->id() !== $post->user_id && !auth()->user()->is_admin) {
                abort(403);
            }
            
            $this->post = $post->load('images');
            $this->title = $post->title;
            $this->body = $post->body;
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditing) {
            $this->post->update([
                'title' => $this->title,
                'body' => $this->body,
            ]);

            $post = $this->post;
        } else {
            $post = Post::create([
                'title' => $this->title,
                'body' => $this->body,
                'user_id' => auth()->id(),
            ]);
        }

        // Handle multiple image uploads
        if (!empty($this->images)) {
            $maxOrder = $post->images()->max('order') ?? -1;
            
            foreach ($this->images as $index => $image) {
                $path = $image->store('posts', 'public');
                
                PostImage::create([
                    'post_id' => $post->id,
                    'path' => $path,
                    'order' => $maxOrder + $index + 1,
                ]);
            }
        }

        session()->flash('message', $this->isEditing ? 'Post updated successfully!' : 'Post created successfully!');
        
        return redirect()->route('dashboard');
    }

    public function removeImage($imageId)
    {
        $image = PostImage::findOrFail($imageId);
        
        if ($this->post && $image->post_id === $this->post->id) {
            $image->delete();
            $this->post->refresh();
            session()->flash('message', 'Image removed successfully!');
        }
    }

    public function render()
    {
        return view('livewire.post-form')
            ->layout('layouts.app');
    }
}