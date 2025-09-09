<x-app-layout title="Laporan Santri - TPA Al Muhajirin">
    <div class="space-y-6">
        @if(session('success'))
    <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-900/20 dark:text-green-400">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-900/20 dark:text-red-400">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-900/20 dark:text-red-400">
        <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <!-- Header Section -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Laporan Santri</h1>
                <p class="text-gray-600 dark:text-gray-400">Kelola rapor dan penilaian santri</p>
            </div>
            <button type="button" 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors"
                    data-hs-overlay="#create-report-modal">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Buat Laporan
            </button>
        </div>

        <!-- Filter Section -->
        <div class="bg-white dark:bg-neutral-900 rounded-lg p-6 shadow-sm border border-gray-200 dark:border-neutral-700">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Class Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kelas</label>
                    <select name="class_id" class="border py-3 px-4 pe-9 block w-full border-gray-200 rounded-full text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                        <option value="">Semua Kelas</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->display_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Period Type Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Periode</label>
                    <select name="period_type" class="border py-3 px-4 pe-9 block w-full border-gray-200 rounded-full text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                        <option value="">Semua Periode</option>
                        <option value="monthly" {{ request('period_type') === 'monthly' ? 'selected' : '' }}>Bulanan</option>
                        <option value="semester" {{ request('period_type') === 'semester' ? 'selected' : '' }}>Semester</option>
                        <option value="yearly" {{ request('period_type') === 'yearly' ? 'selected' : '' }}>Tahunan</option>
                    </select>
                </div>

                <!-- Academic Year Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tahun Ajaran</label>
                    <select name="academic_year" class="border py-3 px-4 pe-9 block w-full border-gray-200 rounded-full text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                        <option value="">Semua Tahun</option>
                        @foreach($academicYears as $year)
                            <option value="{{ $year }}" {{ request('academic_year') === $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                    <select name="status" class="border py-3 px-4 pe-9 block w-full border-gray-200 rounded-full text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                        <option value="">Semua Status</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                        <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>

                <!-- Actions -->
                <div class="flex items-end space-x-2">
                    <button type="submit" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                        Filter
                    </button>
                    <a href="{{ route('report.index') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg transition-colors">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @php
                $totalReports = \App\Models\StudentReport::count();
                $draftReports = \App\Models\StudentReport::where('status', 'draft')->count();
                $publishedReports = \App\Models\StudentReport::where('status', 'published')->count();
                $thisMonthReports = \App\Models\StudentReport::whereMonth('created_at', now()->month)->count();
            @endphp
            
            <div class="bg-white dark:bg-neutral-900 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-neutral-700">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Laporan</h3>
                <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $totalReports }}</p>
            </div>
            
            <div class="bg-white dark:bg-neutral-900 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-neutral-700">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Draft</h3>
                <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ $draftReports }}</p>
            </div>
            
            <div class="bg-white dark:bg-neutral-900 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-neutral-700">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Published</h3>
                <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $publishedReports }}</p>
            </div>
            
            <div class="bg-white dark:bg-neutral-900 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-neutral-700">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Bulan Ini</h3>
                <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $thisMonthReports }}</p>
            </div>
        </div>

        <!-- Reports Grid -->
        @if($reports->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($reports as $report)
                    <div class="bg-white dark:bg-neutral-900 rounded-lg shadow-sm border border-gray-200 dark:border-neutral-700 overflow-hidden">
                        <!-- Header -->
                        <div class="p-4 border-b border-gray-200 dark:border-neutral-700">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-medium px-2 py-1 rounded-full 
                                    {{ $report->status === 'published' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 
                                       ($report->status === 'draft' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400') }}">
                                    {{ ucfirst($report->status) }}
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ ucfirst($report->period_type) }}</span>
                            </div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">{{ $report->santri->full_name }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $report->santri->tpaClass->display_name }}</p>
                        </div>

                        <!-- Content -->
                        <div class="p-4">
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Periode:</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $report->period_label }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Tahun Ajaran:</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $report->academic_year }}</span>
                                </div>
                                @if($report->overall_score)
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Nilai Keseluruhan:</span>
                                        <span class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ number_format($report->overall_score, 1) }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Score Summary -->
                            @if($report->summary_scores)
                                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-neutral-700">
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Ringkasan Nilai:</h4>
                                    <div class="space-y-1">
                                        @foreach($report->summary_scores as $category => $data)
                                            <div class="flex justify-between items-center text-sm">
                                                <span class="text-gray-600 dark:text-gray-400">{{ $data['display_name'] }}:</span>
                                                <span class="font-medium text-gray-900 dark:text-white">{{ $data['score'] ? number_format($data['score'], 1) : '-' }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Actions -->
                            <div class="mt-4 flex space-x-2">
                                <button type="button"
                                        data-hs-overlay="#show-report-modal-{{ $report->id }}"
                                        class="flex-1 text-center px-3 py-2 text-sm bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-lg transition-colors dark:bg-blue-900/20 dark:text-blue-400 dark:hover:bg-blue-900/30">
                                    Detail
                                </button>
                                <button type="button"
                                        data-hs-overlay="#edit-report-modal-{{ $report->id }}"
                                        class="flex-1 text-center px-3 py-2 text-sm bg-yellow-50 text-yellow-700 hover:bg-yellow-100 rounded-lg transition-colors dark:bg-yellow-900/20 dark:text-yellow-400 dark:hover:bg-yellow-900/30">
                                    Edit
                                </button>
                                <button type="button"
                                        data-hs-overlay="#delete-report-modal-{{ $report->id }}"
                                        class="flex-1 text-center px-3 py-2 text-sm bg-red-50 text-red-700 hover:bg-red-100 rounded-lg">
                                    Hapus
                                </button>
                                {{-- 🔹 Tombol Preview --}}
    <a href="{{ route('report.preview', $report->id) }}" target="_blank"
       class="flex-1 justify-con text-center px-3 py-2 text-sm bg-purple-50 text-purple-700 hover:bg-purple-100 rounded-lg transition-colors dark:bg-purple-900/20 dark:text-purple-400 dark:hover:bg-purple-900/30">
        Preview
    </a>

    {{-- 🔹 Tombol Export PDF --}}
    <a href="{{ route('report.exportPdf', $report->id) }}"
       class="flex-1 text-center px-3 py-2 text-sm bg-green-50 text-green-700 hover:bg-green-100 rounded-lg transition-colors dark:bg-green-900/20 dark:text-green-400 dark:hover:bg-green-900/30">
        Export PDF
    </a>
                            </div>
                        </div>
                    </div>

                    <!-- Show Modal -->
                    @include('report.partials.show-modal', ['report' => $report])
                    
                    <!-- Edit Modal -->
                    @include('report.partials.edit-modal', ['report' => $report])
                
                    {{-- Delete Modal --}}
                    @include('report.partials.delete-modal', ['report' => $report])
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $reports->links() }}
            </div>
        @else
            <div class="bg-white dark:bg-neutral-900 rounded-lg p-12 text-center shadow-sm border border-gray-200 dark:border-neutral-700">
                <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum ada laporan</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-4">Mulai dengan membuat laporan penilaian santri</p>
                <button type="button" 
                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors"
                        data-hs-overlay="#create-report-modal">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Buat Laporan
                </button>
            </div>
        @endif
    </div>

    <!-- Create Modal -->
    @include('report.partials.create-modal')
</x-app-layout>