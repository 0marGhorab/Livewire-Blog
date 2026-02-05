<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $fillable = ['title', 'body', 'user_id'];

    protected $with = ['images'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(PostView::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PostImage::class)->orderBy('order');
    }

    public function primaryImage()
    {
        return $this->images()->orderBy('order')->first();
    }

    // Helper methods
    public function isLikedByUser($userId): bool
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    public function likesCount(): int
    {
        return $this->likes()->count();
    }

    public function viewsCount(): int
    {
        return $this->views()->count();
    }

    public function commentsCount(): int
    {
        return $this->comments()->count();
    }

    // Auto-delete related data when post is deleted
    protected static function booted(): void
    {
        static::deleting(function (Post $post) {
            // Delete all images (files + records)
            $post->images()->each(function ($image) {
                $image->delete(); // Triggers PostImage's deleting event
            });
            
            // Delete other relationships
            $post->likes()->delete();
            $post->comments()->delete();
            $post->views()->delete();
        });
    }
}