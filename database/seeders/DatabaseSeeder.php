<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use App\Models\PostView;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'is_admin' => true,
        ]);

        // Create normal users
        $user1 = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@test.com',
        ]);

        $user2 = User::factory()->create([
            'name' => 'Test User 2',
            'email' => 'test2@test.com',
        ]);

        // Create more users for interaction
        $users = User::factory(5)->create();

        // Create posts
        $posts = collect([
            Post::create([
                'title' => 'Getting Started with Laravel',
                'body' => 'Laravel is an amazing PHP framework that makes web development a breeze. In this post, we will explore the basics.',
                'user_id' => $user1->id,
            ]),
            Post::create([
                'title' => 'Livewire Tips and Tricks',
                'body' => 'Livewire allows you to build dynamic interfaces without leaving PHP. Here are some advanced tips.',
                'user_id' => $user2->id,
            ]),
            Post::create([
                'title' => 'Tailwind CSS Best Practices',
                'body' => 'Tailwind CSS is a utility-first CSS framework. Let me share some best practices I have learned.',
                'user_id' => $admin->id,
            ]),
        ]);

        // Add some likes
        foreach ($posts as $post) {
            // Random users like each post
            $randomUsers = $users->random(rand(1, 3));
            foreach ($randomUsers as $user) {
                Like::create([
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                ]);
            }
            
            // Admin likes all posts
            Like::create([
                'user_id' => $admin->id,
                'post_id' => $post->id,
            ]);
        }

        // Add some comments
        $commentBodies = [
            'Great post! Very helpful.',
            'Thanks for sharing this.',
            'I learned a lot from this.',
            'Can you explain more about this topic?',
            'Awesome content!',
        ];

        foreach ($posts as $post) {
            // Each post gets 2-4 comments
            $numComments = rand(2, 4);
            for ($i = 0; $i < $numComments; $i++) {
                Comment::create([
                    'user_id' => $users->random()->id,
                    'post_id' => $post->id,
                    'body' => $commentBodies[array_rand($commentBodies)],
                ]);
            }
        }

        // Add some views
        foreach ($posts as $post) {
            // Random users view each post
            $viewers = $users->random(rand(3, 5));
            foreach ($viewers as $viewer) {
                PostView::create([
                    'user_id' => $viewer->id,
                    'post_id' => $post->id,
                ]);
            }
        }
    }
}