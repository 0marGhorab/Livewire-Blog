<div class="space-y-4">
    <h3 class="text-xl font-bold">Comments ({{ $comments->count() }})</h3>

    <!-- Add Comment Form -->
    <form wire:submit="addComment" class="space-y-2">
        <textarea 
            wire:model="body" 
            rows="3" 
            placeholder="Write a comment..."
            class="w-full border rounded px-3 py-2"
        ></textarea>
        @error('body') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Post Comment
        </button>
    </form>

    <!-- Comments List -->
    <div class="space-y-3">
        @forelse($comments as $comment)
            <div class="bg-gray-50 rounded p-4 transition-all duration-300 hover:shadow-md">
                <div class="flex justify-between items-start mb-2">
                    <span class="font-semibold text-gray-900">{{ $comment->user->name }}</span>
                    <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-gray-700">{{ $comment->body }}</p>
            </div>
        @empty
            <p class="text-gray-500 italic">No comments yet. Be the first to comment!</p>
        @endforelse
    </div>
</div>