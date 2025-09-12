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
        @php
            $totalSantri = \App\Models\Santri::count();
            $totalUstadz = \App\Models\Ustadz::count();
            $totalClass = \App\Models\TpaClass::count();
        @endphp
        <div
            class="p-6 bg-white dark:bg-neutral-900 rounded-2xl shadow-sm border border-gray-200 dark:border-neutral-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Total Santri</h3>
            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $totalSantri }}</p>
        </div>

        <div
            class="p-6 bg-white dark:bg-neutral-900 rounded-2xl shadow-sm border border-gray-200 dark:border-neutral-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Ustadz</h3>
            <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $totalUstadz }}</p>
        </div>

        <div
            class="p-6 bg-white dark:bg-neutral-900 rounded-2xl shadow-sm border border-gray-200 dark:border-neutral-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Kelas Aktif</h3>
            <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $totalClass }}</p>
        </div>
    </div>

    <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-2 2xl:grid-cols-2">
        {{-- Card Grafik Mingguan --}}
        <div
            class="mt-8 bg-white dark:bg-neutral-900 rounded-2xl shadow-sm border border-gray-200 dark:border-neutral-700 p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Pertumbuhan Santri (Per Minggu)</h3>
            <div id="santri-growth-weekly" class="w-full h-72"></div>
        </div>
    
        {{-- Card Grafik Bulanan --}}
        <div
            class="mt-8 bg-white dark:bg-neutral-900 rounded-2xl shadow-sm border border-gray-200 dark:border-neutral-700 p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Pertumbuhan Santri (Per Bulan)</h3>
            <div id="santri-growth-monthly" class="w-full h-72"></div>
        </div>
    
        {{-- Card Grafik Tahunan --}}
        <div
            class="mt-8 bg-white dark:bg-neutral-900 rounded-2xl shadow-sm border border-gray-200 dark:border-neutral-700 p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Pertumbuhan Santri (Per Tahun)</h3>
            <div id="santri-growth-yearly" class="w-full h-72"></div>
        </div>
    </div>



    <x-slot name="scripts">
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const weekly = @json($growthWeekly);
                const monthly = @json($growthMonthly);
                const yearly = @json($growthYearly);

                function renderChart(el, data, title, color) {
                    const options = {
                        chart: {
                            type: 'line',
                            height: 300,
                            toolbar: {
                                show: false
                            }
                        },
                        series: [{
                            name: title,
                            data: data.map(i => i.total)
                        }],
                        xaxis: {
                            categories: data.map(i => i.period)
                        },
                        colors: [color],
                        stroke: {
                            curve: 'smooth',
                            width: 3
                        },
                        markers: {
                            size: 4
                        },
                        grid: {
                            borderColor: '#E5E7EB'
                        }
                    };
                    new ApexCharts(document.querySelector(el), options).render();
                }

                renderChart("#santri-growth-weekly", weekly, "Mingguan", "#F59E0B"); // amber-500
                renderChart("#santri-growth-monthly", monthly, "Bulanan", "#3B82F6"); // blue-500
                renderChart("#santri-growth-yearly", yearly, "Tahunan", "#10B981"); // green-500
            });
        </script>
    </x-slot>

</x-app-layout>
