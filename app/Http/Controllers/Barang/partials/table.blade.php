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
        <td colspan="5" class="text-center py-4">Tidak ada barang ditemukan</td>
    </tr>
@endforelse