<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Analytics') }}: {{ $post->title }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-6xl mx-auto space-y-8 px-4">

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6" 
             x-data="{ show: false }" 
             x-init="setTimeout(() => show = true, 100)">
            
            <!-- Total Views -->
            @php
                $viewsCount = $post->viewsCount();
                $likesCount = $post->likesCount();
                $commentsCount = $post->commentsCount();
            @endphp
            
            <div x-show="show" x-transition.duration.500ms
                 class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg p-6 shadow-lg transform transition hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Total Views</p>
                        <p class="text-4xl font-bold mt-2" 
                           x-data="{ count: 0, target: {{ $viewsCount }} }" 
                           x-init="
                            setTimeout(() => {
                                let increment = Math.max(1, target / 50);
                                let current = 0;
                                let timer = setInterval(() => {
                                    current += increment;
                                    if (current >= target) { current = target; clearInterval(timer); }
                                    count = Math.floor(current);
                                }, 20);
                            }, 200)">
                            <span x-text="count"></span>
                        </p>
                    </div>
                    <svg class="w-12 h-12 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
            </div>

            <!-- Total Likes -->
            <div x-show="show" x-transition.delay.100ms.duration.500ms
                 class="bg-gradient-to-br from-red-500 to-red-600 text-white rounded-lg p-6 shadow-lg transform transition hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm font-medium">Total Likes</p>
                        <p class="text-4xl font-bold mt-2" 
                           x-data="{ count: 0, target: {{ $likesCount }} }" 
                           x-init="
                            setTimeout(() => {
                                let increment = Math.max(1, target / 50);
                                let current = 0;
                                let timer = setInterval(() => {
                                    current += increment;
                                    if (current >= target) { current = target; clearInterval(timer); }
                                    count = Math.floor(current);
                                }, 20);
                            }, 300)">
                            <span x-text="count"></span>
                        </p>
                    </div>
                    <svg class="w-12 h-12 text-red-200" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Total Comments -->
            <div x-show="show" x-transition.delay.200ms.duration.500ms
                 class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-lg p-6 shadow-lg transform transition hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Total Comments</p>
                        <p class="text-4xl font-bold mt-2" 
                           x-data="{ count: 0, target: {{ $commentsCount }} }" 
                           x-init="
                            setTimeout(() => {
                                let increment = Math.max(1, target / 50);
                                let current = 0;
                                let timer = setInterval(() => {
                                    current += increment;
                                    if (current >= target) { current = target; clearInterval(timer); }
                                    count = Math.floor(current);
                                }, 20);
                            }, 400)">
                            <span x-text="count"></span>
                        </p>
                    </div>
                    <svg class="w-12 h-12 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Comments List -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold mb-4">All Comments</h2>
            
            @if($post->comments->count() > 0)
                <div class="space-y-4">
                    @foreach($post->comments as $comment)
                        <div class="border-l-4 border-blue-500 bg-gray-50 p-4 rounded">
                            <div class="flex justify-between items-start mb-2">
                                <span class="font-semibold text-gray-900">{{ $comment->user->name }}</span>
                                <span class="text-sm text-gray-500">{{ $comment->created_at->format('M d, Y - h:i A') }}</span>
                            </div>
                            <p class="text-gray-700">{{ $comment->body }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 italic">No comments yet on this post.</p>
            @endif
        </div>

        <!-- Back Button -->
        <div class="mt-6">
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">← Back to Dashboard</a>
        </div>
    </div>
</x-app-layout>