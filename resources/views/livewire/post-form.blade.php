<div class="max-w-2xl mx-auto">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-900">
                {{ $isEditing ? 'Edit Post' : 'Create New Post' }}
            </h2>

            <form wire:submit="save" class="space-y-6">
                <!-- Title Field -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        Post Title
                    </label>
                    <input type="text" 
                           id="title"
                           wire:model="title" 
                           class="w-full border-gray-300 rounded-lg shadow-sm focus:border-gray-500 focus:ring focus:ring-gray-200 focus:ring-opacity-50 transition duration-300"
                           placeholder="Enter your post title">
                    @error('title') 
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Body Field -->
                <div>
                    <label for="body" class="block text-sm font-medium text-gray-700 mb-2">
                        Post Content
                    </label>
                    <textarea id="body"
                              wire:model="body" 
                              rows="10"
                              class="w-full border-gray-300 rounded-lg shadow-sm focus:border-gray-500 focus:ring focus:ring-gray-200 focus:ring-opacity-50 transition duration-300"
                              placeholder="Write your post content here..."></textarea>
                    @error('body') 
                        <span class="text-red-600 text-sm mt-1">{{ $message }}</span> 
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-between items-center">
                    <a href="{{ route('dashboard') }}" 
                       class="text-gray-600 hover:text-gray-900 transition duration-300">
                        ← Back to Dashboard
                    </a>
                    <button type="submit" 
                            class="bg-gray-900 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition duration-300">
                        {{ $isEditing ? 'Update Post' : 'Create Post' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>