<div id="show-report-modal-{{ $report->id }}" class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto">
    <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-4xl sm:w-full m-3 sm:mx-auto">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-900 dark:border-neutral-700">
            <div class="flex justify-between items-center py-3 px-4 border-b dark:border-neutral-700">
                <h3 class="font-bold text-gray-800 dark:text-white">Laporan Santri - {{ $report->santri->full_name }}</h3>
                <button type="button" class="flex justify-center items-center size-7 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700" data-hs-overlay="#show-report-modal-{{ $report->id }}">
                    <span class="sr-only">Close</span>
                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m18 6-12 12"/>
                        <path d="m6 6 12 12"/>
                    </svg>
                </button>
            </div>

            <div class="p-4 overflow-y-auto max-h-[80vh]">
                <!-- Header Info -->
                <div class="bg-gray-50 dark:bg-neutral-800 rounded-lg p-4 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Santri</h4>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $report->santri->full_name }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $report->santri->tpaClass->display_name }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Periode</h4>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ ucfirst($report->period_type) }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $report->period_label }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Nilai Keseluruhan</h4>
                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                {{ $report->overall_score ? number_format($report->overall_score, 1) : '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Assessment Categories -->
                @if($report->summary_scores)
                    <div class="space-y-6">
                        @foreach($report->summary_scores as $categoryName => $categoryData)
                            @php
                                $category = \App\Models\AssessmentCategory::where('name', $categoryName)->first();
                            @endphp
                            @if($category)
                                <div class="border border-gray-200 dark:border-neutral-700 rounded-lg p-4">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center">
                                            <div class="w-4 h-4 rounded-full mr-3" style="background-color: {{ $category->color }}"></div>
                                            <h5 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $categoryData['display_name'] }}</h5>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-lg font-bold text-gray-900 dark:text-white">
                                                {{ $categoryData['score'] ? number_format($categoryData['score'], 1) : '-' }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Bobot: {{ $categoryData['weight'] }}%</p>
                                        </div>
                                    </div>

                                    <!-- Individual Assessments -->
                                    <div class="space-y-3">
                                        @foreach($category->activeAssessments as $assessment)
                                            @php
                                                $detail = $report->reportDetails->where('assessment_id', $assessment->id)->first();
                                            @endphp
                                            @if($detail)
                                                <div class="bg-gray-50 dark:bg-neutral-800 rounded-lg p-3">
                                                    <div class="flex justify-between items-start">
                                                        <div class="flex-1">
                                                            <h6 class="font-medium text-gray-900 dark:text-white">{{ $assessment->display_name }}</h6>
                                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $assessment->description }}</p>
                                                            @if($detail->notes)
                                                                <p class="text-sm text-blue-600 dark:text-blue-400 mt-1">{{ $detail->notes }}</p>
                                                            @endif
                                                        </div>
                                                        <div class="text-right">
                                                            <p class="font-semibold text-gray-900 dark:text-white">{{ $detail->score_value }}</p>
                                                            @if($detail->numeric_score)
                                                                <p class="text-sm text-gray-500 dark:text-gray-400">({{ $detail->numeric_score }})</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif

                <!-- Notes and Recommendations -->
                @if($report->teacher_notes || $report->recommendations)
                    <div class="mt-6 border-t border-gray-200 dark:border-neutral-700 pt-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if($report->teacher_notes)
                                <div>
                                    <h5 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Catatan Ustadz</h5>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $report->teacher_notes }}</p>
                                </div>
                            @endif

                            @if($report->recommendations)
                                <div>
                                    <h5 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Rekomendasi</h5>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $report->recommendations }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Report Info -->
                <div class="mt-6 border-t border-gray-200 dark:border-neutral-700 pt-4">
                    <div class="flex justify-between items-center text-sm text-gray-500 dark:text-gray-400">
                        <span>Dibuat oleh: {{ $report->creator->name }}</span>
                        <span>{{ $report->created_at->format('d M Y H:i') }}</span>
                    </div>
                    @if($report->published_at)
                        <div class="flex justify-between items-center text-sm text-gray-500 dark:text-gray-400 mt-1">
                            <span>Status: Published</span>
                            <span>{{ $report->published_at->format('d M Y H:i') }}</span>
                        </div>
                    @endif
                </div>

                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t dark:border-neutral-700 mt-6">
                    @if($report->status === 'draft')
                        <form method="POST" action="{{ route('report.publish', $report) }}" class="inline">
                            @csrf
                            <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-green-600 text-white hover:bg-green-700 disabled:opacity-50 disabled:pointer-events-none">
                                Publish
                            </button>
                        </form>
                    @endif
                    <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800" data-hs-overlay="#show-report-modal-{{ $report->id }}">
                        Tutup
                    </button>
                    <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-yellow-600 text-white hover:bg-yellow-700 disabled:opacity-50 disabled:pointer-events-none" data-hs-overlay="#edit-report-modal-{{ $report->id }}">
                        Edit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>