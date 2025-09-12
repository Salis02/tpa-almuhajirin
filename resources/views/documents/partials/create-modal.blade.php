<div id="create-document-modal" class="hs-overlay hidden fixed inset-0 z-[80] overflow-y-auto overflow-x-hidden">
  <div class="hs-overlay-open:mt-7 mx-3 sm:mx-auto sm:w-full sm:max-w-3xl transition-all ease-out">
    <div class="relative flex flex-col bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-neutral-900 dark:border-neutral-700">
      
      <!-- Header -->
      <div class="flex items-center justify-between px-4 py-3 border-b dark:border-neutral-700">
        <h3 class="text-base font-semibold text-gray-800 dark:text-neutral-200">
          Tambah Dokumen
        </h3>
        <button type="button" class="inline-flex items-center justify-center size-8 rounded-full text-gray-500 hover:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-800" data-hs-overlay="#create-document-modal">
          <span class="sr-only">Close</span>
          ✖
        </button>
      </div>

      <!-- Form -->
      <form method="POST" action="{{ route('document.store') }}" enctype="multipart/form-data" class="p-4 sm:p-6">
        @csrf
        <div class="space-y-5">
          <!-- Judul -->
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-neutral-200">Judul *</label>
            <input type="text" name="title" required placeholder="Masukkan judul dokumen"
              class="block w-full px-3 py-2 text-sm border border-gray-200 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200 dark:placeholder-neutral-500" />
          </div>

          <!-- Deskripsi -->
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-neutral-200">Deskripsi</label>
            <textarea name="description" rows="3" placeholder="Masukkan deskripsi"
              class="block w-full px-3 py-2 text-sm border border-gray-200 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-200 dark:placeholder-neutral-500"></textarea>
          </div>

          <!-- Kategori -->
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-neutral-200">Kategori</label>
            <select name="category"
              class="block w-full px-3 py-2 text-sm border border-gray-200 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300">
              <option value="">Pilih kategori</option>
              @foreach($categories as $cat)
                <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
              @endforeach
            </select>
          </div>

          <!-- File -->
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-neutral-200">Upload File *</label>
            <input type="file" name="file" required
              class="block w-full text-sm border border-gray-200 rounded-lg cursor-pointer focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-300 file:px-3 file:py-2 file:border-0 file:rounded-md file:text-sm file:font-medium file:bg-blue-600 file:text-white hover:file:bg-blue-700" />
          </div>
        </div>

        <!-- Footer -->
        <div class="flex items-center justify-end gap-x-3 px-4 py-3 mt-6 border-t dark:border-neutral-700">
          <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 dark:bg-neutral-900 dark:text-neutral-200 dark:border-neutral-700 dark:hover:bg-neutral-800" data-hs-overlay="#create-document-modal">
            Batal
          </button>
          <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700">
            Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
