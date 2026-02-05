<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class PostImage extends Model
{
    protected $fillable = [
        'post_id',
        'path',
        'order',
        'caption',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Get the post that owns this image
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the full URL to the image
     */
    public function getUrlAttribute(): string
    {
        return Storage::url($this->path);
    }

    /**
     * Delete the image file from storage when model is deleted
     */
    protected static function booted(): void
    {
        static::deleting(function (PostImage $image) {
            Storage::disk('public')->delete($image->path);
        });
    }
}