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

    /** @var array<int> Order of image IDs for drag-and-drop reordering */
    public array $imageOrder = [];

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
            $this->imageOrder = $post->images->sortBy('order')->pluck('id')->values()->all();
        }
    }

    public function reorderImages(array $orderedIds): void
    {
        if (! $this->isEditing || ! $this->post) {
            return;
        }
        $validIds = $this->post->images->pluck('id')->all();
        $orderedIds = array_values(array_intersect($orderedIds, $validIds));
        if (count($orderedIds) === count($validIds)) {
            $this->imageOrder = $orderedIds;
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

            foreach (array_values($this->imageOrder) as $position => $imageId) {
                PostImage::where('id', $imageId)->where('post_id', $this->post->id)->update(['order' => $position]);
            }

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
            $this->imageOrder = array_values(array_filter($this->imageOrder, fn (int $id) => $id !== (int) $imageId));
            $this->post->refresh();
            session()->flash('message', 'Image removed successfully!');
        }
    }

    public function getOrderedImages(): \Illuminate\Support\Collection
    {
        if (! $this->post || empty($this->imageOrder)) {
            return $this->post?->images->sortBy('order') ?? collect();
        }
        $byId = $this->post->images->keyBy('id');

        return collect($this->imageOrder)->map(fn (int $id) => $byId->get($id))->filter()->values();
    }

    public function render()
    {
        $orderedImages = $this->getOrderedImages();

        return view('livewire.post-form', [
            'orderedImages' => $orderedImages,
            'imageOrder' => $this->imageOrder,
            'imagesById' => $orderedImages->keyBy('id')->map(fn ($img) => [
                'id' => $img->id,
                'url' => Storage::url($img->path),
            ])->all(),
        ])->layout('layouts.app');
    }
}