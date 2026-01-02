<div id="edit-rapot-modal-{{ $loop->index }}"
    class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto">
    <div
        class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-4xl sm:w-full m-3 sm:mx-auto">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-900 dark:border-neutral-700">
            <div class="p-4">
                <div class="flex justify-between items-center py-3 px-4 border-b dark:border-neutral-700">
                    <h3 class="font-bold text-gray-800 dark:text-white">Edit Raport: {{ $raport['nama_santri'] }}</h3>
                    <button type="button" class="text-gray-800 dark:text-white"
                        data-hs-overlay="#edit-rapot-modal-{{ $loop->index }}">
                        <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="m18 6-12 12m0-6 12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('rapot.update') }}" class="p-4">
                    @csrf
                    @method('PATCH')

                    <input type="hidden" name="timestamp" value="{{ $raport['timestamp'] }}">
                    <input type="hidden" name="nis" value="{{ $raport['nis'] }}">
                    <input type="hidden" name="nama_santri" value="{{ $raport['nama_santri'] }}">
                    <input type="hidden" name="kelas" value="{{ $raport['kelas'] }}">

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-2 dark:text-white">Tahun Ajaran</label>
                                    <input type="text" name="tahun_ajaran" value="{{ $raport['tahun_ajaran'] }}"
                                        class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm dark:bg-neutral-800"
                                        readonly>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-2 dark:text-white">Semester</label>
                                    <input type="text" name="semester" value="{{ $raport['semester'] }}"
                                        class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm dark:bg-neutral-800"
                                        readonly>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Ustadz Penguji</label>
                                <input type="text" name="ustadz" value="{{ $raport['ustadz'] }}" required
                                    class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm dark:bg-neutral-800 dark:text-white"
                                    readonly>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Materi Utama</label>
                                <input type="number" name="materi" rows="3" value="{{ $raport['materi'] }}"
                                    class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm dark:bg-neutral-800 dark:text-white">
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2 dark:text-white">Catatan</label>
                                <textarea name="catatan" rows="3"
                                    class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm dark:bg-neutral-800 dark:text-white">{{ $raport['catatan'] }}</textarea>
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-neutral-800/50 p-4 rounded-xl">
                            <h4 class="text-sm font-bold mb-4 text-blue-600 uppercase">Input Nilai</h4>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                @foreach ($raport['nilai'] as $key => $val)
                                    <div>
                                        <label
                                            class="block text-[10px] uppercase font-bold mb-1 text-gray-500">{{ str_replace('_', ' ', $key) }}</label>
                                        <input type="number" name="nilai[{{ $key }}]"
                                            value="{{ $val }}"
                                            class="py-2 px-2 block w-full border-gray-200 rounded-md text-sm dark:bg-neutral-900 dark:text-white">
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-6">
                                <label class="block text-sm font-medium mb-2 dark:text-white">Status Raport</label>
                                <select name="status_raport"
                                    class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm dark:bg-neutral-900">
                                    <option value="Draft" {{ $raport['status_raport'] == 'Draft' ? 'selected' : '' }}>
                                        Draft</option>
                                    <option value="Final" {{ $raport['status_raport'] == 'Final' ? 'selected' : '' }}>
                                        Final (Siap Cetak)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t dark:border-neutral-700 mt-6">
                        <button type="button"
                            class="py-2 px-3 text-sm font-medium rounded-lg border bg-white dark:bg-neutral-900 dark:text-white"
                            data-hs-overlay="#edit-rapot-modal-{{ $loop->index }}">Batal</button>
                        <button type="submit"
                            class="py-2 px-4 text-sm font-semibold rounded-lg bg-blue-600 text-white hover:bg-blue-700">Simpan
                            Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
