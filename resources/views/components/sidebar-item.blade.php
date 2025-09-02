@props([
    'icon',
    'label',
    'route' => '#',
    'active' => false
])

@php
    $classes = $active 
        ? 'flex items-center gap-x-3 py-2 px-3 bg-blue-100 text-blue-700 text-sm font-medium rounded-lg dark:bg-blue-900/20 dark:text-blue-400'
        : 'flex items-center gap-x-3 py-2 px-3 text-sm text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100 dark:text-neutral-300 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700';
        
     $href = $route === '#' ? '#' : (Route::has($route) ? route($route) : '#');
@endphp

<li>
    <a href="{{ $href }}" class="{{ $classes }}">
        <x-icon name="{{ $icon }}" class="w-4 h-4" />
        {{ $label }}
    </a>
</li>