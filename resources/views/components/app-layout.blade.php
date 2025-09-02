@props(['title' => config('app.name')])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    {{ $head ?? '' }}
</head>
<body class="flex flex-col min-h-screen dark:bg-black">
    <x-header />
    
    <div class="flex flex-1 overflow-hidden">
        <x-sidebar />
        
        <main class="flex-1 overflow-auto">
            <div class="w-full max-w-none mx-auto px-4 sm:px-6 lg:px-8 py-6">
                {{ $slot }}
            </div>
        </main>
    </div>

    <x-footer />
    
    {{ $scripts ?? '' }}
</body>
</html>