<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'App'))</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @vite(['resources/css/app.css','resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#FDFDFC] text-[#1b1b18] antialiased">
        <header class="border-b border-[#e3e3e0] bg-white/70 backdrop-blur">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <x-nav />
            </div>
        </header>

        <main class="min-h-[calc(100vh-4rem)] flex flex-col">
            <div class="w-full">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
                    <x-flash />
                </div>
            </div>
            <div class="flex-1 w-full">
                @yield('content')
            </div>
        </main>

        <footer class="mt-12 py-8 text-sm text-[#706f6c] border-t border-[#e3e3e0]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'App') }}. All rights reserved.</p>
            </div>
        </footer>
    </body>
    </html>
