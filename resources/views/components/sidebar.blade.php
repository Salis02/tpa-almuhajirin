<!-- Desktop Sidebar -->
<aside class="hidden lg:flex lg:flex-col lg:w-64 lg:bg-white lg:border-r lg:border-gray-200 dark:lg:bg-neutral-800 dark:lg:border-neutral-700">
    <div class="flex flex-col h-full">
        <!-- Sidebar Header -->
        <div class="p-4 border-b border-gray-200 dark:border-neutral-700">
            <h2 class="font-semibold text-lg text-gray-900 dark:text-white">
                TPA Al Muhajirin
            </h2>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto p-4">
            <x-sidebar-navigation />
        </nav>

        <!-- User Profile -->
        <x-sidebar-user-profile />
    </div>
</aside>

<!-- Mobile Sidebar -->
<div id="mobile-sidebar" class="hs-overlay fixed inset-0 z-60 lg:hidden hs-overlay-open:translate-x-0 -translate-x-full transition-transform duration-300">
    <div class="flex h-full max-w-xs w-full">
        <div class="flex flex-col w-full bg-white border-r border-gray-200 dark:bg-neutral-800 dark:border-neutral-700">
            <!-- Mobile Header -->
            <div class="p-4 border-b border-gray-200 dark:border-neutral-700 flex justify-between items-center">
                <h2 class="font-semibold text-lg text-gray-900 dark:text-white">
                    TPA Al Muhajirin
                </h2>
                <button type="button" 
                        class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-neutral-700" 
                        data-hs-overlay="#mobile-sidebar">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Mobile Navigation -->
            <nav class="flex-1 overflow-y-auto p-4">
                <x-sidebar-navigation />
            </nav>

            <!-- Mobile User Profile -->
            <x-sidebar-user-profile />
        </div>
    </div>
</div>