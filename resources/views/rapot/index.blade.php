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

        <div
            class="bg-white dark:bg-neutral-900 rounded-lg p-6 shadow-sm border border-gray-200 dark:border-neutral-700">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">Cari Santri</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama atau NIS..."
                        class="border py-3 px-4 block w-full rounded-full text-sm border-gray-200 focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">Kelas</label>
                    <input type="text" name="kelas" value="{{ request('kelas') }}" placeholder="Contoh: Usman"
                        class="border py-3 px-4 block w-full rounded-full text-sm border-gray-200 focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">Status</label>
                    <select name="status"
                        class="border py-3 px-4 block w-full rounded-full text-sm border-gray-200 dark:bg-neutral-900 dark:border-neutral-700">
                        <option value="">Semua Status</option>
                        <option value="final" {{ request('status') == 'final' ? 'selected' : '' }}>Final</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-full text-sm font-medium transition">Filter</button>
                    <a href="{{ route('rapot.index') }}"
                        class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-full text-sm font-medium transition">Reset</a>
                </div>
            </form>
        </div>

        <div
            class="bg-white dark:bg-neutral-900 rounded-xl shadow-sm border border-gray-200 dark:border-neutral-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left border-collapse">
                    <thead
                        class="bg-gray-50 dark:bg-neutral-800 text-gray-700 dark:text-gray-300 border-b border-gray-200 dark:border-neutral-700">
                        <tr>
                            <th class="px-4 py-4 font-semibold uppercase tracking-wider whitespace-nowrap">Tgl Input
                            </th>
                            <th class="px-4 py-4 font-semibold uppercase tracking-wider whitespace-nowrap">Tahun/Smstr
                            </th>
                            <th class="px-4 py-4 font-semibold uppercase tracking-wider whitespace-nowrap">NIS</th>
                            <th
                                class="px-4 py-4 font-semibold uppercase tracking-wider whitespace-nowrap sticky left-0 bg-gray-50 dark:bg-neutral-800 shadow-[2px_0_5px_rgba(0,0,0,0.05)]">
                                Nama Santri</th>
                            <th class="px-4 py-4 font-semibold uppercase tracking-wider">Kelas</th>
                            <th class="px-4 py-4 font-semibold uppercase tracking-wider">Ustadz</th>
                            <th class="px-3 py-4 text-center bg-blue-50/50 dark:bg-blue-900/10">Tahsin</th>
                            <th class="px-3 py-4 text-center bg-blue-50/50 dark:bg-blue-900/10">Khot</th>
                            <th class="px-3 py-4 text-center bg-blue-50/50 dark:bg-blue-900/10">Hafalan</th>
                            <th class="px-3 py-4 text-center bg-blue-50/50 dark:bg-blue-900/10">Sholat</th>
                            <th class="px-3 py-4 text-center bg-blue-50/50 dark:bg-blue-900/10">Wudhu</th>
                            <th class="px-3 py-4 text-center bg-blue-50/50 dark:bg-blue-900/10">Aqidah</th>
                            <th class="px-3 py-4 text-center bg-blue-50/50 dark:bg-blue-900/10">Doa</th>
                            <th class="px-3 py-4 text-center bg-blue-50/50 dark:bg-blue-900/10">Ayat</th>
                            <th class="px-3 py-4 text-center bg-blue-50/50 dark:bg-blue-900/10">Qiroah</th>
                            <th class="px-3 py-4 text-center bg-blue-50/50 dark:bg-blue-900/10">Tajwid</th>

                            <th class="px-4 py-4 font-bold text-center bg-green-50 dark:bg-green-900/20">RATA2</th>
                            <th class="px-4 py-4 font-semibold uppercase tracking-wider whitespace-nowrap">Materi</th>
                            <th class="px-4 py-4 font-semibold uppercase tracking-wider">Catatan</th>
                            <th class="px-4 py-4 font-semibold uppercase tracking-wider">Status</th>
                            <th class="px-4 py-4 font-semibold uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                        @forelse($raports as $raport)
                            <tr class="hover:bg-gray-50 dark:hover:bg-neutral-800 transition">
                                <td class="px-4 py-4 whitespace-nowrap text-gray-500">
                                    {{ \Carbon\Carbon::parse($raport['timestamp'])->format('d/m/y H:i') }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">{{ $raport['tahun_ajaran'] }}
                                    ({{ $raport['semester'] }})
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap font-mono text-xs">{{ $raport['nis'] }}</td>
                                <td
                                    class="px-4 py-4 whitespace-nowrap font-bold sticky left-0 bg-white dark:bg-neutral-900 shadow-[2px_0_5px_rgba(0,0,0,0.05)] text-blue-600 dark:text-blue-400">
                                    {{ $raport['nama_santri'] }}
                                </td>
                                <td class="px-4 py-4">{{ $raport['kelas'] }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">{{ $raport['ustadz'] }}</td>

                                <td class="px-3 py-4 text-center">{{ $raport['nilai']['tahsin'] }}</td>
                                <td class="px-3 py-4 text-center">{{ $raport['nilai']['khot'] }}</td>
                                <td class="px-3 py-4 text-center">{{ $raport['nilai']['hafalan'] }}</td>
                                <td class="px-3 py-4 text-center">{{ $raport['nilai']['praktek_sholat'] }}</td>
                                <td class="px-3 py-4 text-center">{{ $raport['nilai']['praktek_wudhu'] }}</td>
                                <td class="px-3 py-4 text-center">{{ $raport['nilai']['aqidah'] }}</td>
                                <td class="px-3 py-4 text-center">{{ $raport['nilai']['doa_harian'] }}</td>
                                <td class="px-3 py-4 text-center">{{ $raport['nilai']['ayat_pilihan'] }}</td>
                                <td class="px-3 py-4 text-center">{{ $raport['nilai']['qiroah'] }}</td>
                                <td class="px-3 py-4 text-center">{{ $raport['nilai']['tajwid'] }}</td>

                                <td
                                    class="px-4 py-4 text-center font-bold text-green-600 bg-green-50/30 dark:bg-green-900/10">
                                    {{ $raport['rata_rata'] }}
                                </td>
                                <td class="px-4 py-4 max-w-xs truncate" title="{{ $raport['materi'] }}">
                                    {{ $raport['materi'] }}</td>
                                <td class="px-4 py-4 max-w-xs truncate" title="{{ $raport['catatan'] }}">
                                    {{ $raport['catatan'] }}</td>
                                <td class="px-4 py-4">
                                    <span
                                        class="px-3 py-1 text-xs font-bold rounded-full {{ strtolower($raport['status_raport']) == 'final' ? 'bg-green-100 text-green-700 dark:bg-green-900/30' : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30' }}">
                                        {{ strtoupper($raport['status_raport']) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <a href="{{ route('rapot.pdf', [
                                        'nis' => $raport['nis'],
                                        'semester' => $raport['semester'],
                                        'tahun_ajaran' => $raport['tahun_ajaran'],
                                    ]) }}"
                                        target="_blank"
                                        class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-lg transition">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        PDF
                                    </a>
                                    <button type="button" data-hs-overlay="#edit-rapot-modal-{{ $loop->index }}"
                                        class="inline-flex items-center px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-lg transition">
                                        EDIT
                                    </button>

                                    <a href="{{ route('rapot.pdf', [
                                        'nis' => $raport['nis'],
                                        'semester' => $raport['semester'],
                                        'tahun_ajaran' => $raport['tahun_ajaran'],
                                    ]) }}"
                                        ...></a>
                                </td>

                                @include('rapot.partials.edit-modal')
                            </tr>
                        @empty
                            <tr>
                                <td colspan="21" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
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
