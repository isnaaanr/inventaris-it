<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Informasi Statistik -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Total Users -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Total Barang</h3>
                    <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400 mt-2">500</p>
                    <p class="text-sm text-gray-500 dark:text-gray-300">Jumlah total barang yang tersedia.</p>
                </div>

                <!-- Active Sessions -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Barang dipinjam</h3>
                    <p class="text-2xl font-bold text-green-600 dark:text-green-400 mt-2">120</p>
                    <p class="text-sm text-gray-500 dark:text-gray-300">Jumlah barang yang sedang dipinjam.</p>
                </div>

                <!-- Pending Tasks -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Barang dikembalikan</h3>
                    <p class="text-2xl font-bold text-red-600 dark:text-red-400 mt-2">25</p>
                    <p class="text-sm text-gray-500 dark:text-gray-300">Jumlah barang yang telah dikembalikan.</p>
                </div>
            </div>

            <!-- Grafik Status Barang -->
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Grafik Status Barang</h3>
                    <div class="mt-4">
                        <canvas id="inventoryChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- Peminjaman Tertinggi -->
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Peminjaman Tertinggi</h3>
                    <div class="mt-4">
                        <ul>
                            <li class="flex justify-between py-2 px-4 border-b border-gray-300 dark:border-gray-600">
                                <span>Item 1</span>
                                <span class="font-semibold">15 Peminjaman</span>
                            </li>
                            <li class="flex justify-between py-2 px-4 border-b border-gray-300 dark:border-gray-600">
                                <span>Item 2</span>
                                <span class="font-semibold">12 Peminjaman</span>
                            </li>
                            <li class="flex justify-between py-2 px-4 border-b border-gray-300 dark:border-gray-600">
                                <span>Item 3</span>
                                <span class="font-semibold">10 Peminjaman</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Pengembalian Terbaru -->
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Pengembalian Terbaru</h3>
                    <div class="mt-4">
                        <ul>
                            <li class="flex justify-between py-2 px-4 border-b border-gray-300 dark:border-gray-600">
                                <span>Item A</span>
                                <span class="font-semibold">Dikembalikan pada 2025-01-09</span>
                            </li>
                            <li class="flex justify-between py-2 px-4 border-b border-gray-300 dark:border-gray-600">
                                <span>Item B</span>
                                <span class="font-semibold">Dikembalikan pada 2025-01-08</span>
                            </li>
                            <li class="flex justify-between py-2 px-4 border-b border-gray-300 dark:border-gray-600">
                                <span>Item C</span>
                                <span class="font-semibold">Dikembalikan pada 2025-01-07</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-gray-800 text-white py-6 mt-8">
        <div class="container mx-auto flex flex-col items-center">
            <p class="text-sm text-center">&copy; 2025 Your Website. All rights reserved.</p>
            <div class="mt-4 flex space-x-6">
                <a href="#" class="text-gray-400 hover:text-white" aria-label="Privacy Policy">
                    Privacy Policy
                </a>
                <span class="text-gray-500">&middot;</span>
                <a href="#" class="text-gray-400 hover:text-white" aria-label="Terms &amp; Conditions">
                    Terms &amp; Conditions
                </a>
            </div>
        </div>
    </footer>

    <style>
        footer {
            position: relative;
            width: 100%;
            bottom: 0;
            
        }
    </style>
    
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('inventoryChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Tersedia', 'Sedang Dipinjam', 'Perlu Pemeliharaan'],
                    datasets: [{
                        label: 'Status Barang',
                        data: [30, 20, 10], // Data contoh
                        backgroundColor: ['#4CAF50', '#FF9800', '#F44336'],
                        borderColor: ['#4CAF50', '#FF9800', '#F44336'],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
</x-app-layout>
