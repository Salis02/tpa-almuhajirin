<x-app-layout title="Dashboard - TPA Al Muhajirin">
    <x-slot name="head">
        <!-- Custom head content -->
        <meta name="description" content="Dashboard TPA Al Muhajirin">
    </x-slot>

    <!-- Page Content -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
        <p class="text-gray-600 dark:text-gray-400">Selamat datang di TPA Al Muhajirin</p>
    </div>

    <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
        <div class="p-6 bg-white dark:bg-neutral-900 rounded-2xl shadow-sm border border-gray-200 dark:border-neutral-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Total Santri</h3>
            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">150</p>
        </div>

        <div class="p-6 bg-white dark:bg-neutral-900 rounded-2xl shadow-sm border border-gray-200 dark:border-neutral-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Ustadz</h3>
            <p class="text-3xl font-bold text-green-600 dark:text-green-400">12</p>
        </div>

        <div class="p-6 bg-white dark:bg-neutral-900 rounded-2xl shadow-sm border border-gray-200 dark:border-neutral-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Kelas Aktif</h3>
            <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">8</p>
        </div>
    </div>

    <x-slot name="scripts">
        <!-- Custom scripts -->
        <script>
            // Custom dashboard scripts
        </script>
    </x-slot>
</x-app-layout>