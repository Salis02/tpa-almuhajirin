<x-app-layout :title="'Profil Ustadz - ' . $ustadz->full_name">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Profil Ustadz</h1>
                <p class="text-gray-600 dark:text-gray-400">Detail data ustadz TPA Al Muhajirin</p>
            </div>
            <a href="{{ route('ustadz.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
        </div>

        <!-- Card Detail -->
        <div class="bg-white dark:bg-neutral-900 rounded-lg shadow-sm border border-gray-200 dark:border-neutral-700 overflow-hidden">
            <!-- Photo -->
            <div class="aspect-square bg-gray-100 dark:bg-neutral-800">
                <img src="{{ $ustadz->photo_url }}" 
                     alt="{{ $ustadz->full_name }}"
                     class="w-full h-full object-cover">
            </div>

            <!-- Content -->
            <div class="p-6">
                <!-- Status + NIP -->
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-medium px-2 py-1 rounded-full 
                        {{ $ustadz->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400' }}">
                        {{ ucfirst($ustadz->status) }}
                    </span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $ustadz->nip }}</span>
                </div>

                <!-- Nama -->
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $ustadz->full_name }}</h2>

                <!-- Role -->
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                    {{ $ustadz->roles->pluck('display_name')->implode(', ') ?: 'Ustadz' }}
                </p>

                <!-- Status Kepegawaian -->
                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-2">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6"/>
                    </svg>
                    {{ ucfirst($ustadz->employment_status) }}
                </div>

                <!-- Jenis Kelamin -->
                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-2">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.797.657 6.879 1.804M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ $ustadz->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                </div>

                <!-- Email -->
                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-2">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m8 0l-4 4m4-4l-4-4"/>
                    </svg>
                    {{ $ustadz->user->email ?? '-' }}
                </div>

                <!-- Tanggal Bergabung -->
                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Bergabung: {{ $ustadz->created_at->format('d M Y') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
