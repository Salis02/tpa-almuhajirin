<x-app-layout title="Kelola Dokumen - TPA Al Muhajirin">
    <div class="space-y-6">
        {{-- Alert Messages --}}
        @if (session('success'))
            <div
                class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-900/20 dark:text-green-400">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-900/20 dark:text-red-400">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-900/20 dark:text-red-400">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Kelola Dokumen</h1>
                <p class="text-gray-600 dark:text-gray-400">Manajemen dokumen penting TPA Al Muhajirin</p>
            </div>
            <button type="button"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors"
                data-hs-overlay="#create-document-modal">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Dokumen
            </button>
        </div>

        <!-- Filter -->
        <div
            class="bg-white dark:bg-neutral-900 rounded-lg p-6 shadow-sm border border-gray-200 dark:border-neutral-700">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cari Dokumen</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Judul atau kategori..."
                        class="border py-3 px-4 pe-9 block w-full border-gray-200 rounded-full text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500">
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kategori</label>
                    <select name="category"
                        class="border py-3 px-4 block w-full border-gray-200 rounded-full text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>
                                {{ ucfirst($cat) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Actions -->
                <div class="flex items-end space-x-2">
                    <button type="submit"
                        class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                        Filter
                    </button>
                    <a href="{{ route('document.index') }}"
                        class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg transition-colors">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Documents Grid -->
        @if ($documents->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @foreach ($documents as $document)
                    <div
                        class="bg-white dark:bg-neutral-900 rounded-lg shadow-sm border border-gray-200 dark:border-neutral-700 overflow-hidden">
                        <!-- Icon / File Preview -->
                        <div
                            class="aspect-square bg-gray-100 dark:bg-neutral-800 flex items-center justify-center text-gray-500 dark:text-gray-400">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 21h10a2 2 0 002-2V7l-6-4H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>

                        <!-- Content -->
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-1">{{ $document->title }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ $document->category ?? '-' }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">Diunggah
                                {{ $document->created_at->diffForHumans() }}</p>

                            <!-- Actions -->
                            <div class="flex space-x-2">
                                <button type="button" data-hs-overlay="#show-document-modal-{{ $document->id }}"
                                    class="flex-1 text-center px-3 py-2 text-sm bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-lg transition-colors dark:bg-blue-900/20 dark:text-blue-400 dark:hover:bg-blue-900/30">
                                    Lihat
                                </button>
                                <button type="button" data-hs-overlay="#edit-document-modal-{{ $document->id }}"
                                    class="flex-1 text-center px-3 py-2 text-sm bg-yellow-50 text-yellow-700 hover:bg-yellow-100 rounded-lg transition-colors dark:bg-yellow-900/20 dark:text-yellow-400 dark:hover:bg-yellow-900/30">
                                    Edit
                                </button>
                                <button type="button" data-hs-overlay="#delete-document-modal-{{ $document->id }}"
                                    class="flex-1 text-center px-3 py-2 text-sm bg-red-50 text-red-700 hover:bg-red-100 rounded-lg transition-colors dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/30">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Show Modal --}}
                    @include('documents.partials.show-modal', ['document' => $document])

                    <!-- Edit Modal -->
                    @include('documents.partials.edit-modal', ['document' => $document])

                    <!-- Delete Modal -->
                    @include('documents.partials.delete-modal', ['document' => $document])
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $documents->links() }}
            </div>
        @else
            <div
                class="bg-white dark:bg-neutral-900 rounded-lg p-12 text-center shadow-sm border border-gray-200 dark:border-neutral-700">
                <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-500 mb-4" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 21h10a2 2 0 002-2V7l-6-4H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum ada dokumen</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-4">Mulai dengan mengunggah dokumen pertama</p>
                <button type="button"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors"
                    data-hs-overlay="#create-document-modal">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Tambah Dokumen
                </button>
            </div>
        @endif
    </div>

    <!-- Create Modal -->
    @include('documents.partials.create-modal')
</x-app-layout>
