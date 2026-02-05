<div class="container mx-auto p-6 mt-12 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">
        {{ $isEditing ? 'Edit Post' : 'Create New Post' }}
    </h2>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit="save" class="space-y-4">
        <!-- Title Field -->
        <div>
            <label class="block text-sm font-medium mb-1">Title</label>
            <input 
                type="text" 
                wire:model="title" 
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Body Field -->
        <div>
            <label class="block text-sm font-medium mb-1">Body</label>
            <textarea 
                wire:model="body" 
                rows="5" 
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            ></textarea>
            @error('body') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        @if($isEditing && $post->images->count() > 0)
            <div>
                <label class="block text-sm font-medium mb-2">Current Images</label>
                <div class="grid grid-cols-3 gap-4">
                    @foreach($post->images as $image)
                        <div class="relative">
                            <img src="{{ Storage::url($image->path) }}" class="w-full h-32 object-cover rounded">
                            <button 
                                type="button" 
                                wire:click="removeImage({{ $image->id }})"
                                class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1 hover:bg-red-700"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Image Upload Field -->
        <div>
            <label class="block text-sm font-medium mb-1">Upload Images (max 10)</label>
            <input type="file" wire:model="images" multiple accept="image/*" class="w-full border rounded px-3 py-2">
            @error('images.*') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            
            <div wire:loading wire:target="images" class="text-sm text-gray-600 mt-1">
                Uploading...
            </div>
            
            <!-- Preview new images -->
            @if (!empty($images))
                <div class="grid grid-cols-4 gap-4 mt-2">
                    @foreach($images as $image)
                        <img src="{{ $image->temporaryUrl() }}" class="w-full h-16 object-contain rounded">
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Submit and Cancel Buttons -->
        <div class="flex gap-2">
            <button 
                type="submit" 
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
            >
                {{ $isEditing ? 'Update Post' : 'Create Post' }}
            </button>
            <a 
                href="{{ route('dashboard') }}" 
                class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500 transition"
            >
                Cancel
            </a>
        </div>
    </form>
</div>