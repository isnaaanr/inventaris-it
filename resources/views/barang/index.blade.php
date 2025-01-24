<x-app-layout>
    <div class="flex flex-col min-h-screen">
    <main class="container mx-auto px-8 py-8 bg-white text-gray-800 flex-grow">
        {{-- Tampilan Success --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
                <button type="button" class="absolute top-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">&times;</button>
            </div>
        @endif

        {{-- Tampilan Error --}}
        @if ($errors->any())
            <script>
                alert("{{ session('errors')->first() }}");
            </script>
        @endif

        <h1 class="text-center text-3xl font-bold m">Daftar Barang</h1>

        <div class="flex justify-between items-center mb-4">
            {{-- Form Pencarian --}}
            <form action="{{ route('barang.search') }}" method="GET" class="flex items-center space-x-2">
                <input type="text" name="search" class="border w-80 border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 ease-in-out" placeholder="Cari Barang..." value="{{ request('search') }}">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 transition duration-200 ease-in-out">
                    Cari
                </button>
            </form>
        
            {{-- Tombol Tambah Barang --}}
            <button type="button" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 transition duration-200 ease-in-out" data-modal-target="#tambahBarangModal">
                <i class="fa-solid fa-plus"></i> Tambah Barang
            </button>
        </div>
        
        

        <!-- Modal Tambah Barang -->
        <div class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" id="tambahBarangModal" tabindex="-1" aria-labelledby="tambahBarangModalLabel" aria-hidden="true">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                <div class="flex justify-between items-center border-b pb-4">
                    <h5 class="text-lg font-semibold">Tambah Data Barang</h5>
                    <button type="button" class="text-gray-500 hover:text-gray-700 text-2xl px-4 py-2" data-modal-dismiss>&times;</button>
                </div>
                <form action="{{ route('barang.store') }}" method="post" class="mt-4">
                    @csrf
                    <div class="mb-4">
                        <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" id="nama" name="nama" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <div class="mb-4">
                        <label for="jenis" class="block text-sm font-medium text-gray-700">Jenis</label>
                        <select id="jenis" name="jenis" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="Laptop">Laptop</option>
                            <option value="Kamera">Kamera</option>
                            <option value="Aksesoris">Aksesoris</option>
                            <option value="Proyektor">Proyektor</option>
                            <option value="Monitor">Monitor</option>
                            <option value="Penyimpanan">Penyimpanan</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
                        <input type="number" id="stok" min="1" name="stok" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tambah</button>
                </form>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto mt-6">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg text-center">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-200">
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">Nama Barang</th>
                        <th class="px-4 py-2">Jenis</th>
                        <th class="px-4 py-2">Stok</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = $data->firstItem();
                    @endphp
                    @forelse ($data as $item)
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-2">{{ $no++ }}</td>
                            <td class="px-4 py-2">{{ $item->nama }}</td>
                            <td class="px-4 py-2">{{ $item->jenis }}</td>
                            <td class="px-4 py-2">
                                @if($item->stok > 0)
                                    {{ $item->stok }}
                                @else
                                    <span class="text-red-600 font-bold">Kosong</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <div class="flex justify-center gap-2">
                                    <button type="button" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600" data-modal-target="#ubahBarangModal{{ $item->id }}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <form action="{{ route('barang.delete', ['id' => $item->id]) }}" method="post" onsubmit="return confirm('yakin akan menghapus data ini?')">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>

                            <!-- Modal Edit Barang -->
                            <div class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" id="ubahBarangModal{{ $item->id }}" tabindex="-1">
                                <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                                    <div class="flex justify-between items-center border-b pb-4">
                                        <h5 class="text-lg font-semibold">Ubah Data Barang</h5>
                                        <button type="button" class="text-gray-500 hover:text-gray-700 text-2xl px-4 py-2" onclick="document.getElementById('ubahBarangModal{{ $item->id }}').classList.add('hidden')">&times;</button>
                                    </div>
                                    <form action="{{ route('barang.update', ['id' => $item->id]) }}" method="post" class="mt-4">
                                        @csrf
                                        @method('put')
                                        <div class="mb-4">
                                            <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                                            <input type="text" id="nama" name="nama" value="{{ $item->nama }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="jenis" class="block text-sm font-medium text-gray-700">Jenis</label>
                                            <select id="jenis" name="jenis" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                                @foreach(['Laptop', 'Kamera', 'Aksesoris', 'Proyektor', 'Monitor', 'Penyimpanan', 'Lainnya'] as $jenis)
                                                    <option value="{{ $jenis }}" {{ $item->jenis == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
                                            <input type="number" id="stok" name="stok" value="{{ $item->stok }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                        </div>
                                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Ubah</button>
                                    </form>
                                </div>
                            </div>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">Tidak ada barang</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">{{ $data->links() }}</div>
        </div>
        
    </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

        document.querySelectorAll('[data-modal-target]').forEach(button => {
            button.addEventListener('click', () => {
                const modalId = button.getAttribute('data-modal-target');
                document.querySelector(modalId).classList.remove('hidden');
            });
        });

        document.querySelectorAll('[data-modal-dismiss]').forEach(button => {
            button.addEventListener('click', () => {
                const modal = button.closest('.fixed');
                modal.classList.add('hidden');
            });
        });

    </script>
</x-app-layout>