<div class="space-y-4 text-brand-primary">
    <h3 class="text-xl font-bold text-brand-primary">Comments ({{ $comments->count() }})</h3>

    <!-- Add Comment Form -->
    <form wire:submit="addComment" class="space-y-2">
        <textarea
            wire:model="body"
            rows="3"
            placeholder="Write a comment..."
            class="w-full border border-brand-primary/30 rounded-lg px-3 py-2 focus:border-brand-primary focus:ring-brand-primary"
        ></textarea>
        @error('body') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

        <button type="submit" class="bg-brand-primary text-white px-4 py-2 rounded-lg hover:bg-brand-primary-hover transition">
            Post Comment
        </button>
    </form>

    <!-- Comments List -->
    <div class="space-y-3">
        @forelse($comments as $comment)
            <div class="rounded-lg p-4 transition-all duration-300 hover:shadow-md border border-brand-primary/10 bg-brand-secondary/20 animate-fade-in-up"
                 style="animation-delay: {{ $loop->index * 60 }}ms">
                <div class="flex justify-between items-start mb-2">
                    <span class="font-semibold text-brand-primary">{{ $comment->user->name }}</span>
                    <span class="text-sm text-brand-primary/70">{{ $comment->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-brand-primary/90">{{ $comment->body }}</p>
            </div>
        @empty
            <p class="text-brand-primary/70 italic animate-fade-in">No comments yet. Be the first to comment!</p>
        @endforelse
    </div>
</div>