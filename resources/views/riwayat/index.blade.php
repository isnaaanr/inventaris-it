<x-app-layout>

    <div class="container mx-auto px-4 py-4">
        <div class="mt-3">
            <h1 class="text-center text-3xl font-semibold">Riwayat Peminjaman</h1>
        </div>

        <!-- Input Search -->
        <div class="mt-4 flex justify-center">
            <input type="text" id="searchInput" placeholder="Cari berdasarkan nama, unit, atau keperluan..." class="w-full max-w-md px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <ul class="flex space-x-2 mt-3 border-b-2">
            <li>
                <button class="text-blue-500 py-2 px-4 rounded-t-lg font-semibold focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50" id="sedang-proses-tab" onclick="showSection('sedang-proses-section')">Sedang Proses</button>
            </li>
            <li>
                <button class="text-blue-500 py-2 px-4 rounded-t-lg font-semibold focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50" id="riwayat-tab2" onclick="showSection('riwayat-section')">Riwayat</button>
            </li>
        </ul>        

        <!-- Sedang Proses Section -->
        <div id="sedang-proses-section" class="mt-3">
            <h2 class="text-2xl font-semibold">Sedang Proses</h2>
            @if($peminjamans->where('tanggal_kembali', null)->isEmpty())
                <p class="text-red-500">Tidak ada peminjaman yang sedang berjalan.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4" id="sedang-proses-list">
                    @foreach($peminjamans->where('tanggal_kembali', null) as $peminjaman)
                        <div class="peminjaman-item bg-white shadow-lg rounded-lg p-4 cursor-pointer border border-gray-300 hover:border-blue-500 transition duration-300 ease-in-out" data-search="{{ strtolower($peminjaman->nama_peminjam . ' ' . $peminjaman->unit . ' ' . $peminjaman->keperluan) }}" onclick="openModal('peminjamanModal{{ $peminjaman->id }}')">
                            <h5 class="text-xl font-bold">{{ $peminjaman->keperluan }}</h5>
                            <p class="text-gray-600">Tanggal Peminjaman: {{ $peminjaman->tanggal_peminjaman }}</p>
                            <p class="text-red-500 font-bold">Belum Dikembalikan</p>
                        </div>

                        <!-- Modal Detail Peminjaman -->
                        <div id="peminjamanModal{{ $peminjaman->id }}" class="modal hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                            <div class="bg-white rounded-lg shadow-xl w-11/12 max-w-4xl">
                                <div class="flex justify-between items-center p-4 border-b">
                                    <h5 class="text-xl font-semibold">Detail Peminjaman</h5>
                                    <button type="button" class="text-gray-500 hover:text-gray-700 text-2xl px-4 py-2" onclick="closeModal('peminjamanModal{{ $peminjaman->id }}')">&times;</button>
                                </div>
                                <div class="p-6">
                                    <p><strong>Nama Peminjam:</strong> {{ $peminjaman->nama_peminjam }}</p>
                                    <p><strong>Unit:</strong> {{ $peminjaman->unit }}</p>
                                    <p><strong>Keperluan:</strong> {{ $peminjaman->keperluan }}</p>
                                    <p><strong>Tempat:</strong> {{ $peminjaman->tempat }}</p>
                                    <p><strong>Tanggal Peminjaman:</strong> {{ $peminjaman->tanggal_peminjaman }}</p>
                                    <p><strong>Tanggal Kembali:</strong> 
                                        @if ($peminjaman->tanggal_kembali)
                                            {{ $peminjaman->tanggal_kembali }}
                                        @else
                                            <span class="text-red-500 font-bold">Belum Dikembalikan</span>
                                        @endif
                                    </p>

                                    <h4 class="text-lg font-semibold mt-4">Barang yang Dipinjam:</h4>
                                    <table class="w-full table-auto mt-4 border-collapse">
                                        <thead>
                                            <tr>
                                                <th class="border px-4 py-2">Nama Barang</th>
                                                <th class="border px-4 py-2">Jumlah Dipinjam</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($peminjaman->keranjang as $keranjang)
                                                <tr>
                                                    <td class="border px-4 py-2 text-center">{{ $keranjang->barang->nama }}</td>
                                                    <td class="border px-4 py-2 text-center">{{ $keranjang->jumlah_peminjaman }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <div class="flex mt-4 space-x-3">
                                        @if (is_null($peminjaman->tanggal_kembali))
                                            <form action="{{ route('riwayat.pengembalian', $peminjaman->id) }}" method="GET" onsubmit="return confirm('Yakin ingin menyelesaikan peminjaman ini?')">
                                                @csrf
                                                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded transition duration-300 transform hover:bg-blue-600 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                                                    <i class="fas fa-undo mr-2"></i> Kembalikan
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('riwayat.cetak-pdf', $peminjaman->id) }}" class="bg-green-500 text-white py-2 px-4 rounded transition duration-300 transform hover:bg-green-600 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-green-400">
                                            <i class="fas fa-file-pdf mr-2"></i> Cetak PDF
                                        </a>
                                    </div>                                                                 
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Riwayat Section -->
        <div id="riwayat-section" class="mt-3 hidden">
            <h2 class="text-2xl font-semibold">Riwayat</h2>
            @if($peminjamans->where('tanggal_kembali', '!=', null)->isEmpty())
                <p class="text-red-500">Tidak ada riwayat peminjaman.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4" id="riwayat-list">
                    @foreach($peminjamans->where('tanggal_kembali', '!=', null) as $peminjaman)
                        <div class="peminjaman-item bg-white shadow-lg rounded-lg p-4 border border-gray-300 hover:border-blue-500 transition duration-300 ease-in-out" data-search="{{ strtolower($peminjaman->nama_peminjam . ' ' . $peminjaman->unit . ' ' . $peminjaman->keperluan) }}">
                            <h5 class="text-xl font-bold">{{ $peminjaman->keperluan }}</h5>
                            <p class="text-gray-600">Tanggal Peminjaman: {{ $peminjaman->tanggal_peminjaman }}</p>
                            <p class="text-gray-600">Tanggal Kembali: {{ $peminjaman->tanggal_kembali }}</p>
                            <div class="flex flex-row mt-2">
                                <button type="button" class="bg-blue-500 text-white py-2 px-4 rounded mt-2 transition duration-300 transform hover:bg-blue-600 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400 mr-4" onclick="openModal('peminjamanModal{{ $peminjaman->id }}')">
                                    <i class="fas fa-info-circle mr-2"></i> Detail
                                </button>
                                <form action="{{ route('riwayat.delete', $peminjaman->id) }}?section=riwayat-section" method="POST" onsubmit="event.stopPropagation();">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded mt-2 transition duration-300 transform hover:bg-red-600 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-red-400" onclick="return confirm('Yakin ingin menghapus riwayat ini?')">
                                        <i class="fas fa-trash-alt mr-2"></i> Hapus
                                    </button>                                 
                                </form>
                            </div>                            
                        </div>

                        <!-- Modal Detail Peminjaman -->
                        <div id="peminjamanModal{{ $peminjaman->id }}" class="modal hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                            <div class="bg-white rounded-lg shadow-xl w-11/12 max-w-4xl">
                                <div class="flex justify-between items-center p-4 border-b">
                                    <h5 class="text-xl font-semibold">Detail Peminjaman</h5>
                                    <button type="button" class="text-gray-500 hover:text-gray-700 text-2xl px-4 py-2" onclick="closeModal('peminjamanModal{{ $peminjaman->id }}')">&times;</button>
                                </div>
                                <div class="p-6">
                                    <p><strong>Nama Peminjam:</strong> {{ $peminjaman->nama_peminjam }}</p>
                                    <p><strong>Unit:</strong> {{ $peminjaman->unit }}</p>
                                    <p><strong>Keperluan:</strong> {{ $peminjaman->keperluan }}</p>
                                    <p><strong>Tempat:</strong> {{ $peminjaman->tempat }}</p>
                                    <p><strong>Tanggal Peminjaman:</strong> {{ $peminjaman->tanggal_peminjaman }}</p>
                                    <p><strong>Tanggal Kembali:</strong> 
                                        @if ($peminjaman->tanggal_kembali)
                                            {{ $peminjaman->tanggal_kembali }}
                                        @else
                                            <span class="text-red-500 font-bold">Belum Dikembalikan</span>
                                        @endif
                                    </p>

                                    <h4 class="text-lg font-semibold mt-4">Barang yang Dipinjam:</h4>
                                    <table class="w-full table-auto mt-4 border-collapse">
                                        <thead>
                                            <tr>
                                                <th class="border px-4 py-2">Nama Barang</th>
                                                <th class="border px-4 py-2">Jumlah Dipinjam</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($peminjaman->keranjang as $keranjang)
                                                <tr>
                                                    <td class="border px-4 py-2 text-center">{{ $keranjang->barang->nama }}</td>
                                                    <td class="border px-4 py-2 text-center">{{ $keranjang->jumlah_peminjaman }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    
                                    <div class="flex mt-4 space-x-3">
                                        <a href="{{ route('riwayat.cetak-pdf', $peminjaman->id) }}" class="bg-green-500 text-white py-2 px-4 rounded transition duration-300 transform hover:bg-green-600 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-green-400">
                                            <i class="fas fa-file-pdf mr-2"></i> Cetak PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

    <script>
        function showSection(section) {
            document.getElementById('sedang-proses-section').classList.toggle('hidden', section !== 'sedang-proses-section');
            document.getElementById('riwayat-section').classList.toggle('hidden', section !== 'riwayat-section');

            document.getElementById('sedang-proses-tab').classList.remove('bg-blue-700', 'text-white');
            document.getElementById('riwayat-tab2').classList.remove('bg-blue-700', 'text-white');

            if (section === 'sedang-proses-section') {
                document.getElementById('sedang-proses-tab').classList.add('bg-blue-700', 'text-white');
            } else {
                document.getElementById('riwayat-tab2').classList.add('bg-blue-700', 'text-white');
            }
        }

        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        document.getElementById('searchInput').addEventListener('input', function() {
            const searchQuery = this.value.trim().toLowerCase();
            const sections = ['sedang-proses-section', 'riwayat-section'];

            sections.forEach(section => {
                const items = document.querySelectorAll(`#${section} .peminjaman-item`);
                items.forEach(item => {
                    const searchText = item.getAttribute('data-search');
                    if (searchText.includes(searchQuery)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    </script>

</x-app-layout>
