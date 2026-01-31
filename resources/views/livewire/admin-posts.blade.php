<div>
    <div class="space-y-4">
        @forelse ($posts as $post)
            <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition duration-300 animate-fade-in">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h4 class="text-xl font-bold text-gray-900 mb-2">{{ $post->title }}</h4>
                        <p class="text-gray-600 mb-3">{{ Str::limit($post->body, 150) }}</p>
                        <div class="text-sm text-gray-500">
                            <span>By {{ $post->user->name }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div class="flex space-x-2 ml-4">
                        <a href="{{ route('posts.edit', $post->id) }}" 
                           class="bg-gray-900 text-white px-3 py-1 rounded hover:bg-gray-700 transition duration-300">
                            Edit
                        </a>
                        <button wire:click="deletePost({{ $post->id }})" 
                                wire:confirm="Are you sure you want to delete this post?"
                                class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition duration-300">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-center py-8">No posts yet. Create the first one!</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $posts->links() }}
    </div>
</div>