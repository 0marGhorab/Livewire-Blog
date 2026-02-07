<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;

class PostApiController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with(['user', 'images'])
            ->latest()
            ->paginate(10);

        return response()->json($posts);
    }

    public function show(Post $post)
    {
        $post->load(['user', 'images']);

        return response()->json($post);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'   => ['required', 'string', 'min:3', 'max:255'],
            'body'    => ['required', 'string', 'min:10'],
            'images.*'=> ['nullable', 'image', 'max:2048'],
        ]);

        $post = Post::create([
            'title'   => $data['title'],
            'body'    => $data['body'],
            'user_id' => $request->user()->id,
        ]);

        // optional: handle images on create
        if ($request->hasFile('images')) {
            $maxOrder = $post->images()->max('order') ?? -1;

            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('posts', 'public');

                PostImage::create([
                    'post_id' => $post->id,
                    'path'    => $path,
                    'order'   => $maxOrder + $index + 1,
                ]);
            }
        }

        return response()->json($post->load(['user', 'images']), 201);
    }

    public function update(Request $request, Post $post)
    {
        abort_unless(
            $request->user()->id === $post->user_id || $request->user()->is_admin,
            403
        );

        $data = $request->validate([
            'title' => ['sometimes', 'required', 'string', 'min:3', 'max:255'],
            'body'  => ['sometimes', 'required', 'string', 'min:10'],
        ]);

        $post->update($data);

        return response()->json($post->load(['user', 'images']));
    }

    public function destroy(Request $request, Post $post)
    {
        abort_unless(
            $request->user()->id === $post->user_id || $request->user()->is_admin,
            403
        );

        $post->delete();

        return response()->json(['message' => 'Post deleted']);
    }

    // ----- Images -----

    public function images(Post $post)
    {
        return response()->json($post->images);
    }

    public function storeImages(Request $request, Post $post)
    {
        abort_unless(
            $request->user()->id === $post->user_id || $request->user()->is_admin,
            403
        );

        $data = $request->validate([
            'images'   => ['required', 'array', 'min:1'],
            'images.*' => ['image', 'max:2048'],
        ]);

        $maxOrder = $post->images()->max('order') ?? -1;
        $created  = [];

        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('posts', 'public');

            $created[] = PostImage::create([
                'post_id' => $post->id,
                'path'    => $path,
                'order'   => $maxOrder + $index + 1,
            ]);
        }

        return response()->json($created, 201);
    }

    public function destroyImage(Request $request, Post $post, PostImage $image)
    {
        abort_unless(
            $request->user()->id === $post->user_id || $request->user()->is_admin,
            403
        );

        abort_unless($image->post_id === $post->id, 404);

        $image->delete();

        return response()->json(['message' => 'Image deleted']);
    }

    // ----- Likes -----

    public function like(Request $request, Post $post)
    {
        $like = Like::firstOrCreate([
            'user_id' => $request->user()->id,
            'post_id' => $post->id,
        ]);

        return response()->json(['liked' => true]);
    }

    public function unlike(Request $request, Post $post)
    {
        Like::where('user_id', $request->user()->id)
            ->where('post_id', $post->id)
            ->delete();

        return response()->json(['liked' => false]);
    }

    // ----- Comments -----

    public function comments(Post $post)
    {
        $comments = $post->comments()
            ->with('user')
            ->latest()
            ->get();

        return response()->json($comments);
    }

    public function storeComment(Request $request, Post $post)
    {
        $data = $request->validate([
            'body' => ['required', 'string', 'min:1'],
        ]);

        $comment = Comment::create([
            'user_id' => $request->user()->id,
            'post_id' => $post->id,
            'body'    => $data['body'],
        ]);

        return response()->json($comment->load('user'), 201);
    }

    // ----- Analytics -----

    public function analytics(Post $post)
    {
        $post->loadCount(['likes', 'comments', 'views']);

        return response()->json([
            'id'        => $post->id,
            'title'     => $post->title,
            'likes'     => $post->likes_count,
            'comments'  => $post->comments_count,
            'views'     => $post->views_count,
            'created_at'=> $post->created_at,
        ]);
    }
}