<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }} - Patient</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100">
        @include('layouts.sidebar-patient')

        <div class="lg:ml-64">
            <nav class="bg-white border-b border-gray-100 sticky top-0 z-30">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')" class="lg:hidden p-2 text-gray-600 hover:text-gray-900">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                            </button>
                            <h1 class="ml-3 text-lg font-semibold text-gray-800">Patient Dashboard</h1>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="text-sm text-gray-600">{{ Auth::user()->name }}</span>
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                </button>
                                <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Log Out</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <main class="p-6">
                @isset($header)
                    <div class="mb-6">
                        {{ $header }}
                    </div>
                @endisset
                {{ $slot }}
            </main>
        </div>

        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </body>
</html>
