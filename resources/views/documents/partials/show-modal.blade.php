<div id="show-document-modal-{{ $document->id }}" class="hs-overlay hidden fixed inset-0 z-[80] overflow-y-auto">
    <div class="hs-overlay-open:mt-7 mx-3 sm:mx-auto sm:w-full sm:max-w-4xl">
        <div
            class="relative flex flex-col bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-900 dark:border-neutral-700">

            <!-- Header -->
            <div class="flex items-center justify-between px-4 py-3 border-b dark:border-neutral-700">
                <h3 class="text-base font-semibold text-gray-800 dark:text-neutral-200">
                    Detail Dokumen
                </h3>
                <button type="button"
                    class="inline-flex items-center justify-center size-8 rounded-full text-gray-500 hover:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-800"
                    data-hs-overlay="#show-document-modal-{{ $document->id }}">
                    ✖
                </button>
            </div>

            <!-- Content -->
            <div class="p-4 sm:p-6 space-y-4">
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Judul</span>
                        <span class="text-sm font-medium text-gray-800 dark:text-gray-200">
                            {{ $document->title }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Kategori</span>
                        <span class="text-sm font-medium text-gray-800 dark:text-gray-200">
                            {{ $document->category ?? '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Deskripsi</span>
                        <span class="text-sm font-medium text-gray-800 dark:text-gray-200">
                            {{ $document->description ?? '-' }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Diunggah</span>
                        <span class="text-sm font-medium text-gray-800 dark:text-gray-200">
                            {{ $document->created_at->format('d M Y') }}
                        </span>
                    </div>
                </div>

                <div class="mt-4">
                    <iframe src="{{ asset('storage/' . $document->file_path) }}"
                        class="w-full h-[500px] rounded-lg border dark:border-neutral-700"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
