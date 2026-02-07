<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="text-brand-primary">
    <form wire:submit="register">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-brand-primary" />
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full border-brand-primary/30 focus:border-brand-primary focus:ring-brand-primary rounded-md shadow-sm" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-brand-primary" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full border-brand-primary/30 focus:border-brand-primary focus:ring-brand-primary rounded-md shadow-sm" type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-brand-primary" />

            <x-text-input wire:model="password" id="password" class="block mt-1 w-full border-brand-primary/30 focus:border-brand-primary focus:ring-brand-primary rounded-md shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-brand-primary" />

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full border-brand-primary/30 focus:border-brand-primary focus:ring-brand-primary rounded-md shadow-sm"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <a class="underline text-sm hover:opacity-90 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary" href="{{ route('login') }}" wire:navigate>
                {{ __('Already have an account? Log in') }}
            </a>
            <button
                type="submit"
                class="btn-3d inline-flex items-center justify-center px-4 py-2 rounded-lg font-semibold text-sm text-white uppercase tracking-widest bg-brand-primary hover:bg-brand-primary-hover focus:bg-brand-primary-hover active:bg-brand-primary-hover focus:outline-none focus:ring-2 focus:ring-brand-primary focus:ring-offset-2 transition duration-150"
            >
                {{ __('Register') }}
            </button>
        </div>
    </form>
</div>
