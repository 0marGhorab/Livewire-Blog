<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @php
        use Illuminate\Support\Facades\Storage;
    @endphp

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @forelse($posts as $post)
                <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition duration-300">
                    <!-- Post Image -->
                    @if($post->image)
                        <div class="w-full mb-4 overflow-hidden rounded-lg bg-gray-100">
                            <img 
                                src="{{ Storage::url($post->image) }}" 
                                alt="{{ $post->title }}" 
                                class="w-full h-auto object-contain max-h-96"
                            >
                        </div>
                    @endif

                    <!-- Post Title -->
                    <h3 class="text-xl font-bold mb-2">
                        <a href="{{ route('posts.show', $post) }}" class="text-blue-600 hover:underline">
                            {{ $post->title }}
                        </a>
                    </h3>

                    <!-- Post Body -->
                    <p class="text-gray-600 mb-4">{{ Str::limit($post->body, 150) }}</p>

                    <!-- Interactive Stats Row -->
                    <div class="flex items-center gap-6 py-4 border-t border-gray-200 mb-4">
                        <!-- Like Button -->
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

                        <!-- Comments -->
                        <div class="flex items-center gap-1 text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                            <span class="font-medium">{{ $post->commentsCount() }}</span>
                            <span class="text-sm">comments</span>
                        </div>
                    </div>

                    <!-- Action Buttons Row -->
                    <div class="flex items-center justify-between">
                        <!-- View Post Button (for everyone) -->
                        <a href="{{ route('posts.show', $post) }}" 
                           class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            View Post
                        </a>

                        <div class="flex gap-2">
                            <!-- Analytics Link (only for post owner) -->
                            @if(auth()->id() === $post->user_id)
                                <a href="{{ route('posts.analytics', $post) }}" 
                                   class="inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    Analytics
                                </a>
                            @endif

                            <!-- Edit/Delete Buttons (for owner or admin) -->
                            @if(auth()->id() === $post->user_id || auth()->user()->is_admin)
                                <a href="{{ route('posts.edit', $post) }}" 
                                   class="bg-gray-900 text-white px-4 py-2 rounded hover:bg-gray-700 transition duration-300">
                                    Edit
                                </a>
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition duration-300">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-8">No posts yet. Create the first one!</p>
            @endforelse
            <div class="mt-6">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>