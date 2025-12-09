<x-app-layout title="Absensi Ustadzah - TPA Al Muhajirin">
    <x-slot name="head">
        <!-- Custom head content -->
        <meta name="description" content="Absensi Ustadz/Ustadzah TPA Al Muhajirin">
    </x-slot>

    <!-- Page Content -->
    <div class="mb-6">
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
        
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Absensi</h1>
        <p class="text-gray-600 dark:text-gray-400">Selamat datang di TPA Al Muhajirin</p>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
        <form method="POST" action="{{ route('absen.store') }}">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Nama
                    Ustadz/Ustadzah</label>
                <input type="text" id="name" name="name" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
            </div>
            <div class="mb-4">
                <label for="date" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Tanggal</label>
                <input type="date" id="date" name="date" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
            </div>
            <div class="mb-4">
                <label for="status" class="block text-gray-700 dark:text-gray-300 font-semibold mb-2">Status</label>
                <select id="status" name="status" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                    <option value="Hadir">Hadir</option>
                    <option value="Izin">Izin</option>
                    <option value="Sakit">Sakit</option>
                    <option value="Alpa">Alpa</option>
                </select>
            </div>
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Submit</button>
        </form>
    </div>

</x-app-layout>
