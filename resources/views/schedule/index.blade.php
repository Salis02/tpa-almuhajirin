<x-app-layout title="Penjadwalan KBM - TPA Al Muhajirin">
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
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Penjadwalan KBM</h1>
                <p class="text-gray-600 dark:text-gray-400">Kelola jadwal kegiatan belajar mengajar TPA</p>
            </div>
            <div class="flex space-x-3">
                <button type="button" id="calendar-view-btn"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Tampilan Kalender
                </button>
                <button type="button" 
                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors"
                        data-hs-overlay="#create-schedule-modal">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Buat Jadwal
                </button>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white dark:bg-neutral-900 rounded-lg p-6 shadow-sm border border-gray-200 dark:border-neutral-700">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-6 gap-4">
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

                <!-- Schedule Type Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jenis Kegiatan</label>
                    <select name="schedule_type_id" class="w-full rounded-lg border-gray-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-white">
                        <option value="">Semua Jenis</option>
                        @foreach($scheduleTypes as $type)
                            <option value="{{ $type->id }}" {{ request('schedule_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->display_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                    <select name="status" class="w-full rounded-lg border-gray-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-white">
                        <option value="">Semua Status</option>
                        <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                        <option value="ongoing" {{ request('status') === 'ongoing' ? 'selected' : '' }}>Berlangsung</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                <!-- Date From -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal Dari</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                           class="w-full rounded-lg border-gray-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-white">
                </div>

                <!-- Date To -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal Sampai</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                           class="w-full rounded-lg border-gray-300 dark:border-neutral-600 dark:bg-neutral-800 dark:text-white">
                </div>

                <!-- Actions -->
                <div class="flex items-end space-x-2">
                    <button type="submit" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                        Filter
                    </button>
                    <a href="{{ route('schedule.index') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg transition-colors">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @php
                $totalSchedules = \App\Models\Schedule::count();
                $todaySchedules = \App\Models\Schedule::whereDate('date', today())->count();
                $upcomingSchedules = \App\Models\Schedule::where('date', '>', today())->where('status', 'scheduled')->count();
                $completedSchedules = \App\Models\Schedule::where('status', 'completed')->count();
            @endphp
            
            <div class="bg-white dark:bg-neutral-900 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-neutral-700">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Jadwal</h3>
                <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $totalSchedules }}</p>
            </div>
            
            <div class="bg-white dark:bg-neutral-900 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-neutral-700">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Jadwal Hari Ini</h3>
                <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $todaySchedules }}</p>
            </div>
            
            <div class="bg-white dark:bg-neutral-900 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-neutral-700">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Akan Datang</h3>
                <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ $upcomingSchedules }}</p>
            </div>
            
            <div class="bg-white dark:bg-neutral-900 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-neutral-700">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Selesai</h3>
                <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $completedSchedules }}</p>
            </div>
        </div>

        <!-- Schedule List -->
        <div id="schedule-list-view">
            @if($schedules->count() > 0)
                <div class="space-y-4">
                    @foreach($schedules as $schedule)
                        <div class="bg-white dark:bg-neutral-900 rounded-lg shadow-sm border border-gray-200 dark:border-neutral-700 p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <span class="text-xs font-medium px-2 py-1 rounded-full 
                                            @if($schedule->scheduleType->name === 'setoran') bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400
                                            @elseif($schedule->scheduleType->name === 'praktek') bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400
                                            @else bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-400 @endif">
                                            {{ $schedule->scheduleType->display_name }}
                                        </span>
                                        <span class="text-xs font-medium px-2 py-1 rounded-full 
                                            {{ $schedule->status === 'scheduled' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400' : 
                                               ($schedule->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400') }}">
                                            {{ ucfirst($schedule->status) }}
                                        </span>
                                    </div>
                                    
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">{{ $schedule->title }}</h3>
                                    <div class="flex items-center space-x-6 text-sm text-gray-600 dark:text-gray-400">
                                        <span>{{ $schedule->tpaClass->display_name }}</span>
                                        <span>{{ $schedule->ustadz->full_name }}</span>
                                        <span>{{ $schedule->date->format('d M Y') }}</span>
                                        {{-- <span>{{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}</span> --}}
                                        <span>{{ $schedule->start_time_carbon->format('H:i') }} - {{ $schedule->end_time_carbon->format('H:i') }}</span>
                                        <span>{{ $schedule->participant_count }} peserta</span>
                                    </div>
                                </div>
                                
                                <div class="flex space-x-2">
                                    <button type="button"
                                            data-hs-overlay="#show-schedule-modal-{{ $schedule->id }}"
                                            class="px-3 py-2 text-sm bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-lg transition-colors dark:bg-blue-900/20 dark:text-blue-400 dark:hover:bg-blue-900/30">
                                        Detail
                                    </button>
                                    <button type="button"
                                            data-hs-overlay="#edit-schedule-modal-{{ $schedule->id }}"
                                            class="px-3 py-2 text-sm bg-yellow-50 text-yellow-700 hover:bg-yellow-100 rounded-lg transition-colors dark:bg-yellow-900/20 dark:text-yellow-400 dark:hover:bg-yellow-900/30">
                                        Edit
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Show Modal -->
                        @include('schedule.partials.show-modal', ['schedule' => $schedule])
                        
                        <!-- Edit Modal -->
                        @include('schedule.partials.edit-modal', ['schedule' => $schedule, 'classes' => $classes, 'scheduleTypes' => $scheduleTypes, 'ustadzList' => $ustadzList])
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $schedules->links() }}
                </div>
            @else
                <div class="bg-white dark:bg-neutral-900 rounded-lg p-12 text-center shadow-sm border border-gray-200 dark:border-neutral-700">
                    <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum ada jadwal</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Mulai dengan membuat jadwal KBM pertama</p>
                    <button type="button" 
                            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors"
                            data-hs-overlay="#create-schedule-modal">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Buat Jadwal
                    </button>
                </div>
            @endif
        </div>

        <!-- Calendar View (Hidden by default) -->
        <div id="calendar-view" class="hidden">
            <div class="bg-white dark:bg-neutral-900 rounded-lg shadow-sm border border-gray-200 dark:border-neutral-700 p-6">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    @include('schedule.partials.create-modal', ['classes' => $classes, 'scheduleTypes' => $scheduleTypes, 'ustadzList' => $ustadzList])

    <x-slot name="scripts">
        <!-- FullCalendar CDN -->
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
        <script>
            // Calendar toggle functionality
            document.getElementById('calendar-view-btn').addEventListener('click', function() {
                const listView = document.getElementById('schedule-list-view');
                const calendarView = document.getElementById('calendar-view');
                
                if (calendarView.classList.contains('hidden')) {
                    listView.classList.add('hidden');
                    calendarView.classList.remove('hidden');
                    this.textContent = 'Tampilan List';
                    initCalendar();
                } else {
                    listView.classList.remove('hidden');
                    calendarView.classList.add('hidden');
                    this.textContent = 'Tampilan Kalender';
                }
            });

            function initCalendar() {
                const calendarEl = document.getElementById('calendar');
                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    events: '{{ route("schedule.calendar") }}',
                    eventClick: function(info) {
                        // Handle event click - show modal or redirect
                        alert('Event: ' + info.event.title);
                    },
                    height: 600
                });
                calendar.render();
            }
        </script>
    </x-slot>
</x-app-layout>