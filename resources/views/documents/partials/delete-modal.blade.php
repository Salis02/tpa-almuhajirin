<div id="delete-document-modal-{{ $document->id }}" class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto backdrop-brightness-50">
  <div class="hs-overlay-open:mt-7 sm:max-w-lg sm:w-full m-3 sm:mx-auto">
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-900 dark:border-neutral-700">

      <!-- Header -->
      <div class="flex justify-between items-center py-3 px-4 border-b dark:border-neutral-700">
        <h3 class="font-bold text-gray-800 dark:text-white">Hapus Document</h3>
        <button type="button" data-hs-overlay="#delete-document-modal-{{ $document->id }}">✖</button>
      </div>

      <!-- Body -->
      <div class="p-4">
        <p class="text-gray-700 dark:text-gray-300">
          Apakah Anda yakin ingin menghapus document <span class="font-semibold">{{ $document->title }}</span>?
        </p>
      </div>

      <!-- Footer -->
      <div class="flex justify-end gap-x-2 py-3 px-4 border-t dark:border-neutral-700">
        <button type="button" class="py-2 px-3 text-sm rounded-lg border border-gray-200 bg-white hover:bg-gray-50 dark:bg-neutral-900 dark:text-white" data-hs-overlay="#delete-document-modal-{{ $document->id }}">Batal</button>
        <form action="{{ route('document.destroy', $document->id) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="py-2 px-3 text-sm font-semibold rounded-lg bg-red-600 text-white hover:bg-red-700">Hapus</button>
        </form>
      </div>
    </div>
  </div>
</div>
