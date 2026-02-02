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

        <!-- Image Upload Field -->
        <div>
            <label class="block text-sm font-medium mb-1">Image (optional)</label>
            
            @if ($existingImage && !$image)
                <div class="mb-3">
                    <img src="{{ Storage::url($existingImage) }}" alt="Current image" class="w-32 h-32 object-cover rounded border">
                    <button 
                        type="button" 
                        wire:click="removeImage" 
                        class="text-red-600 text-sm mt-1 hover:underline"
                    >
                        Remove Image
                    </button>
                </div>
            @endif

            <!-- File input -->
            <input 
                type="file" 
                wire:model="image" 
                accept="image/*" 
                class="w-full border border-gray-300 rounded px-3 py-2"
            >
            @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            
            <!-- Loading indicator for image upload -->
            <div wire:loading wire:target="image" class="text-sm text-gray-600 mt-1">
                Uploading image...
            </div>
            
            <!-- Preview new image -->
            @if ($image)
                <div class="mt-2">
                    <p class="text-sm text-gray-600 mb-1">Preview:</p>
                    <img src="{{ $image->temporaryUrl() }}" class="w-32 h-32 object-cover rounded border">
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