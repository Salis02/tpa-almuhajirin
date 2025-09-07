<div id="edit-schedule-modal-{{ $schedule->id }}" class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto">
    <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-4xl sm:w-full m-3 sm:mx-auto">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-900 dark:border-neutral-700">
            <div class="p-4 overflow-y-auto max-h-[90vh]">
                <div class="flex justify-between items-center py-3 px-4 border-b dark:border-neutral-700">
                    <h3 class="font-bold text-gray-800 dark:text-white">Edit Jadwal KBM</h3>
                    <button type="button" class="flex justify-center items-center size-7 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700" data-hs-overlay="#edit-schedule-modal-{{ $schedule->id }}">
                        <span class="sr-only">Close</span>
                        <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m18 6-12 12"/>
                            <path d="m6 6 12 12"/>
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('schedule.update', $schedule) }}" class="p-4">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Left Column - Basic Info -->
                        <div class="space-y-4">
                            <div class="border-b border-gray-200 dark:border-neutral-700 pb-4">
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Jadwal</h4>
                            </div>

                            <!-- Title -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Judul *</label>
                                <input type="text" name="title" required value="{{ $schedule->title }}"
                                       class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                            </div>

                            <!-- Class -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Kelas *</label>
                                <select name="class_id" required id="edit_class_select_{{ $schedule->id }}" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600">
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ $schedule->class_id == $class->id ? 'selected' : '' }}>
                                            {{ $class->display_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Schedule Type -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Jenis Kegiatan *</label>
                                <select name="schedule_type_id" required id="edit_schedule_type_select_{{ $schedule->id }}" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600">
                                    @foreach($scheduleTypes as $type)
                                        <option value="{{ $type->id }}" {{ $schedule->schedule_type_id == $type->id ? 'selected' : '' }} data-max-participants="{{ $type->max_participants }}">
                                            {{ $type->display_name }} ({{ $type->description }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Ustadz -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Ustadz/Ustadzah *</label>
                                <select name="ustadz_id" required class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600">
                                    @foreach($ustadzList as $ustadz)
                                        <option value="{{ $ustadz->id }}" {{ $schedule->ustadz_id == $ustadz->id ? 'selected' : '' }}>
                                            {{ $ustadz->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Date -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Tanggal *</label>
                                {{-- <input type="date" name="date" required value="{{ $schedule->date->format('Y-m-d') }}"
                                       class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600"> --}}
                                       <input type="time" name="start_time" required value="{{ $schedule->start_time_carbon->format('H:i') }}"
                                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600"
                                       >
                            </div>

                            <!-- Time -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-2 dark:text-white">Waktu Mulai *</label>
                                    {{-- <input type="time" name="start_time" required value="{{ $schedule->start_time->format('H:i') }}"
                                           class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600"> --}}
                                           <input type="time" name="end_time" required value="{{ $schedule->end_time_carbon->format('H:i') }}"
                                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600"
                                           >
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-2 dark:text-white">Waktu Selesai *</label>
                                    <input type="time" name="end_time" required value="{{ $schedule->end_time_carbon->format('H:i') }}"
                                           class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600">
                                </div>
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Status *</label>
                                <select name="status" required class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:ring-neutral-600">
                                    <option value="scheduled" {{ $schedule->status === 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                                    <option value="ongoing" {{ $schedule->status === 'ongoing' ? 'selected' : '' }}>Berlangsung</option>
                                    <option value="completed" {{ $schedule->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                                    <option value="cancelled" {{ $schedule->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                            </div>
                        </div>

                        <!-- Right Column - Additional Info -->
                        <div class="space-y-4">
                            <div class="border-b border-gray-200 dark:border-neutral-700 pb-4">
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Detail & Peserta</h4>
                            </div>

                            <!-- Location -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Lokasi</label>
                                <input type="text" name="location" value="{{ $schedule->location }}"
                                       class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                            </div>

                            <!-- Max Participants -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Maksimal Peserta</label>
                                <input type="number" name="max_participants" min="1" max="50" value="{{ $schedule->max_participants }}" id="edit_max_participants_input_{{ $schedule->id }}"
                                       class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                            </div>

                            <!-- Description -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Deskripsi</label>
                                <textarea name="description" rows="3"
                                          class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">{{ $schedule->description }}</textarea>
                            </div>

                            <!-- Participants Selection -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Pilih Peserta</label>
                                <div id="edit_santri_list_{{ $schedule->id }}" class="max-h-40 overflow-y-auto border border-gray-200 rounded-lg p-3 dark:border-neutral-700">
                                    @php
                                        $classSantris = \App\Models\Santri::where('class_id', $schedule->class_id)->where('status', 'active')->get();
                                        $participantIds = $schedule->participants->pluck('santri_id')->toArray();
                                    @endphp
                                    
                                    @if($classSantris->count() > 0)
                                        @foreach($classSantris as $santri)
                                            <div class="flex items-center space-x-2 mb-2">
                                                <input type="checkbox" name="santri_ids[]" value="{{ $santri->id }}" 
                                                       {{ in_array($santri->id, $participantIds) ? 'checked' : '' }}
                                                       class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                                <label class="text-sm text-gray-700 dark:text-gray-300">
                                                    {{ $santri->full_name }} ({{ $santri->nis }})
                                                </label>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada santri aktif di kelas ini</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Notes -->
                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Catatan</label>
                                <textarea name="notes" rows="2"
                                          class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                          placeholder="Catatan tambahan (opsional)">{{ $schedule->notes }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t dark:border-neutral-700 mt-6">
                        <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800" data-hs-overlay="#edit-schedule-modal-{{ $schedule->id }}">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editClassSelect{{ $schedule->id }} = document.getElementById('edit_class_select_{{ $schedule->id }}');
    const editScheduleTypeSelect{{ $schedule->id }} = document.getElementById('edit_schedule_type_select_{{ $schedule->id }}');
    const editSantriList{{ $schedule->id }} = document.getElementById('edit_santri_list_{{ $schedule->id }}');
    const editMaxParticipantsInput{{ $schedule->id }} = document.getElementById('edit_max_participants_input_{{ $schedule->id }}');

    // Handle schedule type change for edit modal
    if (editScheduleTypeSelect{{ $schedule->id }}) {
        editScheduleTypeSelect{{ $schedule->id }}.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const maxParticipants = selectedOption.getAttribute('data-max-participants');
            if (maxParticipants && editMaxParticipantsInput{{ $schedule->id }}) {
                editMaxParticipantsInput{{ $schedule->id }}.placeholder = `Default: ${maxParticipants}`;
            }
        });
    }

    // Handle class selection for edit modal
    if (editClassSelect{{ $schedule->id }}) {
        editClassSelect{{ $schedule->id }}.addEventListener('change', function() {
            const classId = this.value;
            if (classId && editSantriList{{ $schedule->id }}) {
                fetchSantrisByClassForEdit(classId, {{ $schedule->id }});
            }
        });
    }

    function fetchSantrisByClassForEdit(classId, scheduleId) {
        fetch(`/api/santri-by-class/${classId}`)
            .then(response => response.json())
            .then(santris => {
                let html = '';
                if (santris.length > 0) {
                    santris.forEach(santri => {
                        html += `
                            <div class="flex items-center space-x-2 mb-2">
                                <input type="checkbox" name="santri_ids[]" value="${santri.id}" 
                                       class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <label class="text-sm text-gray-700 dark:text-gray-300">
                                        ${santri.full_name} (${santri.nis})
                                    </label>
                                </div>
                            `;
                        });
                    } else {
                        html = '<p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada santri aktif di kelas ini</p>';
                    }
                    document.getElementById(`edit_santri_list_${scheduleId}`).innerHTML = html;
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById(`edit_santri_list_${scheduleId}`).innerHTML = '<p class="text-sm text-red-500">Error loading santri data</p>';
                });
        }
    });
</script>