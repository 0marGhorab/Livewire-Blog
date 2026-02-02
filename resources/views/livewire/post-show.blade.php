@php
    use Illuminate\Support\Facades\Storage;
@endphp

<div class="max-w-4xl mx-auto py-8 px-4">
    <!-- Post Header -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>
        
        <div class="flex items-center gap-4 text-sm text-gray-600 mb-4">
            <span>By {{ $post->user->name }}</span>
            <span>•</span>
            <span>{{ $post->created_at->format('M d, Y') }}</span>
        </div>

        <!-- Post Image -->
        @if($post->image)
            <div class="w-full mb-6 overflow-hidden rounded-lg bg-gray-100">
                <img 
                    src="{{ Storage::url($post->image) }}" 
                    alt="{{ $post->title }}" 
                    class="w-full h-auto object-contain max-h-96"
                >
            </div>
        @endif

        <!-- Post Body -->
        <div class="prose max-w-none mb-6">
            <p class="text-gray-700 whitespace-pre-line">{{ $post->body }}</p>
        </div>

        <!-- Stats Row -->
        <div class="flex items-center gap-6 py-4 border-t border-gray-200">
            <!-- Likes -->
            <livewire:like-button :postId="$post->id" :key="'like-'.$post->id" />
            
            <!-- Views -->
            <div class="flex items-center gap-1 text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                <span class="font-medium">{{ $post->viewsCount() }}</span>
                <span class="text-sm">views</span>
            </div>

            <!-- Comments Count -->
            <div class="flex items-center gap-1 text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                </svg>
                <span class="font-medium">{{ $post->commentsCount() }}</span>
                <span class="text-sm">comments</span>
            </div>
        </div>

        <!-- Analytics Button (only for post owner) -->
        @if(auth()->id() === $post->user_id)
            <div class="mt-4 pt-4 border-t border-gray-200">
                <a href="{{ route('posts.analytics', $post) }}" 
                   class="inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    View Analytics Dashboard
                </a>
            </div>
        @endif
    </div>

    <!-- Comments Section -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <livewire:comment-section :postId="$post->id" :key="'comments-'.$post->id" />
    </div>

    <!-- Back Button -->
    <div class="mt-6">
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">← Back to Dashboard</a>
    </div>
</div>