<x-app-layout>

    <div class="container mx-auto px-4 py-4">
        <div class="mt-3">
            <h1 class="text-center text-3xl font-semibold">Riwayat Peminjaman</h1>
        </div>
    
        <ul class="flex space-x-4 mt-3 border-b-2">
            <li>
                <button class="text-blue-500 py-2 px-4 hover:text-blue-700 focus:outline-none" id="sedang-proses-tab" onclick="showSection('sedang-proses-section')">Sedang Proses</button>
            </li>
            <li>
                <button class="text-blue-500 py-2 px-4 hover:text-blue-700 focus:outline-none" id="riwayat-tab2" onclick="showSection('riwayat-section')">Riwayat</button>
            </li>
        </ul>
    
        <!-- Sedang Proses Section -->
        <div id="sedang-proses-section" class="mt-3">
            <h2 class="text-2xl font-semibold">Sedang Proses</h2>
            @if($peminjamans->where('tanggal_kembali', null)->isEmpty())
                <p class="text-red-500">Tidak ada peminjaman yang sedang berjalan.</p>
            @else
                @foreach($peminjamans->where('tanggal_kembali', null) as $peminjaman)
                    <div class="bg-white shadow-md rounded-lg mb-4 mt-4 p-4 cursor-pointer" onclick="openModal('peminjamanModal{{ $peminjaman->id }}')">
                        <div class="flex justify-between items-center">
                            <div>
                                <h5 class="text-xl font-bold">{{ $peminjaman->keperluan }}</h5>
                                <p class="text-gray-600">Tanggal Peminjaman: {{ $peminjaman->tanggal_peminjaman }}</p>
                                <p class="text-red-500 font-bold">Belum Dikembalikan</p>
                            </div>
    
                            <div class="flex flex-row">
                                <button type="button" class="bg-blue-500 text-white py-2 px-4 rounded mt-2 transition duration-300 transform hover:bg-blue-600 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400" onclick="openModal('peminjamanModal{{ $peminjaman->id }}')">
                                    Detail
                                </button>                                
                            </div>
                        </div>
                    </div>
    
                    <!-- Modal Detail Peminjaman -->
                    <div id="peminjamanModal{{ $peminjaman->id }}" class="modal hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                        <div class="bg-white rounded-lg shadow-xl w-11/12 max-w-4xl">
                            <div class="flex justify-between items-center p-4 border-b">
                                <h5 class="text-xl font-semibold">Detail Peminjaman</h5>
                                <button type="button" class="text-gray-500" onclick="closeModal('peminjamanModal{{ $peminjaman->id }}')">&times;</button>
                            </div>
                            <div class="p-6">
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
                                                Kembalikan
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('riwayat.cetak-pdf', $peminjaman->id) }}" class="bg-green-500 text-white py-2 px-4 rounded transition duration-300 transform hover:bg-green-600 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-green-400">
                                        Cetak PDF
                                    </a>
                                </div>                                
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    
        <!-- Riwayat Section -->
        <div id="riwayat-section" class="mt-3 hidden">
            <h2 class="text-2xl font-semibold">Riwayat</h2>
            @if($peminjamans->where('tanggal_kembali', '!=', null)->isEmpty())
                <p class="text-red-500">Tidak ada riwayat peminjaman.</p>
            @else
                @foreach($peminjamans->where('tanggal_kembali', '!=', null) as $peminjaman)
                    <div class="bg-white shadow-md rounded-lg mb-4 mt-4 p-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <h5 class="text-xl font-bold">{{ $peminjaman->keperluan }}</h5>
                                <p class="text-gray-600">Tanggal Peminjaman: {{ $peminjaman->tanggal_peminjaman }}</p>
                                <p class="text-gray-600">Tanggal Kembali: {{ $peminjaman->tanggal_kembali }}</p>
                            </div>
    
                            <div class="flex flex-row">
                                <button type="button" class="bg-blue-500 text-white py-2 px-4 rounded mt-2 transition duration-300 transform hover:bg-blue-600 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-400 mr-4" onclick="openModal('peminjamanModal{{ $peminjaman->id }}')">Detail</button>
                                <form action="{{ route('riwayat.delete', $peminjaman->id) }}?section=riwayat-section" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded mt-2 transition duration-300 transform hover:bg-red-600 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-red-400" onclick="return confirm('Yakin ingin menghapus riwayat ini?')">
                                        Hapus
                                    </button>                                    
                                </form>
                            </div>
                        </div>
                    </div>
    
                    <!-- Modal Detail Peminjaman -->
                    <div id="peminjamanModal{{ $peminjaman->id }}" class="modal hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                        <div class="bg-white rounded-lg shadow-xl w-11/12 max-w-4xl">
                            <div class="flex justify-between items-center p-4 border-b">
                                <h5 class="text-xl font-semibold">Detail Peminjaman</h5>
                                <button type="button" class="text-gray-500" onclick="closeModal('peminjamanModal{{ $peminjaman->id }}')">&times;</button>
                            </div>
                            <div class="p-6">
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
                                                <td class="border px-4 py-2">{{ $keranjang->barang->nama }}</td>
                                                <td class="border px-4 py-2">{{ $keranjang->jumlah_peminjaman }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
    
                                <div class="flex mt-4">
                                    @if (is_null($peminjaman->tanggal_kembali))
                                        <form action="{{ route('riwayat.pengembalian', $peminjaman->id) }}" method="GET" onsubmit="return confirm('Yakin ingin menyelesaikan peminjaman ini?')">
                                            @csrf
                                            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded mr-3">Kembalikan</button>
                                        </form>
                                    @endif
                                    <a href="{{ route('riwayat.cetak-pdf', $peminjaman->id) }}" class="bg-green-500 text-white py-2 px-4 rounded transition duration-300 transform hover:bg-green-600 hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-green-400">
                                        Cetak PDF
                                    </a>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <script>
        function showSection(section) {
            var sections = ['sedang-proses-section', 'riwayat-section'];
            sections.forEach(function(sec) {
                document.getElementById(sec).classList.toggle('hidden', sec !== section);
            });

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
    </script>

</x-app-layout>
