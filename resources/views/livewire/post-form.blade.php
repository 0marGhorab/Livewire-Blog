@php
    use Illuminate\Support\Facades\Storage;
@endphp

<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="rounded-xl border border-brand-primary/20 p-6 shadow-sm bg-white/80 animate-page-in transition-shadow duration-300 hover:shadow-md">
        <h2 class="text-2xl font-bold mb-4 text-brand-primary">
            {{ $isEditing ? 'Edit Post' : 'Create New Post' }}
        </h2>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4 animate-fade-in">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit="save" class="space-y-4 text-brand-primary">
            <!-- Title Field -->
            <div>
                <label class="block text-sm font-medium mb-1 text-brand-primary">Title</label>
                <input
                    type="text"
                    wire:model="title"
                    class="w-full border border-brand-primary/30 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary"
                >
                @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Body Field -->
            <div>
                <label class="block text-sm font-medium mb-1 text-brand-primary">Body</label>
                <textarea
                    wire:model="body"
                    rows="5"
                    class="w-full border border-brand-primary/30 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary"
                ></textarea>
                @error('body') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            @if($isEditing && $orderedImages->isNotEmpty())
                <div
                    x-data="{
                        order: $wire.entangle('imageOrder'),
                        imagesById: @js($imagesById),
                        draggedId: null,
                        dragOverId: null,
                        moveImage(draggedId, dropTargetId) {
                            if (draggedId === dropTargetId) return;
                            const idx = this.order.indexOf(draggedId);
                            const targetIdx = this.order.indexOf(dropTargetId);
                            if (idx === -1 || targetIdx === -1) return;
                            const next = this.order.filter(id => id !== draggedId);
                            next.splice(targetIdx > idx ? targetIdx - 1 : targetIdx, 0, draggedId);
                            this.order = next;
                        }
                    }"
                    class="space-y-2"
                >
                    <label class="block text-sm font-medium mb-2 text-brand-primary">
                        Current Images
                        <span class="text-brand-primary/70 font-normal">(drag to reorder)</span>
                    </label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
                        <template x-for="id in order" :key="id">
                            <div
                                draggable="true"
                                @dragstart="draggedId = id; $event.dataTransfer.effectAllowed = 'move'; $event.dataTransfer.setData('text/plain', id)"
                                @dragend="draggedId = null; dragOverId = null"
                                @dragover.prevent="dragOverId = id"
                                @dragleave="if (dragOverId === id) dragOverId = null"
                                @drop.prevent="moveImage(draggedId, id); dragOverId = null"
                                class="relative overflow-hidden rounded-xl border border-brand-primary/15 bg-white/90 shadow-lg ring-1 ring-black/5 p-1.5 cursor-grab active:cursor-grabbing select-none transition-all duration-200 ease-out"
                                :class="{
                                    'scale-110 shadow-2xl z-50 opacity-95 ring-2 ring-brand-primary': draggedId === id,
                                    'scale-[1.02] ring-2 ring-brand-primary ring-offset-2': dragOverId === id && draggedId !== id
                                }"
                            >
                                <img
                                    :src="imagesById[id]?.url"
                                    alt=""
                                    class="w-full h-auto object-contain max-h-40 rounded-lg pointer-events-none"
                                >
                                <button
                                    type="button"
                                    @click="$wire.removeImage(id)"
                                    class="absolute top-2 right-2 bg-red-600 text-white rounded-full p-1.5 hover:bg-red-700 shadow-md transition z-10"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            @endif

            <!-- Image Upload Field -->
            <div>
                <label class="block text-sm font-medium mb-1 text-brand-primary">Upload Images (max 10)</label>
                <input type="file" wire:model="images" multiple accept="image/*" class="w-full border border-brand-primary/30 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-brand-primary file:mr-3 file:rounded-lg file:border-0 file:bg-brand-primary file:px-4 file:py-2 file:text-white file:text-sm">
                @error('images.*') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                <div wire:loading wire:target="images" class="text-sm text-brand-primary/80 mt-1">
                    Uploading...
                </div>

                <!-- Preview new images -->
                @if (!empty($images))
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4 mt-3">
                        @foreach($images as $image)
                            <div class="overflow-hidden rounded-xl border border-brand-primary/15 bg-white/90 shadow-lg ring-1 ring-black/5 p-1.5">
                                <img src="{{ $image->temporaryUrl() }}" class="w-full h-auto object-contain max-h-40 rounded-lg">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Submit and Cancel Buttons -->
            <div class="flex gap-3 pt-2">
                <button
                    type="submit"
                    class="bg-brand-primary text-white px-4 py-2 rounded-lg hover:bg-brand-primary-hover transition-all duration-200 hover:scale-[1.02] active:scale-[0.98]"
                >
                    {{ $isEditing ? 'Update Post' : 'Create Post' }}
                </button>
                <a
                    href="{{ route('dashboard') }}"
                    class="bg-brand-secondary text-brand-primary px-4 py-2 rounded-lg hover:opacity-90 transition-all duration-200 border border-brand-primary/20 hover:scale-[1.02] active:scale-[0.98]"
                >
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
