<div class="inline-flex items-center gap-2">
    <button 
        wire:click="toggleLike"
        class="flex items-center gap-1 px-3 py-1 rounded transition-all duration-200 {{ $isLiked ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}"
    >
        <svg class="w-5 h-5" fill="{{ $isLiked ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
        </svg>
        <span class="font-medium">{{ $likesCount }}</span>
    </button>
</div>