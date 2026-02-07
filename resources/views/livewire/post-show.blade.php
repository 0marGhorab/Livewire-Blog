@php
    use Illuminate\Support\Facades\Storage;
@endphp

<div class="max-w-4xl mx-auto py-8 px-4">
    <!-- Post Header -->
    <div class="rounded-xl border border-brand-primary/20 p-6 mb-6 shadow-sm bg-white/80 animate-page-in transition-shadow duration-300 hover:shadow-md">
        <h1 class="text-3xl font-bold mb-4 text-brand-primary">{{ $post->title }}</h1>

        <div class="flex items-center gap-4 text-sm text-brand-primary/80 mb-4">
            <span>By {{ $post->user->name }}</span>
            <span>•</span>
            <span>{{ $post->created_at->format('M d, Y') }}</span>
        </div>

        <!-- Post Images -->
        @if($post->images && $post->images->count() > 0)
            <div class="mb-6 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
                @foreach($post->images as $image)
                    <div class="overflow-hidden rounded-xl border border-brand-primary/15 bg-white/90 shadow-lg ring-1 ring-black/5 p-1.5 animate-fade-in-up transition-transform duration-200 hover:scale-[1.02]"
                         style="animation-delay: {{ $loop->index * 50 }}ms">
                        <img
                            src="{{ Storage::url($image->path) }}"
                            alt="{{ $post->title }}"
                            class="w-full h-auto object-contain max-h-40 rounded-lg"
                        >
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Post Body -->
        <div class="prose max-w-none mb-6">
            <p class="text-brand-primary/90 whitespace-pre-line">{{ $post->body }}</p>
        </div>

        <!-- Stats Row -->
        <div class="flex items-center gap-6 py-4 border-t border-brand-primary/20">
            <livewire:like-button :postId="$post->id" :key="'like-'.$post->id" />

            <div class="flex items-center gap-1 text-brand-primary/80">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                <span class="font-medium">{{ $post->viewsCount() }}</span>
                <span class="text-sm">views</span>
            </div>

            <div class="flex items-center gap-1 text-brand-primary/80">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                </svg>
                <span class="font-medium">{{ $post->commentsCount() }}</span>
                <span class="text-sm">comments</span>
            </div>
        </div>

        <!-- Analytics Button (only for post owner) -->
        @if(auth()->id() === $post->user_id || auth()->user()->is_admin)
            <div class="mt-4 pt-4 border-t border-brand-primary/20">
                <a href="{{ route('posts.analytics', $post) }}"
                   class="inline-flex items-center gap-2 bg-brand-button-secondary text-white px-4 py-2 rounded-lg hover:bg-brand-button-secondary-hover transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    View Analytics Dashboard
                </a>
            </div>
        @endif
    </div>

    <!-- Comments Section -->
    <div class="rounded-xl border border-brand-primary/20 p-6 shadow-sm bg-white/80 animate-fade-in-up animation-delay-150 transition-shadow duration-300 hover:shadow-md">
        <livewire:comment-section :postId="$post->id" :key="'comments-'.$post->id" />
    </div>

    <!-- Back Button -->
    <div class="mt-6">
        <a href="{{ route('dashboard') }}" class="text-brand-primary hover:text-brand-primary-hover hover:underline transition-colors duration-200">← Back to Dashboard</a>
    </div>
</div>
