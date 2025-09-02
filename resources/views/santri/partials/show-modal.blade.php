<div id="show-santri-modal-{{ $santri->id }}" class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto">
    <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all sm:max-w-3xl sm:w-full m-3 sm:mx-auto">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-900 dark:border-neutral-700">
            <div class="flex justify-between items-center py-3 px-4 border-b dark:border-neutral-700">
                <h3 class="font-bold text-gray-800 dark:text-white">Detail Data Santri</h3>
                <button type="button" class="flex justify-center items-center size-7 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700" data-hs-overlay="#show-santri-modal-{{ $santri->id }}">
                    <span class="sr-only">Close</span>
                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m18 6-12 12"/>
                        <path d="m6 6 12 12"/>
                    </svg>
                </button>
            </div>

            <div class="p-4 overflow-y-auto">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Photo -->
                    <div class="lg:col-span-1">
                        <div class="aspect-square bg-gray-100 dark:bg-neutral-800 rounded-lg overflow-hidden">
                            <img src="{{ $santri->photo_url }}" 
                                 alt="{{ $santri->display_name }}"
                                 class="w-full h-full object-cover">
                        </div>
                        
                        <div class="mt-4 text-center">
                            <span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium 
                                {{ $santri->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400' }}">
                                {{ ucfirst($santri->status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Data Personal -->
                    <div class="lg:col-span-2">
                        <div class="space-y-6">
                            <!-- Data Pribadi -->
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Data Pribadi</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">NIS</label>
                                        <p class="text-sm text-gray-900 dark:text-white">{{ $santri->nis }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Nama Lengkap</label>
                                        <p class="text-sm text-gray-900 dark:text-white">{{ $santri->full_name }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Nama Panggilan</label>
                                        <p class="text-sm text-gray-900 dark:text-white">{{ $santri->nickname ?: '-' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Jenis Kelamin</label>
                                        <p class="text-sm text-gray-900 dark:text-white">{{ $santri->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Tempat, Tanggal Lahir</label>
                                        <p class="text-sm text-gray-900 dark:text-white">{{ $santri->birth_place }}, {{ $santri->birth_date->format('d F Y') }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Umur</label>
                                        <p class="text-sm text-gray-900 dark:text-white">{{ $santri->age }} tahun</p>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Alamat</label>
                                        <p class="text-sm text-gray-900 dark:text-white">{{ $santri->address }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Orang Tua/Wali -->
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Data Orang Tua/Wali</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Nama Ayah</label>
                                        <p class="text-sm text-gray-900 dark:text-white">{{ $santri->father_name }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Nama Ibu</label>
                                        <p class="text-sm text-gray-900 dark:text-white">{{ $santri->mother_name }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Nama Wali</label>
                                        <p class="text-sm text-gray-900 dark:text-white">{{ $santri->guardian_name ?: '-' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">No. HP Wali</label>
                                        <p class="text-sm text-gray-900 dark:text-white">{{ $santri->guardian_phone }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Akademik -->
                            <div>
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Data Akademik</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Kelas</label>
                                        <p class="text-sm text-gray-900 dark:text-white">{{ $santri->tpaClass->display_name }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Masuk</label>
                                        <p class="text-sm text-gray-900 dark:text-white">{{ $santri->enrollment_date->format('d F Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t dark:border-neutral-700 mt-6">
                    <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800" data-hs-overlay="#show-santri-modal-{{ $santri->id }}">
                        Tutup
                    </button>
                    <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-yellow-600 text-white hover:bg-yellow-700 disabled:opacity-50 disabled:pointer-events-none" data-hs-overlay="#edit-santri-modal-{{ $santri->id }}">
                        Edit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>