<div id="delete-report-modal-{{ $report->id }}" class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto">
  <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 
              mt-0 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-900 dark:border-neutral-700">

      <!-- Header -->
      <div class="flex justify-between items-center py-3 px-4 border-b dark:border-neutral-700">
        <h3 class="font-bold text-gray-800 dark:text-white">Hapus Laporan</h3>
        <button type="button"
                class="size-7 flex justify-center items-center rounded-full hover:bg-gray-100 dark:hover:bg-neutral-700"
                data-hs-overlay="#delete-report-modal-{{ $report->id }}">
          ✕
        </button>
      </div>

      <!-- Body -->
      <div class="p-4">
        <p class="text-gray-700 dark:text-gray-300">
          Yakin ingin menghapus laporan <span class="font-semibold">{{ $report->santri->full_name }}</span> (Periode: {{ $report->period_label }})?
        </p>
      </div>

      <!-- Footer -->
      <div class="flex justify-end gap-x-2 py-3 px-4 border-t dark:border-neutral-700">
        <button type="button"
                class="py-2 px-3 rounded-lg border bg-white text-gray-800 hover:bg-gray-50 dark:bg-neutral-900 dark:text-white dark:hover:bg-neutral-800"
                data-hs-overlay="#delete-report-modal-{{ $report->id }}">
          Batal
        </button>
        <form action="{{ route('report.destroy', $report->id) }}" method="POST">
          @csrf @method('DELETE')
          <button type="submit" class="py-2 px-3 rounded-lg bg-red-600 text-white hover:bg-red-700">
            Hapus
          </button>
        </form>
      </div>

    </div>
  </div>
</div>
