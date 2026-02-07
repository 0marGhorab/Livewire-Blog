<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased page-bg min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0" style="font-family: 'Outfit', sans-serif;">
        <a href="{{ url('/') }}" wire:navigate class="animate-guest-logo block mb-6">
            <img
                src="{{ asset('images/logo.png') }}"
                alt="{{ config('app.name') }}"
                class="h-20 w-auto logo-no-bg sm:h-24 object-contain"
            >
        </a>

        <div class="animate-guest-form w-full sm:max-w-md px-6 py-4 sm:rounded-xl overflow-hidden" style="background-color: rgba(235, 172, 162, 0.35);">
            {{ $slot }}
        </div>
    </body>
</html>
