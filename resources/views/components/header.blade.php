<header class="bg-white dark:bg-neutral-900 border-b border-gray-200 dark:border-neutral-700 sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Mobile menu button -->
            <div class="lg:hidden">
                <button type="button" 
                        class="p-2 rounded-lg text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-neutral-400 dark:hover:bg-neutral-700"
                        data-hs-overlay="#mobile-sidebar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

            <!-- Logo (Desktop) -->
            <div class="hidden lg:flex lg:items-center">
                <a href="{{ route('dashboard') }}" class="font-semibold text-xl text-gray-900 dark:text-white">
                    TPA Al Muhajirin
                </a>
            </div>

            <!-- Right side -->
            <div class="flex items-center space-x-4">

                <!-- Toggle switch mode -->
                <x-dark-mode-toggle/>
                
                <!-- User Info -->
                <div class="hidden md:flex md:items-center md:space-x-3">
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 capitalize">{{ auth()->user()->role }}</p>
                    </div>
                </div>

                <!-- User menu dropdown -->
                <div class="hs-dropdown relative inline-flex">
                    <button type="button" 
                            class="hs-dropdown-toggle flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-neutral-700"
                            aria-haspopup="menu" aria-expanded="false" aria-label="User menu">
                        <img class="w-8 h-8 rounded-full" 
                             src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&w=256&h=256&fit=facearea" 
                             alt="User">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div class="hs-dropdown-menu hs-dropdown-open:opacity-100 w-60 transition-[opacity,margin] duration opacity-0 hidden z-50 mt-2 bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-neutral-900 dark:border-neutral-700" 
                         role="menu" aria-orientation="vertical">
                        <div class="p-1">
                            <div class="flex items-center px-3 py-2 border-b border-gray-200 dark:border-neutral-700">
                                <img class="w-10 h-10 rounded-full mr-3" 
                                     src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&w=256&h=256&fit=facearea" 
                                     alt="User">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                                </div>
                            </div>

                            @if(auth()->user()->ustadz)
                                <a href="{{ route('ustadz.show', auth()->user()->ustadz) }}" 
                                   class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg dark:text-neutral-300 dark:hover:bg-neutral-800">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Profil Saya
                                </a>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="flex w-full items-center px-3 py-2 text-sm text-red-700 hover:bg-red-50 rounded-lg dark:text-red-400 dark:hover:bg-red-900/20">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>