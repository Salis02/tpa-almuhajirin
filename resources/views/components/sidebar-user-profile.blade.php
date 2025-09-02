<div class="p-4 border-t border-gray-200 dark:border-neutral-700">
    <div class="flex items-center gap-x-3 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-neutral-700 cursor-pointer">
        <img class="w-8 h-8 rounded-full" 
             src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&w=256&h=256&fit=facearea" 
             alt="User Avatar">
        <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                {{ auth()->user()->name ?? 'Mia Hudson' }}
            </p>
            <p class="text-xs text-gray-500 dark:text-neutral-400 truncate">
                {{ auth()->user()->email ?? 'mia@example.com' }}
            </p>
        </div>
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </div>
</div>