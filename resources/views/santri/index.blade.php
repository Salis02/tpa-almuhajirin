<x-app-layout title="Data Santri - TPA Al Muhajirin">
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Data Santri</h1>
                <p class="text-gray-600 dark:text-gray-400">Kelola data santri TPA Al Muhajirin</p>
            </div>
            <button type="button" 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors"
                    data-hs-overlay="#create-santri-modal">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Tambah Santri
            </button>
        </div>

        <!-- Filter Section (sama seperti sebelumnya) -->
        <div class="bg-white dark:bg-neutral-900 rounded-lg p-6 shadow-sm border border-gray-200 dark:border-neutral-700">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cari Santri</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Nama, NIS, atau nickname..."
                           class="w-full rounded-lg border-gray-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-white">
                </div>

                <!-- Class Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kelas</label>
                    <select name="class_id" class="w-full rounded-lg border-gray-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-white">
                        <option value="">Semua Kelas</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->display_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                    <select name="status" class="w-full rounded-lg border-gray-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-white">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="graduated" {{ request('status') === 'graduated' ? 'selected' : '' }}>Lulus</option>
                        <option value="dropped" {{ request('status') === 'dropped' ? 'selected' : '' }}>Keluar</option>
                    </select>
                </div>

                <!-- Actions -->
                <div class="flex items-end space-x-2">
                    <button type="submit" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                        Filter
                    </button>
                    <a href="{{ route('santri.index') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg transition-colors">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Stats Cards (sama seperti sebelumnya) -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @php
                $totalSantri = \App\Models\Santri::count();
                $activeSantri = \App\Models\Santri::where('status', 'active')->count();
                $maleSantri = \App\Models\Santri::where('gender', 'L')->where('status', 'active')->count();
                $femaleSantri = \App\Models\Santri::where('gender', 'P')->where('status', 'active')->count();
            @endphp
            
            <div class="bg-white dark:bg-neutral-900 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-neutral-700">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Santri</h3>
                <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $totalSantri }}</p>
            </div>
            
            <div class="bg-white dark:bg-neutral-900 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-neutral-700">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Santri Aktif</h3>
                <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $activeSantri }}</p>
            </div>
            
            <div class="bg-white dark:bg-neutral-900 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-neutral-700">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Santri Putra</h3>
                <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $maleSantri }}</p>
            </div>
            
            <div class="bg-white dark:bg-neutral-900 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-neutral-700">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Santri Putri</h3>
                <p class="text-3xl font-bold text-pink-600 dark:text-pink-400">{{ $femaleSantri }}</p>
            </div>
        </div>

        <!-- Santri Grid -->
        @if($santris->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($santris as $santri)
                    <div class="bg-white dark:bg-neutral-900 rounded-lg shadow-sm border border-gray-200 dark:border-neutral-700 overflow-hidden">
                        <!-- Photo -->
                        <div class="aspect-square bg-gray-100 dark:bg-neutral-800 cursor-pointer"
                             data-hs-overlay="#show-santri-modal-{{ $santri->id }}">
                            <img src="{{ $santri->photo_url }}" 
                                 alt="{{ $santri->display_name }}"
                                 class="w-full h-full object-cover">
                        </div>

                        <!-- Content -->
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-medium px-2 py-1 rounded-full 
                                    {{ $santri->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400' }}">
                                    {{ ucfirst($santri->status) }}
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $santri->nis }}</span>
                            </div>

                            <h3 class="font-semibold text-gray-900 dark:text-white mb-1">{{ $santri->display_name }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ $santri->tpaClass->display_name }}</p>
                            
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-3">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $santri->age }} tahun
                            </div>

                            <!-- Actions -->
                            <div class="flex space-x-2">
                                <button type="button"
                                        data-hs-overlay="#show-santri-modal-{{ $santri->id }}"
                                        class="flex-1 text-center px-3 py-2 text-sm bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-lg transition-colors dark:bg-blue-900/20 dark:text-blue-400 dark:hover:bg-blue-900/30">
                                    Detail
                                </button>
                                <button type="button"
                                        data-hs-overlay="#edit-santri-modal-{{ $santri->id }}"
                                        class="flex-1 text-center px-3 py-2 text-sm bg-yellow-50 text-yellow-700 hover:bg-yellow-100 rounded-lg transition-colors dark:bg-yellow-900/20 dark:text-yellow-400 dark:hover:bg-yellow-900/30">
                                    Edit
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Show Modal untuk setiap santri -->
                    @include('santri.partials.show-modal', ['santri' => $santri])
                    
                    <!-- Edit Modal untuk setiap santri -->
                    @include('santri.partials.edit-modal', ['santri' => $santri, 'classes' => $classes])
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $santris->links() }}
            </div>
        @else
            <div class="bg-white dark:bg-neutral-900 rounded-lg p-12 text-center shadow-sm border border-gray-200 dark:border-neutral-700">
                <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m9 5.197v1M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum ada data santri</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-4">Mulai dengan menambahkan data santri pertama</p>
                <button type="button" 
                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors"
                        data-hs-overlay="#create-santri-modal">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Santri
                </button>
            </div>
        @endif
    </div>

    <!-- Create Modal -->
    @include('santri.partials.create-modal', ['classes' => $classes])
</x-app-layout>