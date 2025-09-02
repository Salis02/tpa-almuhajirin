<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
    </head>
    <body class="flex flex-col min-h-screen dark:bg-black">
        {{-- Header --}}
        <x-header />

        {{-- Main content --}}
        <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                {{-- Contoh Card --}}
                <div class="p-4 bg-white dark:bg-neutral-900 rounded-2xl shadow-md">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Card 1</h2>
                    <p class="text-gray-600 dark:text-gray-400">Konten card responsif</p>
                </div>

                <div class="p-4 bg-white dark:bg-neutral-900 rounded-2xl shadow-md">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Card 2</h2>
                    <p class="text-gray-600 dark:text-gray-400">Konten card responsif</p>
                </div>

                <div class="p-4 bg-white dark:bg-neutral-900 rounded-2xl shadow-md">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Card 3</h2>
                    <p class="text-gray-600 dark:text-gray-400">Konten card responsif</p>
                </div>
                <div class="p-4 bg-white dark:bg-neutral-900 rounded-2xl shadow-md">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Card 3</h2>
                    <p class="text-gray-600 dark:text-gray-400">Konten card responsif</p>
                </div>
                <div class="p-4 bg-white dark:bg-neutral-900 rounded-2xl shadow-md">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Card 3</h2>
                    <p class="text-gray-600 dark:text-gray-400">Konten card responsif</p>
                </div>
                <div class="p-4 bg-white dark:bg-neutral-900 rounded-2xl shadow-md">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Card 3</h2>
                    <p class="text-gray-600 dark:text-gray-400">Konten card responsif</p>
                </div>
                <div class="p-4 bg-white dark:bg-neutral-900 rounded-2xl shadow-md">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Card 3</h2>
                    <p class="text-gray-600 dark:text-gray-400">Konten card responsif</p>
                </div>
                <div class="p-4 bg-white dark:bg-neutral-900 rounded-2xl shadow-md">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Card 3</h2>
                    <p class="text-gray-600 dark:text-gray-400">Konten card responsif</p>
                </div>
                <div class="p-4 bg-white dark:bg-neutral-900 rounded-2xl shadow-md">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Card 3</h2>
                    <p class="text-gray-600 dark:text-gray-400">Konten card responsif</p>
                </div>
                <div class="p-4 bg-white dark:bg-neutral-900 rounded-2xl shadow-md">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Card 3</h2>
                    <p class="text-gray-600 dark:text-gray-400">Konten card responsif</p>
                </div>
            </div>
        </main>

        {{-- Footer --}}
        <x-footer />
    </body>
</html>
