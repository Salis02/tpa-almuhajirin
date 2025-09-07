<!-- Delete Modal -->
<div id="delete-santri-modal-{{ $santri->id }}" class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto">
  <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 
              mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm 
                dark:bg-neutral-900 dark:border-neutral-700">
      
      <!-- Header -->
      <div class="flex justify-between items-center py-3 px-4 border-b dark:border-neutral-700">
        <h3 class="font-bold text-gray-800 dark:text-white">
          Hapus Data Santri
        </h3>
        <button type="button" 
                class="flex justify-center items-center size-7 text-sm font-semibold rounded-full border border-transparent 
                       text-gray-800 hover:bg-gray-100 dark:text-white dark:hover:bg-neutral-700"
                data-hs-overlay="#delete-santri-modal-{{ $santri->id }}">
          <span class="sr-only">Close</span>
          <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
               stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m18 6-12 12"/>
            <path d="m6 6 12 12"/>
          </svg>
        </button>
      </div>

      <!-- Body -->
      <div class="p-4">
        <p class="text-gray-700 dark:text-gray-300">
          Apakah Anda yakin ingin menghapus santri 
          <span class="font-semibold">{{ $santri->display_name }}</span> 
          (NIS: {{ $santri->nis }})?
        </p>
      </div>

      <!-- Footer -->
      <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t dark:border-neutral-700">
        <button type="button"
                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border 
                       border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 
                       dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800"
                data-hs-overlay="#delete-santri-modal-{{ $santri->id }}">
          Batal
        </button>
        <form action="{{ route('santri.destroy', $santri->id) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit"
                  class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border 
                         border-transparent bg-red-600 text-white hover:bg-red-700">
            Hapus
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
