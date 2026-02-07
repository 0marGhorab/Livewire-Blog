@php
    use Illuminate\Support\Facades\Storage;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center animate-fade-in">
            <h2 class="font-semibold text-xl text-brand-primary leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <a href="{{ route('posts.create') }}"
               class="bg-brand-primary text-white px-4 py-2 rounded-lg hover:bg-brand-primary-hover transition-all duration-300 shadow-md hover:shadow-lg hover:scale-[1.02] active:scale-[0.98]">
                Create New Post
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 animate-page-in">
            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4 animate-fade-in">
                    {{ session('message') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4 animate-fade-in">
                    {{ session('error') }}
                </div>
            @endif

            <div class="overflow-hidden sm:rounded-xl transition-shadow duration-300 hover:shadow-md" style="background-color: rgba(206, 106, 107, 0.3);">
                <div class="p-6 text-brand-primary">
                    <h3 class="text-lg font-semibold mb-4">All Posts</h3>
                    @livewire('user-posts')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>