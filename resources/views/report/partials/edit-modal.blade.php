<div id="edit-report-modal-{{ $report->id }}" class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto">
    <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-5xl sm:w-full m-3 sm:mx-auto">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-900 dark:border-neutral-700">
            <div class="p-4 overflow-y-auto max-h-[90vh]">
                <div class="flex justify-between items-center py-3 px-4 border-b dark:border-neutral-700">
                    <h3 class="font-bold text-gray-800 dark:text-white">Edit Laporan - {{ $report->santri->full_name }}</h3>
                    <button type="button" class="flex justify-center items-center size-7 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700" data-hs-overlay="#edit-report-modal-{{ $report->id }}">
                        <span class="sr-only">Close</span>
                        <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m18 6-12 12"/>
                            <path d="m6 6 12 12"/>
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('report.update', $report) }}" class="p-4">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left Column - Basic Info -->
                        <div class="space-y-6">
                            <div class="border-b border-gray-200 dark:border-neutral-700 pb-4">
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Laporan</h4>
                            </div>

                            <!-- Santri Info (Read Only) -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Santri</label>
                                <div class="py-3 px-4 border border-gray-200 bg-gray-50 rounded-lg dark:bg-neutral-800 dark:border-neutral-700">
                                    <p class="text-sm text-gray-900 dark:text-white">{{ $report->santri->full_name }} - {{ $report->santri->tpaClass->display_name }}</p>
                                </div>
                            </div>

                            <!-- Period Type (Read Only) -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Jenis Periode</label>
                                <div class="py-3 px-4 border border-gray-200 bg-gray-50 rounded-lg dark:bg-neutral-800 dark:border-neutral-700">
                                    <p class="text-sm text-gray-900 dark:text-white">{{ ucfirst($report->period_type) }}</p>
                                </div>
                            </div>

                            <!-- Period Date Range -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-2 dark:text-white">Tanggal Mulai *</label>
                                    <input type="date" name="period_start" required value="{{ $report->period_start->format('Y-m-d') }}"
                                           class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-2 dark:text-white">Tanggal Selesai *</label>
                                    <input type="date" name="period_end" required value="{{ $report->period_end->format('Y-m-d') }}"
                                           class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600">
                                </div>
                            </div>

                            <!-- Academic Year -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Tahun Ajaran *</label>
                                <input type="text" name="academic_year" required value="{{ $report->academic_year }}"
                                       class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Status *
                                    </label>
                                <select name="status" required class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600">
                                    <option value="draft" {{ $report->status === 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ $report->status === 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="archived" {{ $report->status === 'archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                            </div>

                            <!-- Teacher Notes -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Catatan Ustadz</label>
                                <textarea name="teacher_notes" rows="3"
                                          class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">{{ $report->teacher_notes }}</textarea>
                            </div>

                            <!-- Recommendations -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Rekomendasi</label>
                                <textarea name="recommendations" rows="3"
                                          class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">{{ $report->recommendations }}</textarea>
                            </div>
                        </div>

                        <!-- Right Column - Assessments -->
                        <div class="space-y-6">
                            <div class="border-b border-gray-200 dark:border-neutral-700 pb-4">
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Penilaian</h4>
                            </div>

                            @foreach(\App\Models\AssessmentCategory::with('activeAssessments')->where('is_active', true)->get() as $category)
                                <div class="border border-gray-200 dark:border-neutral-700 rounded-lg p-4">
                                    <div class="flex items-center mb-4">
                                        <div class="w-4 h-4 rounded-full mr-3" style="background-color: {{ $category->color }}"></div>
                                        <h5 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $category->display_name }}</h5>
                                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">({{ $category->weight }}%)</span>
                                    </div>
                                    
                                    <div class="space-y-4">
                                        @foreach($category->activeAssessments as $assessment)
                                            @php
                                                $existingDetail = $report->reportDetails->where('assessment_id', $assessment->id)->first();
                                            @endphp
                                            <div>
                                                <label class="block text-sm font-medium mb-2 dark:text-white">
                                                    {{ $assessment->display_name }} *
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">({{ $assessment->weight }}%)</span>
                                                </label>
                                                <p class="text-xs text-gray-600 dark:text-gray-400 mb-2">{{ $assessment->description }}</p>
                                                
                                                @if($assessment->assessment_type === 'numeric')
                                                    <div class="flex items-center space-x-2">
                                                        <input type="number" 
                                                               name="assessments[{{ $assessment->id }}]" 
                                                               required
                                                               value="{{ $existingDetail ? $existingDetail->score_value : '' }}"
                                                               min="{{ $assessment->scale_options['min'] }}" 
                                                               max="{{ $assessment->scale_options['max'] }}"
                                                               step="{{ $assessment->scale_options['step'] ?? 1 }}"
                                                               class="py-2 px-3 w-20 border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                                        <span class="text-sm text-gray-600 dark:text-gray-400">
                                                            ({{ $assessment->scale_options['min'] }}-{{ $assessment->scale_options['max'] }}{{ isset($assessment->scale_options['unit']) ? ' ' . $assessment->scale_options['unit'] : '' }})
                                                        </span>
                                                    </div>
                                                @elseif($assessment->assessment_type === 'grade')
                                                    <select name="assessments[{{ $assessment->id }}]" required
                                                            class="py-2 px-3 w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                                        <option value="">Pilih Grade</option>
                                                        @foreach($assessment->scale_options['grades'] as $grade)
                                                            <option value="{{ $grade }}" {{ $existingDetail && $existingDetail->score_value === $grade ? 'selected' : '' }}>
                                                                {{ $grade }} - {{ $assessment->scale_options['descriptions'][$grade] ?? '' }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @elseif($assessment->assessment_type === 'boolean')
                                                    <select name="assessments[{{ $assessment->id }}]" required
                                                            class="py-2 px-3 w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                                        <option value="">Pilih Status</option>
                                                        <option value="1" {{ $existingDetail && $existingDetail->score_value === '1' ? 'selected' : '' }}>
                                                            {{ $assessment->scale_options[0] ?? 'Ya' }}
                                                        </option>
                                                        <option value="0" {{ $existingDetail && $existingDetail->score_value === '0' ? 'selected' : '' }}>
                                                            {{ $assessment->scale_options[1] ?? 'Tidak' }}
                                                        </option>
                                                    </select>
                                                @endif

                                                <!-- Notes for specific assessment -->
                                                <textarea name="notes[{{ $assessment->id }}]" rows="2"
                                                          class="mt-2 py-2 px-3 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400"
                                                          placeholder="Catatan khusus untuk {{ strtolower($assessment->display_name) }}">{{ $existingDetail ? $existingDetail->notes : '' }}</textarea>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t dark:border-neutral-700 mt-6">
                        <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800" data-hs-overlay="#edit-report-modal-{{ $report->id }}">
                            Batal
                        </button>
                        <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>