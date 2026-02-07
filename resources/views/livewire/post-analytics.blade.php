<div class="max-w-6xl mx-auto py-8 px-4">
    <!-- Page header card -->
    <div class="rounded-xl border border-brand-primary/20 p-6 mb-6 shadow-sm bg-white/80 animate-page-in transition-shadow duration-300 hover:shadow-md">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h1 class="text-2xl sm:text-3xl font-bold text-brand-primary">
                Analytics: {{ $post->title }}
            </h1>
            <a href="{{ route('posts.show', $post) }}"
               class="inline-flex items-center gap-2 text-brand-primary hover:text-brand-primary-hover font-medium transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                View post
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8"
         x-data="{ show: false }"
         x-init="setTimeout(() => show = true, 100)">
        @php
            $viewsCount = $post->viewsCount();
            $likesCount = $post->likesCount();
            $commentsCount = $post->commentsCount();
        @endphp

        <!-- Total Views -->
        <div x-show="show" x-transition.duration.500ms
             class="rounded-xl border border-brand-primary/20 bg-white/80 shadow-sm p-6 transition-all duration-200 hover:shadow-lg hover:border-brand-primary/30">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-brand-primary/70 text-sm font-medium">Total Views</p>
                    <p class="text-4xl font-bold mt-2 text-brand-primary"
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
                <div class="rounded-xl p-3 bg-brand-primary/10">
                    <svg class="w-10 h-10 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Likes -->
        <div x-show="show" x-transition.delay.100ms.duration.500ms
             class="rounded-xl border border-brand-primary/20 bg-white/80 shadow-sm p-6 transition-all duration-200 hover:shadow-lg hover:border-brand-primary/30">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-brand-primary/70 text-sm font-medium">Total Likes</p>
                    <p class="text-4xl font-bold mt-2 text-brand-primary"
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
                <div class="rounded-xl p-3 bg-brand-secondary/30">
                    <svg class="w-10 h-10 text-brand-primary" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Comments -->
        <div x-show="show" x-transition.delay.200ms.duration.500ms
             class="rounded-xl border border-brand-primary/20 bg-white/80 shadow-sm p-6 transition-all duration-200 hover:shadow-lg hover:border-brand-primary/30">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-brand-primary/70 text-sm font-medium">Total Comments</p>
                    <p class="text-4xl font-bold mt-2 text-brand-primary"
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
                <div class="rounded-xl p-3 bg-brand-button-secondary/20">
                    <svg class="w-10 h-10 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Comments List -->
    <div class="rounded-xl border border-brand-primary/20 p-6 shadow-sm bg-white/80 animate-fade-in-up animation-delay-200 transition-shadow duration-300 hover:shadow-md">
        <h2 class="text-xl font-bold mb-4 text-brand-primary">All Comments</h2>

        @if($post->comments->count() > 0)
            <div class="space-y-3">
                @foreach($post->comments as $comment)
                    <div class="rounded-lg p-4 border border-brand-primary/10 bg-brand-secondary/20 transition-all duration-200 hover:shadow-md animate-fade-in-up"
                         style="animation-delay: {{ 250 + $loop->index * 50 }}ms">
                        <div class="flex justify-between items-start mb-2">
                            <span class="font-semibold text-brand-primary">{{ $comment->user->name }}</span>
                            <span class="text-sm text-brand-primary/70">{{ $comment->created_at->format('M d, Y') }} · {{ $comment->created_at->format('h:i A') }}</span>
                        </div>
                        <p class="text-brand-primary/90">{{ $comment->body }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-brand-primary/70 italic">No comments yet on this post.</p>
        @endif
    </div>

    <!-- Back link -->
    <div class="mt-6">
        <a href="{{ route('dashboard') }}" class="text-brand-primary hover:text-brand-primary-hover hover:underline transition-colors duration-200">← Back to Dashboard</a>
    </div>
</div>
