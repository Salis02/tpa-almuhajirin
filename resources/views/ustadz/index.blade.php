<x-app-layout title="Data Ustadz - TPA Al Muhajirin">
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Data Ustadz</h1>
                <p class="text-gray-600 dark:text-gray-400">Kelola data ustadz dan pengurus TPA Al Muhajirin</p>
            </div>
            <button type="button" 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors"
                    data-hs-overlay="#create-ustadz-modal">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Tambah Ustadz
            </button>
        </div>

        <!-- Filter Section -->
        <div class="bg-white dark:bg-neutral-900 rounded-lg p-6 shadow-sm border border-gray-200 dark:border-neutral-700">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cari Ustadz</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Nama, NIP, atau email..."
                           class="w-full rounded-lg border-gray-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-white">
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                    <select name="status" class="w-full rounded-lg border-gray-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-white">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="resign" {{ request('status') === 'resign' ? 'selected' : '' }}>Resign</option>
                    </select>
                </div>

                <!-- Employment Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status Kepegawaian</label>
                    <select name="employment_status" class="w-full rounded-lg border-gray-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-white">
                        <option value="">Semua</option>
                        <option value="tetap" {{ request('employment_status') === 'tetap' ? 'selected' : '' }}>Tetap</option>
                        <option value="honorer" {{ request('employment_status') === 'honorer' ? 'selected' : '' }}>Honorer</option>
                        <option value="magang" {{ request('employment_status') === 'magang' ? 'selected' : '' }}>Magang</option>
                    </select>
                </div>

                <!-- Gender Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jenis Kelamin</label>
                    <select name="gender" class="w-full rounded-lg border-gray-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-white">
                        <option value="">Semua</option>
                        <option value="L" {{ request('gender') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ request('gender') === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <!-- Actions -->
                <div class="flex items-end space-x-2">
                    <button type="submit" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                        Filter
                    </button>
                    <a href="{{ route('ustadz.index') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg transition-colors">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @php
                $totalUstadz = \App\Models\Ustadz::count();
                $activeUstadz = \App\Models\Ustadz::where('status', 'active')->count();
                $maleUstadz = \App\Models\Ustadz::where('gender', 'L')->where('status', 'active')->count();
                $femaleUstadz = \App\Models\Ustadz::where('gender', 'P')->where('status', 'active')->count();
            @endphp
            
            <div class="bg-white dark:bg-neutral-900 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-neutral-700">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Ustadz</h3>
                <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $totalUstadz }}</p>
            </div>
            
            <div class="bg-white dark:bg-neutral-900 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-neutral-700">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Ustadz Aktif</h3>
                <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $activeUstadz }}</p>
            </div>
            
            <div class="bg-white dark:bg-neutral-900 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-neutral-700">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Ustadz</h3>
                <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $maleUstadz }}</p>
            </div>
            
            <div class="bg-white dark:bg-neutral-900 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-neutral-700">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Ustadzah</h3>
                <p class="text-3xl font-bold text-pink-600 dark:text-pink-400">{{ $femaleUstadz }}</p>
            </div>
        </div>

        <!-- Ustadz Grid -->
        @if($ustadz->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($ustadz as $item)
                    <div class="bg-white dark:bg-neutral-900 rounded-lg shadow-sm border border-gray-200 dark:border-neutral-700 overflow-hidden">
                        <!-- Photo -->
                        <div class="aspect-square bg-gray-100 dark:bg-neutral-800 cursor-pointer"
                             data-hs-overlay="#show-ustadz-modal-{{ $item->id }}">
                            <img src="{{ $item->photo_url }}" 
                                 alt="{{ $item->full_name }}"
                                 class="w-full h-full object-cover">
                        </div>

                        <!-- Content -->
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-medium px-2 py-1 rounded-full 
                                    {{ $item->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $item->nip }}</span>
                            </div>

                            <h3 class="font-semibold text-gray-900 dark:text-white mb-1">{{ $item->full_name }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                {{ $item->roles->pluck('display_name')->implode(', ') ?: 'Ustadz' }}
                            </p>
                            
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-3">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6"/>
                                </svg>
                                {{ ucfirst($item->employment_status) }}
                            </div>

                            <!-- Actions -->
                            <div class="flex space-x-2">
                                <button type="button"
                                        data-hs-overlay="#show-ustadz-modal-{{ $item->id }}"
                                        class="flex-1 text-center px-3 py-2 text-sm bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-lg transition-colors dark:bg-blue-900/20 dark:text-blue-400 dark:hover:bg-blue-900/30">
                                    Detail
                                </button>
                                <button type="button"
                                        data-hs-overlay="#edit-ustadz-modal-{{ $item->id }}"
                                        class="flex-1 text-center px-3 py-2 text-sm bg-yellow-50 text-yellow-700 hover:bg-yellow-100 rounded-lg transition-colors dark:bg-yellow-900/20 dark:text-yellow-400 dark:hover:bg-yellow-900/30">
                                    Edit
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Show Modal -->
                    @include('ustadz.partials.show-modal', ['ustadz' => $item])
                    
                    <!-- Edit Modal -->
                    @include('ustadz.partials.edit-modal', ['ustadz' => $item, 'roles' => $roles])
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $ustadz->links() }}
            </div>
        @else
            <div class="bg-white dark:bg-neutral-900 rounded-lg p-12 text-center shadow-sm border border-gray-200 dark:border-neutral-700">
                <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum ada data ustadz</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-4">Mulai dengan menambahkan data ustadz pertama</p>
                <button type="button" 
                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors"
                        data-hs-overlay="#create-ustadz-modal">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Ustadz
                </button>
            </div>
        @endif
    </div>

    <!-- Create Modal -->
    @include('ustadz.partials.create-modal', ['roles' => $roles])
</x-app-layout>