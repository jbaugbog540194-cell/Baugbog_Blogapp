<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <nav class="border-b border-gray-800 bg-gray-900">
                <div class="mx-auto flex h-[4.5rem] max-w-7xl items-center justify-between px-5 sm:px-8">
                    <a href="{{ route('posts.index') }}" class="group inline-flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-700 text-lg font-bold text-white shadow-sm shadow-red-950/30">B</span>
                        <span>
                            <span class="block text-sm font-bold tracking-tight text-gray-100">{{ config('app.name', 'Laravel') }}</span>
                            <span class="block text-xs text-gray-400">Content workspace</span>
                        </span>
                    </a>
                    <div class="flex items-center gap-5">
                        <a href="{{ route('posts.index') }}" @class([
                            'text-sm font-semibold transition',
                            'text-red-400' => request()->routeIs('posts.*'),
                            'text-gray-400 hover:text-white' => ! request()->routeIs('posts.*'),
                        ])>Posts</a>
                        @if (Route::has('login'))
                            <a href="{{ auth()->check() ? route('dashboard') : route('login') }}"
                                class="rounded-lg border border-gray-700 px-3.5 py-2 text-sm font-semibold text-gray-200 transition hover:border-gray-500 hover:bg-gray-800">
                                {{ auth()->check() ? __('Dashboard') : __('Log in') }}
                            </a>
                        @endif
                    </div>
                </div>
            </nav>

            <main class="mx-auto max-w-7xl px-5 py-8 sm:px-8 sm:py-10">
                @isset($header)
                    <header class="mb-8">
                        {{ $header }}
                    </header>
                @endisset
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
