@php
    use Illuminate\Support\Facades\Storage;
@endphp

<div class="max-w-4xl mx-auto">
    <div class="space-y-4">
        @forelse ($posts as $post)
            <div class="border border-brand-primary/20 rounded-xl p-10 bg-white/80 hover:shadow-lg transition-all duration-300 animate-fade-in-up"
                 style="animation-delay: {{ $loop->index * 70 }}ms">

                {{-- Post Images --}}
                @if($post->images && $post->images->count() > 0)
                    @php
                        $imagesCount = $post->images->count();
                        $primaryImage = $post->images->first();
                    @endphp
                    <div class="mb-4 w-3/4 mx-auto p-2">
                        <div class="relative w-full overflow-hidden rounded-lg h-64">
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
                                    class="absolute bottom-0 right-0 w-1/3 h-3/4 bg-brand-primary flex flex-col items-center justify-center text-center text-[#faf8f7] rounded-xl m-3 shadow-xl ring-1 ring-black/5"
                                >
                                    <span class="text-sm font-semibold">
                                        {{ $imagesCount }} photos
                                    </span>
                                    <span class="text-xs opacity-90">
                                        View gallery
                                    </span>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

                <h4 class="text-xl font-bold text-brand-primary mb-2">
                    <a href="{{ route('posts.show', $post) }}" class="text-brand-primary hover:text-brand-primary-hover hover:underline">
                        {{ $post->title }}
                    </a>
                </h4>

                <p class="text-brand-primary/90 mb-3">
                    {{ Str::limit($post->body, 150) }}
                </p>

                <div class="text-sm text-brand-primary/80 mb-4">
                    <span>By {{ $post->user->name }}</span>
                    <span class="mx-2">•</span>
                    <span>{{ $post->created_at->diffForHumans() }}</span>
                </div>

                <!-- Interactive Stats -->
                <div class="flex items-center gap-6 py-4 border-t border-brand-primary/20 mb-4">
                    <!-- Like Button -->
                    <livewire:like-button :postId="$post->id" :key="'like-'.$post->id" />
                    
                    <!-- Views -->
                    <div class="flex items-center gap-1 text-brand-primary/80">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <span class="font-medium">{{ $post->viewsCount() }}</span>
                        <span class="text-sm">views</span>
                    </div>

                    <!-- Comments -->
                    <div class="flex items-center gap-1 text-brand-primary/80">
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
                       class="inline-flex items-center gap-2 bg-brand-primary text-white px-3 py-1 rounded-lg hover:bg-brand-primary-hover transition">
                        View Post
                    </a>

                    <div class="flex space-x-2">
                        <a
                            href="{{ route('posts.edit', $post) }}"
                            class="bg-brand-primary text-white px-3 py-1 rounded-lg hover:bg-brand-primary-hover transition duration-300"
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
            <p class="text-brand-primary/80 text-center py-8 animate-fade-in">
                No posts yet. Create the first one!
            </p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $posts->links() }}
    </div>
</div>