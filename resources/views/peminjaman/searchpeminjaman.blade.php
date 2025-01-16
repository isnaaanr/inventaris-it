<thead>
    <tr>
        <th>No</th>
        <th>Nama Barang</th>
        <th>Jenis</th>
        <th>Jumlah</th>
        <th>Aksi</th>
    </tr>
</thead>
<tbody>
    @forelse($peminjamanResults as $barang)
        <tr id="row-{{ $barang->id }}">
            <td>{{ $loop->index + 1 }}</td>
            <td>{{ $barang->nama }}</td>
            <td>{{ $barang->jenis }}</td>
            <td>
                <input type="number" 
                       value="{{ $keranjang[$barang->id] ?? 1 }}" 
                       min="1" 
                       onchange="updateJumlah('{{ $barang->id }}', this.value)">
            </td>
            <td>
                <form action="{{ route('peminjaman.remove', $barang->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="text-center">Barang tidak ditemukan dalam keranjang.</td>
        </tr>
    @endforelse
</tbody>

