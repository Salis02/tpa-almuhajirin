@props(['icon', 'label', 'active' => false])

{{-- Alpine.js akan mengambil nilai awal dari variable $active yang dikirim Laravel --}}
<li x-data="{ open: @json($active) }">
    <button type="button" @click="open = !open"
        class="flex items-center gap-x-3 w-full py-2 px-3 text-sm rounded-lg transition-colors duration-200 focus:outline-none 
        {{ $active
            ? 'text-blue-700 bg-blue-50 dark:bg-blue-900/20 dark:text-blue-400 font-medium'
            : 'text-gray-700 hover:bg-gray-100 dark:text-neutral-300 dark:hover:bg-neutral-700' }}">

        <x-icon name="{{ $icon }}" class="w-4 h-4" />
        <span class="flex-1 text-left">{{ $label }}</span>

        {{-- Ikon Panah --}}
        <svg class="w-3 h-3 transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    {{-- Sub-menu dengan transisi smooth --}}
    <ul x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        class="mt-1 ml-4 pl-3 border-l-2 border-gray-100 dark:border-neutral-800 space-y-1">
        {{ $slot }}
    </ul>
</li>
