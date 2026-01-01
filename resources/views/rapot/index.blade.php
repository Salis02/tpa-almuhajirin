<x-app-layout title="Raport Santri - TPA Al Muhajirin">
    <div class="space-y-6">

        {{-- Flash Message --}}
        @if (session('success'))
            <div class="p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-900/20 dark:text-green-400">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-900/20 dark:text-red-400">
                {{ session('error') }}
            </div>
        @endif

        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Raport Santri</h1>
                <p class="text-gray-600 dark:text-gray-400">
                    Data raport santri yang tersinkron dari Google Sheet
                </p>
            </div>
            <button type="button"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors"
                data-hs-overlay="#create-rapot-modal">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Rapot Santri
            </button>
        </div>

        <!-- Filter Section -->
        <div
            class="bg-white dark:bg-neutral-900 rounded-lg p-6 shadow-sm border border-gray-200 dark:border-neutral-700">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">

                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">
                        Cari Santri
                    </label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama atau NIS..."
                        class="border py-3 px-4 block w-full rounded-full text-sm
                                  border-gray-200 focus:border-blue-500 focus:ring-blue-500
                                  dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                </div>

                <!-- Kelas -->
                <div>
                    <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">
                        Kelas
                    </label>
                    <input type="text" name="kelas" value="{{ request('kelas') }}" placeholder="Contoh: A, B, C"
                        class="border py-3 px-4 block w-full rounded-full text-sm
                                  border-gray-200 focus:border-blue-500 focus:ring-blue-500
                                  dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                </div>

                <!-- Status Raport -->
                <div>
                    <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">
                        Status Raport
                    </label>
                    <select name="status"
                        class="border py-3 px-4 block w-full rounded-full text-sm
                                   border-gray-200 focus:border-blue-500 focus:ring-blue-500
                                   dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                        <option value="">Semua</option>
                        <option value="lengkap" {{ request('status') == 'lengkap' ? 'selected' : '' }}>Lengkap
                        </option>
                        <option value="belum" {{ request('status') == 'belum' ? 'selected' : '' }}>Belum Lengkap
                        </option>
                    </select>
                </div>

                <!-- Action -->
                <div class="flex items-end gap-2">
                    <button class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg">
                        Filter
                    </button>
                    <a href="{{ route('rapot.index') }}"
                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg">
                        Reset
                    </a>
                </div>

            </form>
        </div>

        <!-- Table -->
        <div
            class="bg-white dark:bg-neutral-900 rounded-lg shadow-sm border border-gray-200 dark:border-neutral-700 overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-50 dark:bg-neutral-800 text-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-3">NIS</th>
                        <th class="px-4 py-3">Nama Santri</th>
                        <th class="px-4 py-3">Kelas</th>
                        <th class="px-4 py-3">Materi</th>
                        <th class="px-4 py-3">Status Raport</th>
                    </tr>
                </thead>
                <tbody class="divide-y dark:divide-neutral-700">
                    @forelse($raports as $raport)
                        <tr class="hover:bg-gray-50 dark:hover:bg-neutral-800">
                            <td class="px-4 py-3">{{ $raport['nis'] ?? '-' }}</td>
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                {{ $raport['nama'] ?? '-' }}
                            </td>
                            <td class="px-4 py-3">{{ $raport['kelas'] ?? '-' }}</td>
                            <td class="px-4 py-3">
                                {{ $raport['materi'] ?? '-' }}
                            </td>
                            <td class="px-4 py-3">
                                <span
                                    class="px-2 py-1 text-xs rounded-full
                                    {{ ($raport['status_raport'] ?? '') === 'lengkap'
                                        ? 'bg-green-100 text-green-700 dark:bg-green-900/20 dark:text-green-400'
                                        : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/20 dark:text-yellow-400' }}">
                                    {{ ucfirst($raport['status_raport'] ?? 'belum') }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                Data raport belum tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <!-- Create Modal -->
    @include('rapot.partials.create-modal', ['classes' => $classes])
</x-app-layout>
