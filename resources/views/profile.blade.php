<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-brand-primary leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg animate-fade-in-up transition-shadow duration-300 hover:shadow-md" style="animation-delay: 0ms">
                <div class="max-w-xl">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg animate-fade-in-up transition-shadow duration-300 hover:shadow-md" style="animation-delay: 100ms">
                <div class="max-w-xl">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg animate-fade-in-up transition-shadow duration-300 hover:shadow-md" style="animation-delay: 200ms">
                <div class="max-w-xl">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
