<div id="create-rapot-modal"
    class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto">
    <div
        class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-5xl sm:w-full m-3 sm:mx-auto">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-900 dark:border-neutral-700">
            <div class="p-4 overflow-y-auto">

                <!-- Header -->
                <div class="flex justify-between items-center py-3 px-4 border-b dark:border-neutral-700">
                    <h3 class="font-bold text-gray-800 dark:text-white">
                        Tambah Rapot Santri
                    </h3>
                    <button type="button"
                        class="flex justify-center items-center size-7 text-sm font-semibold rounded-full hover:bg-gray-100 dark:hover:bg-neutral-700"
                        data-hs-overlay="#create-rapot-modal">
                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m18 6-12 12M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('rapot.store') }}" class="p-4">
                    @csrf

                    <!-- Identitas -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium mb-2">Santri</label>
                            <select name="santri_id" required
                                class="py-3 px-4 block w-full rounded-lg border-gray-200 text-sm">
                                <option value="">Pilih Santri</option>
                                @foreach ($santris as $santri)
                                    <option value="{{ $santri->id }}">
                                        {{ $santri->full_name }} ({{ $santri->nis }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Kelas</label>
                            <select name="kelas" required
                                class="py-3 px-4 block w-full rounded-lg border-gray-200 text-sm">
                                @foreach ($classes as $class)
                                    <option value="{{ $class->display_name }}">
                                        {{ $class->display_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Semester</label>
                            <select name="semester" required
                                class="py-3 px-4 block w-full rounded-lg border-gray-200 text-sm">
                                <option value="Ganjil">Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Tahun Ajaran</label>
                            <input type="text" name="tahun_ajaran" required
                                value="{{ date('Y') }}/{{ date('Y') + 1 }}"
                                class="py-3 px-4 block w-full rounded-lg border-gray-200 text-sm">
                        </div>
                    </div>

                    <!-- Nilai -->
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                        @php
                            // Daftar ini disesuaikan persis dengan variabel di Apps Script
                            $fields = [
                                'tahsin' => 'Tahsin',
                                'khot' => 'Khot',
                                'hafalan' => 'Hafalan',
                                'praktek_sholat' => 'Praktek Sholat',
                                'praktek_wudhu' => 'Praktek Wudhu',
                                'aqidah' => 'Aqidah',
                                'doa_harian' => 'Doa Harian',
                                'ayat_pilihan' => 'Ayat Pilihan',
                                'qiroah' => 'Qiroah',
                                'tajwid' => 'Tajwid',
                            ];
                        @endphp

                        @foreach ($fields as $key => $label)
                            <div>
                                <label class="block text-sm font-medium mb-2">{{ $label }}</label>
                                <input type="number" name="nilai[{{ $key }}]" min="0" max="100"
                                    required class="py-3 px-4 block w-full rounded-lg border-gray-200 text-sm"
                                    placeholder="0-100">
                            </div>
                        @endforeach
                    </div>

                    <!-- Tambahan -->
                    <div class="space-y-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium mb-2">Materi</label>
                            <input type="number" name="materi" min="0" max="100" required
                                class="py-3 px-4 block w-full rounded-lg border-gray-200 text-sm" placeholder="0-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Catatan Pengajar</label>
                            <textarea name="catatan" rows="3" class="py-3 px-4 block w-full rounded-lg border-gray-200 text-sm"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Status Rapot</label>
                            <select name="status_rapot"
                                class="py-3 px-4 block w-full rounded-lg border-gray-200 text-sm">
                                <option value="draft">Draft</option>
                                <option value="final">Final</option>
                            </select>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="flex justify-end gap-x-2 pt-4 border-t dark:border-neutral-700">
                        <button type="button" class="py-2 px-4 text-sm rounded-lg border bg-white"
                            data-hs-overlay="#create-rapot-modal">
                            Batal
                        </button>
                        <button type="submit"
                            class="py-2 px-4 text-sm font-semibold rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                            Simpan Rapot
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
