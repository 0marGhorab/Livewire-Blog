<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class PostForm extends Component
{
    use WithFileUploads;

    public ?Post $post = null;
    public $title = '';
    public $body = '';
    public $image;
    public $existingImage;
    public $isEditing = false;

    protected $rules = [
        'title' => 'required|min:3|max:255',
        'body' => 'required|min:10',
        'image' => 'nullable|image|max:2048',
    ];

    public function mount(?Post $post = null)
    {
        if ($post) {
            $this->isEditing = true;
            
            if (auth()->id() !== $post->user_id && !auth()->user()->is_admin) {
                abort(403);
            }
            
            $this->post = $post;
            $this->title = $post->title;
            $this->body = $post->body;
            $this->existingImage = $post->image;
        }
    }

    public function save()
    {
        $this->validate();
        $imagePath = $this->existingImage;
        if ($this->image) {
            if ($this->existingImage) {
                Storage::disk('public')->delete($this->existingImage);
            }
            $imagePath = $this->image->store('posts', 'public');
        }

        if ($this->isEditing) {
            $this->post->update([
                'title' => $this->title,
                'body' => $this->body,
                'image' => $imagePath,
            ]);

            session()->flash('message', 'Post updated successfully!');
        } else {
            Post::create([
                'title' => $this->title,
                'body' => $this->body,
                'image' => $imagePath,
                'user_id' => auth()->id(),
            ]);

            session()->flash('message', 'Post created successfully!');
            
            $this->reset(['title', 'body', 'image']);
        }

        return redirect()->route('dashboard');
    }

    public function removeImage()
    {
        if ($this->existingImage) {
            Storage::disk('public')->delete($this->existingImage);
            
            if ($this->post) {
                $this->post->update(['image' => null]);
            }
            
            $this->existingImage = null;
            session()->flash('message', 'Image removed successfully!');
        }
    }

    public function render()
    {
        return view('livewire.post-form')->layout('layouts.app');
    }
}