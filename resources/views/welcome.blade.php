<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }} – Welcome</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased page-bg min-h-screen flex flex-col items-center justify-center px-4 font-['Outfit',sans-serif] relative">
        <a href="{{ url('/') }}" class="logo-float-after-in absolute left-6 top-6 sm:left-8 sm:top-8 z-10 opacity-0">
            <img
                src="{{ asset('images/logo.png') }}"
                alt="{{ config('app.name') }}"
                class="h-20 w-auto logo-no-bg sm:h-24 object-contain drop-shadow-sm"
            >
        </a>
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-brand-primary animate-welcome-title text-4xl sm:text-5xl md:text-6xl font-bold tracking-tight leading-tight">
                Welcome to my blog application
            </h1>
            <p class="text-brand-secondary animate-welcome-subtitle opacity-0 text-xl sm:text-2xl md:text-3xl font-medium mt-4 mb-12 text-balance">
                Fullstack Laravel project
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-6">
                @if (Route::has('login'))
                    <a
                        href="{{ route('login') }}"
                        class="animate-welcome-btn-left opacity-0 -translate-x-20 bg-brand-primary hover:bg-brand-primary-hover text-white inline-flex items-center justify-center px-8 py-4 rounded-xl text-base font-semibold shadow-lg hover:shadow-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-brand-primary focus:ring-offset-2"
                    >
                        Log in
                    </a>
                @endif
                @if (Route::has('register'))
                    <a
                        href="{{ route('register') }}"
                        class="animate-welcome-btn-right opacity-0 translate-x-20 bg-brand-button-secondary hover:bg-brand-button-secondary-hover text-white inline-flex items-center justify-center px-8 py-4 rounded-xl text-base font-semibold shadow-lg hover:shadow-xl transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-brand-button-secondary focus:ring-offset-2"
                    >
                        Register
                    </a>
                @endif
            </div>
        </div>
    </body>
</html>
