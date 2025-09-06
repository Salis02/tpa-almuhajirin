<div id="show-schedule-modal-{{ $schedule->id }}" class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto">
    <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-3xl sm:w-full m-3 sm:mx-auto">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-900 dark:border-neutral-700">
            <div class="flex justify-between items-center py-3 px-4 border-b dark:border-neutral-700">
                <h3 class="font-bold text-gray-800 dark:text-white">Detail Jadwal KBM</h3>
                <button type="button" class="flex justify-center items-center size-7 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700" data-hs-overlay="#show-schedule-modal-{{ $schedule->id }}">
                    <span class="sr-only">Close</span>
                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m18 6-12 12"/>
                        <path d="m6 6 12 12"/>
                    </svg>
                </button>
            </div>

            <div class="p-4 overflow-y-auto max-h-[80vh]">
                <div class="space-y-6">
                    <!-- Header Info -->
                    <div class="text-center border-b border-gray-200 dark:border-neutral-700 pb-6">
                        <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $schedule->title }}</h4>
                        <div class="flex justify-center space-x-2">
                            <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium 
                                @if($schedule->scheduleType->name === 'setoran') bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400
                                @elseif($schedule->scheduleType->name === 'praktek') bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400
                                @else bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-400 @endif">
                                {{ $schedule->scheduleType->display_name }}
                            </span>
                            <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium 
                                {{ $schedule->status === 'scheduled' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400' : 
                                   ($schedule->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400') }}">
                                {{ ucfirst($schedule->status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Schedule Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h5 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Jadwal</h5>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Kelas</label>
                                    <p class="text-sm text-gray-900 dark:text-white">{{ $schedule->tpaClass->display_name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Ustadz/Ustadzah</label>
                                    <p class="text-sm text-gray-900 dark:text-white">{{ $schedule->ustadz->full_name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal</label>
                                    <p class="text-sm text-gray-900 dark:text-white">{{ $schedule->date->format('l, d F Y') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Waktu</label>
                                    <p class="text-sm text-gray-900 dark:text-white">{{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }} ({{ $schedule->duration }} menit)</p>
                                </div>
                                @if($schedule->location)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Lokasi</label>
                                        <p class="text-sm text-gray-900 dark:text-white">{{ $schedule->location }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div>
                            <h5 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Peserta ({{ $schedule->participant_count }})</h5>
                            <div class="max-h-40 overflow-y-auto">
                                @if($schedule->participants->count() > 0)
                                    <div class="space-y-2">
                                        @foreach($schedule->participants as $participant)
                                            <div class="flex items-center justify-between p-2 bg-gray-50 dark:bg-neutral-800 rounded-lg">
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $participant->santri->full_name }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $participant->santri->nis }}</p>
                                                </div>
                                                <span class="text-xs px-2 py-1 rounded-full 
                                                    {{ $participant->status === 'present' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 
                                                       ($participant->status === 'absent' ? 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400') }}">
                                                    {{ ucfirst($participant->status) }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada peserta terdaftar</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($schedule->description)
                        <div>
                            <h5 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Deskripsi</h5>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $schedule->description }}</p>
                        </div>
                    @endif

                    @if($schedule->notes)
                        <div>
                            <h5 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Catatan</h5>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $schedule->notes }}</p>
                        </div>
                    @endif
                </div>

                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t dark:border-neutral-700 mt-6">
                    <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800" data-hs-overlay="#show-schedule-modal-{{ $schedule->id }}">
                        Tutup
                    </button>
                    <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-yellow-600 text-white hover:bg-yellow-700 disabled:opacity-50 disabled:pointer-events-none" data-hs-overlay="#edit-schedule-modal-{{ $schedule->id }}">
                        Edit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>