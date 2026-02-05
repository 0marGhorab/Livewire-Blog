@php
    use Illuminate\Support\Facades\Storage;
@endphp

<div>
    <div class="space-y-4">
        @forelse ($posts as $post)
            <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition duration-300 animate-fade-in">

                {{-- Post Images --}}
                @if($post->images && $post->images->count() > 0)
                    @php
                        $imagesCount = $post->images->count();
                        $primaryImage = $post->images->first();
                    @endphp
                    <div class="mb-4">
                        <div class="relative w-full overflow-hidden rounded-lg bg-gray-100 h-64">
                            {{-- Primary image --}}
                            <img
                                src="{{ Storage::url($primaryImage->path) }}"
                                alt="{{ $post->title }}"
                                class="w-1/2 h-full object-contain"
                            >

                            {{-- Secondary --}}
                            @if($imagesCount > 1)
                                <a
                                    href="{{ route('posts.show', $post) }}"
                                    class="absolute bottom-0 right-0 w-1/3 h-full bg-gray-900/80 text-white flex flex-col items-center justify-center text-center px-2"
                                >
                                    <span class="text-sm font-semibold">
                                        {{ $imagesCount }} photos
                                    </span>
                                    <span class="text-xs text-gray-200">
                                        View gallery
                                    </span>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                <h4 class="text-xl font-bold text-gray-900 mb-2">
                    <a href="{{ route('posts.show', $post) }}" class="text-blue-600 hover:underline">
                        {{ $post->title }}
                    </a>
                </h4>

                <p class="text-gray-600 mb-3">
                    {{ Str::limit($post->body, 150) }}
                </p>

                <div class="text-sm text-gray-500 mb-4">
                    <span>By {{ $post->user->name }}</span>
                    <span class="mx-2">•</span>
                    <span>{{ $post->created_at->diffForHumans() }}</span>
                </div>

                <!-- Interactive Stats -->
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

                <!-- Action Buttons -->
                <div class="flex items-center justify-between">
                    <a href="{{ route('posts.show', $post) }}" 
                       class="inline-flex items-center gap-2 bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition">
                        View Post
                    </a>

                    <div class="flex space-x-2">
                        <a
                            href="{{ route('posts.edit', $post) }}"
                            class="bg-gray-900 text-white px-3 py-1 rounded hover:bg-gray-700 transition duration-300"
                        >
                            Edit
                        </a>

                        <button
                            wire:click="deletePost({{ $post->id }})"
                            wire:confirm="Are you sure you want to delete this post?"
                            class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition duration-300"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-center py-8">
                No posts yet. Create the first one!
            </p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $posts->links() }}
    </div>
</div>