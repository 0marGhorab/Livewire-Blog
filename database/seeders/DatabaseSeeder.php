<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        // Create regular users
        $user1 = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'is_admin' => false,
        ]);

        $user2 = User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => bcrypt('password'),
            'is_admin' => false,
        ]);

        // Create posts for admin
        Post::create([
            'user_id' => $admin->id,
            'title' => 'Welcome to Our Blog',
            'body' => 'This is the first post on our new blog platform. We are excited to share our thoughts and ideas with you. Stay tuned for more interesting content!',
        ]);

        Post::create([
            'user_id' => $admin->id,
            'title' => 'Getting Started with Laravel',
            'body' => 'Laravel is an amazing PHP framework that makes web development a breeze. In this post, we will explore some of the key features that make Laravel so popular among developers worldwide.',
        ]);

        // Create posts for user1
        Post::create([
            'user_id' => $user1->id,
            'title' => 'My First Blog Post',
            'body' => 'Hello everyone! This is my first blog post. I am excited to be part of this community and looking forward to sharing my experiences and learning from all of you.',
        ]);

        Post::create([
            'user_id' => $user1->id,
            'title' => 'Tips for Better Productivity',
            'body' => 'In today\'s fast-paced world, productivity is key. Here are some tips I have learned over the years: 1) Start your day early, 2) Plan your tasks, 3) Take regular breaks, 4) Stay focused on one task at a time.',
        ]);

        // Create posts for user2
        Post::create([
            'user_id' => $user2->id,
            'title' => 'The Art of Clean Code',
            'body' => 'Writing clean code is not just about making it work - it is about making it readable, maintainable, and elegant. Today I want to share some principles that have helped me write better code.',
        ]);

        Post::create([
            'user_id' => $user2->id,
            'title' => 'Learning Never Stops',
            'body' => 'As a developer, I have learned that the learning never stops. Technology evolves rapidly, and we must evolve with it. Embrace continuous learning and stay curious!',
        ]);
    }
}