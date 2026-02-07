<?php

use App\Models\Post;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('returns unauthenticated for api posts without login', function () {
    $response = $this->getJson('/api/posts');

    $response->assertStatus(401);
});

it('lists posts when authenticated', function () {
    Post::create([
        'title' => 'Test Post',
        'body' => 'Test body content here.',
        'user_id' => $this->user->id,
    ]);

    $response = $this->actingAs($this->user)->getJson('/api/posts');

    $response->assertStatus(200)
        ->assertJsonStructure(['data' => [['id', 'title', 'body', 'user_id', 'user', 'images']]])
        ->assertJsonPath('data.0.title', 'Test Post');
});

it('shows a single post when authenticated', function () {
    $post = Post::create([
        'title' => 'Single Post',
        'body' => 'Body of the post.',
        'user_id' => $this->user->id,
    ]);

    $response = $this->actingAs($this->user)->getJson("/api/posts/{$post->id}");

    $response->assertStatus(200)
        ->assertJsonPath('id', $post->id)
        ->assertJsonPath('title', 'Single Post');
});

it('creates a post when authenticated', function () {
    $response = $this->actingAs($this->user)->postJson('/api/posts', [
        'title' => 'New API Post',
        'body' => 'This post was created via the API.',
    ]);

    $response->assertStatus(201)
        ->assertJsonPath('title', 'New API Post');

    $this->assertDatabaseHas('posts', [
        'title' => 'New API Post',
        'user_id' => $this->user->id,
    ]);
});

it('returns current user from api user endpoint', function () {
    $response = $this->actingAs($this->user)->getJson('/api/user');

    $response->assertStatus(200)
        ->assertJsonPath('id', $this->user->id)
        ->assertJsonPath('email', $this->user->email);
});
